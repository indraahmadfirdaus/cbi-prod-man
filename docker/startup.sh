#!/bin/bash

# Start SQL Server in background
/opt/mssql/bin/sqlservr &

# Wait for SQL Server to be ready
echo "Waiting for SQL Server to start..."
for i in {1..50};
do
    /opt/mssql-tools18/bin/sqlcmd -S localhost -U sa -P "$MSSQL_SA_PASSWORD" -C -Q "SELECT 1" > /dev/null 2>&1
    if [ $? -eq 0 ]; then
        echo "SQL Server is ready!"
        break
    fi
    echo "Waiting... ($i/50)"
    sleep 2
done

# Run initialization script
echo "Running database initialization..."
/opt/mssql-tools18/bin/sqlcmd -S localhost -U sa -P "$MSSQL_SA_PASSWORD" -C -i /docker-entrypoint-initdb.d/init-db.sql

if [ $? -eq 0 ]; then
    echo "Database initialization completed successfully!"
else
    echo "Database initialization failed!"
fi

# Keep SQL Server running in foreground
wait