#!/bin/bash

echo "🚀 Starting deployment..."

# Stop and remove containers
echo "📦 Stopping containers..."
sudo docker-compose down -v

# Remove old images to ensure fresh build
echo "🗑️  Cleaning up old images..."
sudo docker-compose build --no-cache

# Start services
echo "🔄 Starting services..."
sudo docker-compose up -d

# Wait for SQL Server to be healthy
echo "⏳ Waiting for SQL Server to be ready..."
while ! sudo docker-compose exec -T sqlserver /opt/mssql-tools18/bin/sqlcmd -S localhost -U sa -P "YourStrong@Passw0rd123" -C -Q "SELECT 1 FROM cbi_prod_man.dbo.kategori" > /dev/null 2>&1; do
    echo "   Still waiting for database..."
    sleep 5
done

echo "✅ Database is ready!"
echo "🌐 Application is available at: http://localhost:8080"
echo "📊 You can also access: https://web.cbi-prod-man.orb.local (if configured in hosts)"

# Show logs
echo "📋 Recent logs:"
sudo docker-compose logs --tail=20