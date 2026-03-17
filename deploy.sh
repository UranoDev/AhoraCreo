#!/bin/bash
set -e

# ===========================================
# CONFIGURATION - Change these values
# ===========================================
DOMAIN="ahoracreo.com"
GIT_BRANCH="master"

# Derived paths (Plesk standard)
VHOST_DIR="/var/www/vhosts/$DOMAIN"
APP_DIR="$VHOST_DIR/httpdocs"
ENV_BACKUP_DIR="$VHOST_DIR/env-backups"
PLESK_USER=$(stat -c '%U' "$VHOST_DIR" 2>/dev/null || echo "www-data")
PLESK_GROUP="psacln"

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}  Deploying $DOMAIN                    ${NC}"
echo -e "${GREEN}========================================${NC}"

cd "$APP_DIR"

# -------------------------------------------
# Backup .env before deploy
# -------------------------------------------
echo ""
echo -e "${YELLOW}[1/9] Backing up .env...${NC}"
mkdir -p "$ENV_BACKUP_DIR"
if [ -f .env ]; then
    BACKUP_NAME=".env.$(date +%Y%m%d_%H%M%S)"
    cp .env "$ENV_BACKUP_DIR/$BACKUP_NAME"
    echo -e "${GREEN}  Backup saved: $ENV_BACKUP_DIR/$BACKUP_NAME${NC}"

    # Keep only last 10 backups
    ls -t "$ENV_BACKUP_DIR"/.env.* 2>/dev/null | tail -n +11 | xargs -r rm
    BACKUP_COUNT=$(ls "$ENV_BACKUP_DIR"/.env.* 2>/dev/null | wc -l)
    echo -e "${GREEN}  Total backups: $BACKUP_COUNT (max 10)${NC}"
else
    echo -e "${RED}  No .env found to backup.${NC}"
fi

# -------------------------------------------
# Pull latest changes
# -------------------------------------------
echo ""
echo -e "${YELLOW}[2/9] Pulling latest changes...${NC}"
git stash --quiet 2>/dev/null || true
git pull origin "$GIT_BRANCH"
git stash pop --quiet 2>/dev/null || true

# -------------------------------------------
# Check for new .env variables
# -------------------------------------------
echo ""
echo -e "${YELLOW}[3/9] Checking for new .env variables...${NC}"
if [ -f .env ] && [ -f .env.example ]; then
    MISSING_VARS=""
    while IFS= read -r line; do
        if [[ "$line" =~ ^[A-Z_]+= ]]; then
            VAR_NAME=$(echo "$line" | cut -d '=' -f1)
            if ! grep -q "^$VAR_NAME=" .env; then
                MISSING_VARS="$MISSING_VARS\n    - $VAR_NAME"
            fi
        fi
    done < .env.example

    if [ -n "$MISSING_VARS" ]; then
        echo -e "${YELLOW}  New variables found in .env.example not in .env:${NC}"
        echo -e "${YELLOW}$MISSING_VARS${NC}"
        echo -e "${YELLOW}  Add them to .env: nano $APP_DIR/.env${NC}"
    else
        echo -e "${GREEN}  All variables are in sync.${NC}"
    fi
else
    echo -e "${YELLOW}  Skipped (.env or .env.example missing).${NC}"
fi

# -------------------------------------------
# Install dependencies and build assets
# -------------------------------------------
echo ""
echo -e "${YELLOW}[4/9] Installing PHP dependencies...${NC}"
composer install --optimize-autoloader

echo ""
echo -e "${YELLOW}[5/9] Building frontend assets...${NC}"
npm install
npm run build

# -------------------------------------------
# Run migrations and seed
# -------------------------------------------
echo ""
echo -e "${YELLOW}[6/9] Running migrations...${NC}"
php artisan migrate --force
php artisan db:seed --force

# Remove dev dependencies
echo ""
echo -e "${YELLOW}[7/9] Removing dev dependencies...${NC}"
composer install --optimize-autoloader --no-dev

# -------------------------------------------
# Validate PDF book file
# -------------------------------------------
echo ""
echo -e "${YELLOW}[8/9] Checking PDF book file...${NC}"

BOOK_DIR=$(grep "^BOOK_PDF_DIRECTORY=" .env | cut -d '=' -f2- | tr -d '"')
BOOK_FILE=$(grep "^BOOK_PDF_FILENAME=" .env | cut -d '=' -f2- | tr -d '"')

BOOK_DIR=${BOOK_DIR:-books}
BOOK_FILE=${BOOK_FILE:-free-book.pdf}

BOOK_PATH="storage/app/$BOOK_DIR/$BOOK_FILE"

if [ -f "$BOOK_PATH" ]; then
    FILESIZE=$(du -h "$BOOK_PATH" | cut -d$'\t' -f1)
    echo -e "${GREEN}  PDF found: $BOOK_FILE ($FILESIZE)${NC}"
else
    echo -e "${RED}  WARNING: PDF not found at $BOOK_PATH${NC}"
    PDF_COUNT=$(find "storage/app/$BOOK_DIR" -name "*.pdf" 2>/dev/null | wc -l)
    if [ "$PDF_COUNT" -gt 0 ]; then
        echo -e "${YELLOW}  Found $PDF_COUNT PDF(s) in directory:${NC}"
        find "storage/app/$BOOK_DIR" -name "*.pdf" -exec echo "    - {}" \;
        echo -e "${YELLOW}  Check BOOK_PDF_FILENAME in .env${NC}"
    else
        echo -e "${RED}  No PDFs found. Upload to: $APP_DIR/$BOOK_PATH${NC}"
    fi