#!/bin/bash

echo "🚀 Preparing for deployment..."

# Clear caches
echo "🧹 Clearing caches..."
php artisan optimize:clear

# Build assets
echo "📦 Building assets with Vite..."
npm run build

# Remove hot file if it exists (prevents local dev server links in production)
echo "🔥 Removing Vite hot file..."
rm -f public/hot

# Optimize for production
echo "⚡ Optimizing for production..."
php artisan optimize

echo "✅ Deployment package ready!"
echo "Next steps:"
echo "1. Zip the entire folder (excluding node_modules and vendor)."
echo "2. Upload to your cPanel root directory."
echo "3. Extract the zip file."
echo "4. Configure your .env file in cPanel."
echo "5. Run 'composer install --no-dev' if you have SSH access, or ensure vendor/ is uploaded."
