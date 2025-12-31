#!/bin/bash

echo "🚀 Starting deployment process..."

# 1. Pull latest code
echo "📥 Pulling latest code from Git..."
git pull origin main

# 2. Install/Update Composer dependencies
echo "📦 Installing Composer dependencies..."
composer install --optimize-autoloader --no-dev

# 3. Copy production environment file
echo "⚙️ Setting up production environment..."
cp .env.production .env

# 4. Generate application key if needed
echo "🔑 Generating application key..."
php artisan key:generate --force

# 5. Clear all caches
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# 6. Run database migrations
echo "🗄️ Running database migrations..."
php artisan migrate --force

# 7. Seed database if needed (uncomment if you want to seed)
# echo "🌱 Seeding database..."
# php artisan db:seed --force

# 8. Create storage link
echo "🔗 Creating storage link..."
php artisan storage:link

# 9. Set proper permissions
echo "🔒 Setting file permissions..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chmod -R 755 public/uploads

# 10. Cache configurations for production
echo "⚡ Caching configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Deployment completed successfully!"
echo "🌐 Your application is ready at: $(php artisan tinker --execute='echo config("app.url");')"