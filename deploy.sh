#!/bin/bash
# ============================================================
# EASYSOLVE — Deployment Script for cPanel Shared Hosting
# Run this via SSH after uploading files
# ============================================================

set -e

echo "🚀 Starting EASYSOLVE deployment..."
echo ""

# ─── 1. Navigate to the project directory ─────────────────
cd ~/easysolve
echo "✓ Working directory: $(pwd)"

# ─── 2. Install Composer dependencies (if vendor/ was not uploaded) ──
if [ ! -d "vendor" ]; then
    echo "📦 Installing Composer dependencies..."
    composer install --no-dev --optimize-autoloader --no-interaction
else
    echo "✓ vendor/ already exists, skipping composer install"
fi

# ─── 3. Create .env from production template ──────────────
if [ ! -f ".env" ]; then
    echo "📝 Creating .env from production template..."
    cp .env.production .env
    echo "⚠️  IMPORTANT: Edit .env with your real database credentials before continuing!"
    echo "   Run: nano .env"
    echo "   Then re-run this script."
    exit 1
else
    echo "✓ .env already exists"
fi

# ─── 4. Generate application key ──────────────────────────
echo "🔑 Generating application key..."
php artisan key:generate --force

# ─── 5. Create storage directories (if they don't exist) ──
echo "📁 Creating storage directories..."
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p storage/app/public

# ─── 6. Set permissions ───────────────────────────────────
echo "🔐 Setting permissions..."
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chmod -R 755 .

# ─── 7. Run database migrations ───────────────────────────
echo "🗄️  Running database migrations..."
php artisan migrate --force

# ─── 8. Seed the database (creates plans + super admin) ──
echo "🌱 Seeding database..."
php artisan db:seed --force

# ─── 9. Create storage symlink ────────────────────────────
echo "🔗 Creating storage symlink..."
php artisan storage:link

# ─── 10. Clear and cache config ────────────────────────────
echo "⚙️  Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

echo ""
echo "✅ DEPLOYMENT COMPLETE!"
echo ""
echo "🔐 Your super admin login:"
echo "   Email: admin@easysolve.com"
echo "   Password: (the SUPER_ADMIN_PASSWORD you set in .env)"
echo ""
echo "🌐 Visit your site: (check APP_URL in .env)"
echo ""
echo "⚠️  REMEMBER:"
echo "   1. Set APP_DEBUG=false in .env (already done in production template)"
echo "   2. Test the site in your browser"
echo "   3. Change the super admin password after first login"
echo ""
