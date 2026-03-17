#!/bin/bash
set -e

# ===========================================
# CONFIGURATION - Change these values
# ===========================================
DOMAIN="ahoracreo.com"
GIT_BRANCH="main"

# Derived paths (Plesk standard)
VHOST_DIR="/var/www/vhosts/$DOMAIN"
APP_DIR="$VHOST_DIR/httpdocs"
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
# Pull latest changes
# -------------------------------------------
echo ""
echo -e "${YELLOW}[1/7] Pulling latest changes...${NC}"
git pull origin "$GIT_BRANCH"

# -------------------------------------------
# Install dependencies
# -------------------------------------------
echo ""
echo -e "${YELLOW}[2/7] Installing PHP dependencies...${NC}"
composer install --optimize-autoloader --no-dev

echo ""
echo -e "${YELLOW}[3/7] Building frontend assets...${NC}"
npm install
npm run build

# -------------------------------------------
# Run migrations
# -------------------------------------------
echo ""
echo -e "${YELLOW}[4/7] Running migrations...${NC}"
php artisan migrate --force

# -------------------------------------------
# Validate PDF book file
# -------------------------------------------
echo ""
echo -e "${YELLOW}[5/7] Checking PDF book file...${NC}"

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
fi

# -------------------------------------------
# Set permissions
# -------------------------------------------
echo ""
echo -e "${YELLOW}[6/7] Setting permissions ($PLESK_USER:$PLESK_GROUP)...${NC}"
chown -R "$PLESK_USER":"$PLESK_GROUP" .
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# -------------------------------------------
# Cache optimization
# -------------------------------------------
echo ""
echo -e "${YELLOW}[7/7] Rebuilding cache...${NC}"
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# -------------------------------------------
# Done
# -------------------------------------------
echo ""
echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}  Deployment Complete! ($DOMAIN)       ${NC}"
echo -e "${GREEN}========================================${NC}"
echo ""