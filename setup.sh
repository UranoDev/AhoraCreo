#!/bin/bash
set -e

# ===========================================
# CONFIGURATION - Change these values
# ===========================================
DOMAIN="ahoracreo.com"
GIT_REPO="https://github.com/UranoDev/AhoraCreo.git"
GIT_BRANCH="master"

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
echo -e "${GREEN}  Initial Setup - $DOMAIN              ${NC}"
echo -e "${GREEN}========================================${NC}"

# -------------------------------------------
# Clone or pull repository
# -------------------------------------------
echo ""
echo -e "${YELLOW}[1/10] Setting up repository...${NC}"
echo -e "Looking for $APP_DIR/.git"
if [ -d "$APP_DIR/.git" ]; then
    echo -e "${GREEN}  Repository $APP_DIR/.git already exists. Pulling latest changes...${NC}"
    cd "$APP_DIR"
    git pull origin "$GIT_BRANCH"
else
    if [ -d "$APP_DIR" ] && [ "$(ls -A $APP_DIR 2>/dev/null)" ]; then
        echo -e "${RED}  ERROR: $APP_DIR exists and is not empty, but is not a git repo.${NC}"
        echo -e "${RED}  Remove or empty the directory first, then re-run this script.${NC}"
        exit 1
    fi
    echo -e "${GREEN}  Cloning repository...${NC}"
#    mkdir -p "$APP_DIR"
#    chown "$PLESK_USER":"$PLESK_GROUP" "$APP_DIR"
    git clone -b "$GIT_BRANCH" "$GIT_REPO" "$APP_DIR"
    cd "$APP_DIR"
fi

# -------------------------------------------
# Validate .env exists
# -------------------------------------------
echo ""
echo -e "${YELLOW}[2/10] Checking .env file...${NC}"
if [ ! -f .env ]; then
    if [ -f .env.example ]; then
        cp .env.example .env
        echo -e "${YELLOW}  .env created from .env.example. Please edit it with your production values.${NC}"
        echo -e "${RED}  Run: nano $APP_DIR/.env${NC}"
        echo -e "${RED}  Then re-run this script.${NC}"
        exit 1
    else
        echo -e "${RED}  ERROR: .env.example not found. Cannot continue.${NC}"
        exit 1
    fi
else
    echo -e "${GREEN}  .env file found.${NC}"
fi

# -------------------------------------------
# Install PHP dependencies
# -------------------------------------------
echo ""
echo -e "${YELLOW}[3/10] Installing PHP dependencies...${NC}"
composer install --optimize-autoloader --no-dev

# -------------------------------------------
# Install Node dependencies and build assets
# -------------------------------------------
echo ""
echo -e "${YELLOW}[4/10] Building frontend assets...${NC}"
npm install
chmod +x node_modules/.bin/*
npm run build

# -------------------------------------------
# Generate app key if not set
# -------------------------------------------
echo ""
echo -e "${YELLOW}[5/10] Checking app key...${NC}"
APP_KEY=$(grep "^APP_KEY=" .env | cut -d '=' -f2-)
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    php artisan key:generate
    echo -e "${GREEN}  App key generated.${NC}"
else
    echo -e "${GREEN}  App key already set.${NC}"
fi

# -------------------------------------------
# Run migrations and seed
# -------------------------------------------
echo ""
echo -e "${YELLOW}[6/10] Running migrations and seeders...${NC}"

# Install dev dependencies temporarily (Faker is needed for seeders)
composer install --optimize-autoloader

php artisan migrate --force
php artisan db:seed --force

# Remove dev dependencies
composer install --optimize-autoloader --no-dev

# -------------------------------------------
# Validate PDF book file
# -------------------------------------------
echo ""
echo -e "${YELLOW}[7/10] Checking PDF book file...${NC}"

BOOK_DIR=$(grep "^BOOK_PDF_DIRECTORY=" .env | cut -d '=' -f2- | tr -d '"')
BOOK_FILE=$(grep "^BOOK_PDF_FILENAME=" .env | cut -d '=' -f2- | tr -d '"')

BOOK_DIR=${BOOK_DIR:-books}
BOOK_FILE=${BOOK_FILE:-free-book.pdf}

BOOK_PATH="storage/app/$BOOK_DIR/$BOOK_FILE"

mkdir -p "storage/app/$BOOK_DIR"

if [ -f "$BOOK_PATH" ]; then
    FILESIZE=$(du -h "$BOOK_PATH" | cut -f1)
    echo -e "${GREEN}  PDF found: $BOOK_PATH ($FILESIZE)${NC}"
else
    PDF_COUNT=$(find "storage/app/$BOOK_DIR" -name "*.pdf" 2>/dev/null | wc -l)
    if [ "$PDF_COUNT" -gt 0 ]; then
        echo -e "${YELLOW}  WARNING: Expected '$BOOK_FILE' not found, but $PDF_COUNT PDF(s) found in storage/app/$BOOK_DIR/:${NC}"
        find "storage/app/$BOOK_DIR" -name "*.pdf" -exec echo "    - {}" \;
        echo -e "${YELLOW}  Check BOOK_PDF_FILENAME in .env matches your file.${NC}"
    else
        echo -e "${RED}  WARNING: No PDF found in storage/app/$BOOK_DIR/${NC}"
        echo -e "${RED}  Upload your PDF to: $APP_DIR/$BOOK_PATH${NC}"
    fi
fi

# -------------------------------------------
# Set permissions
# -------------------------------------------
echo ""
echo -e "${YELLOW}[8/10] Setting permissions ($PLESK_USER:$PLESK_GROUP)...${NC}"
chown -R "$PLESK_USER":"$PLESK_GROUP" .
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# -------------------------------------------
# Cache optimization
# -------------------------------------------
echo ""
echo -e "${YELLOW}[9/10] Optimizing for production...${NC}"
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# -------------------------------------------
# Setup Laravel cron job
# -------------------------------------------
echo ""
echo -e "${YELLOW}[10/10] Checking Laravel scheduler cron job...${NC}"

CRON_JOB="* * * * * cd $APP_DIR && php artisan schedule:run >> /dev/null 2>&1"
CRON_EXISTS=$(crontab -u "$PLESK_USER" -l 2>/dev/null | grep -F "php artisan schedule:run" | wc -l)

if [ "$CRON_EXISTS" -gt 0 ]; then
    echo -e "${GREEN}  Laravel cron job already configured.${NC}"
else
    (crontab -u "$PLESK_USER" -l 2>/dev/null; echo "$CRON_JOB") | crontab -u "$PLESK_USER" -
    echo -e "${GREEN}  Laravel cron job added for $PLESK_USER.${NC}"
fi

# -------------------------------------------
# Summary
# -------------------------------------------
echo ""
echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}  Setup Complete!                      ${NC}"
echo -e "${GREEN}========================================${NC}"
echo ""
echo -e "  Domain:   $DOMAIN"
echo -e "  App DIR:  $APP_DIR"
echo -e "  Owner:    $PLESK_USER:$PLESK_GROUP"
echo -e "  App URL:  $(grep '^APP_URL=' .env | cut -d '=' -f2-)"
echo -e "  App ENV:  $(grep '^APP_ENV=' .env | cut -d '=' -f2-)"
echo -e "  Debug:    $(grep '^APP_DEBUG=' .env | cut -d '=' -f2-)"
echo ""

if [ ! -f "$BOOK_PATH" ]; then
    echo -e "${RED}  ⚠ REMINDER: Upload your PDF to $APP_DIR/$BOOK_PATH${NC}"
    echo ""
fi

echo -e "  Admin login: $(grep '^APP_URL=' .env | cut -d '=' -f2-)/login"
echo -e "  Credentials: Check AdminSeeder.php (change in production!)"
echo ""
