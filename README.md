# CBI Production Management - CodeIgniter 4 Application

> **Note:** This application is a prototype for demonstration purposes.

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](https://codeigniter.com).

This repository holds a composer-installable app starter.
It has been built from the
[development repository](https://github.com/codeigniter4/CodeIgniter4).

More information about the plans for version 4 can be found in [CodeIgniter 4](https://forum.codeigniter.com/forumdisplay.php?fid=28) on the forums.

You can read the [user guide](https://codeigniter.com/user_guide/)
corresponding to the latest version of the framework.

## Technologies Used

- **Backend Framework:** CodeIgniter 4
- **PHP Version:** 8.2
- **Database:** Microsoft SQL Server 2022 Express
- **Web Server:** Apache 2.4
- **Containerization:** Docker & Docker Compose
- **Database Driver:** SQLSRV (Microsoft SQL Server PHP Extension)

## Requirements

### System Requirements
- **Docker** (version 20.10 or higher)
- **Docker Compose** (version 2.0 or higher)
- **Git** (for cloning the repository)

### PHP Requirements (handled by Docker)
PHP version 8.2 with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)
- [sqlsrv](https://docs.microsoft.com/en-us/sql/connect/php/microsoft-php-driver-for-sql-server) - Microsoft SQL Server PHP Driver
- [pdo_sqlsrv](https://docs.microsoft.com/en-us/sql/connect/php/pdo-sqlsrv-driver-reference) - PDO Driver for SQL Server
- json (enabled by default - don't turn it off)
- [libcurl](http://php.net/manual/en/curl.requirements.php) for HTTP\CURLRequest library
- gd, zip, bcmath, exif, pcntl extensions

> [!WARNING]
> - The end of life date for PHP 7.4 was November 28, 2022.
> - The end of life date for PHP 8.0 was November 26, 2023.
> - If you are still using PHP 7.4 or 8.0, you should upgrade immediately.
> - The end of life date for PHP 8.1 will be December 31, 2025.

## Installation

### 1. Clone the Repository
```bash
git clone <repository-url>
cd cbi-prod-man
```

### 2. Environment Setup
Copy the environment file and configure it:
```bash
cp env .env
```

Edit `.env` file and update the following variables:
```env
# Environment
CI_ENVIRONMENT = development

# App Configuration
app.baseURL = 'http://localhost:8080/'
app.forceGlobalSecureRequests = false
app.CSPEnabled = false

# SQL Server Database Configuration
database.default.hostname = sqlserver
database.default.database = cbi_prod_man
database.default.username = sa
database.default.password = 'YourStrong@Passw0rd123'
database.default.DBDriver = SQLSRV
database.default.DBPrefix = ''
database.default.port = 1433
database.default.encrypt = false
database.default.trustServerCertificate = true
```

### 3. Docker Installation

#### Install Docker (if not already installed)

**For macOS:**
```bash
# Install Docker Desktop from https://docker.com/products/docker-desktop
# Or using Homebrew:
brew install --cask docker
```

**For Ubuntu/Debian:**
```bash
sudo apt update
sudo apt install docker.io docker-compose
sudo systemctl start docker
sudo systemctl enable docker
```

**For CentOS/RHEL:**
```bash
sudo yum install docker docker-compose
sudo systemctl start docker
sudo systemctl enable docker
```

### 4. Build and Run the Application

#### Using the deployment script (recommended):
```bash
./deploy.sh
```

#### Or manually with Docker Compose:
```bash
# Build and start containers
docker-compose up -d --build

# Check container status
docker-compose ps

# View logs
docker-compose logs -f
```

### 5. Access the Application
Once the containers are running, access the application at:
- **Web Application:** http://localhost:8080
- **SQL Server Database:** localhost:1433 (from host machine)
  - Username: `sa`
  - Password: `YourStrong@Passw0rd123`
  - Database: `cbi_prod_man`

## Database Information

### SQL Server Configuration
- **Image:** mcr.microsoft.com/mssql/server:2022-latest
- **Edition:** Express (free)
- **Port:** 1433
- **Authentication:** SQL Server Authentication
- **Encryption:** Disabled for development
- **Trust Server Certificate:** True

### Connection Details
- **Server:** sqlserver (container name) or localhost:1433 (from host)
- **Database:** cbi_prod_man
- **Driver:** SQLSRV
- **PHP Extensions:** sqlsrv, pdo_sqlsrv

## API Documentation

### Base URL
```
http://localhost:8080/api
```

### Authentication
This prototype uses session-based authentication. No API keys required for development.

### Available Endpoints

#### Categories (Kategori)

**GET /api/kategori**
- Description: Get all categories
- Response:
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "nama_kategori": "Electronics",
      "deskripsi": "Electronic products",
      "created_at": "2024-01-01 10:00:00",
      "updated_at": "2024-01-01 10:00:00"
    }
  ]
}
```

**GET /api/kategori/{id}**
- Description: Get category by ID
- Parameters: `id` (integer) - Category ID

**POST /api/kategori**
- Description: Create new category
- Body:
```json
{
  "nama_kategori": "New Category",
  "deskripsi": "Category description"
}
```

**PUT /api/kategori/{id}**
- Description: Update category
- Parameters: `id` (integer) - Category ID
- Body: Same as POST

**DELETE /api/kategori/{id}**
- Description: Delete category
- Parameters: `id` (integer) - Category ID

#### Products (Produk)

**GET /api/produk**
- Description: Get all products
- Query Parameters:
  - `kategori_id` (optional) - Filter by category
  - `limit` (optional) - Limit results (default: 10)
  - `offset` (optional) - Offset for pagination

**GET /api/produk/{id}**
- Description: Get product by ID
- Parameters: `id` (integer) - Product ID

**POST /api/produk**
- Description: Create new product
- Body:
```json
{
  "nama_produk": "Product Name",
  "deskripsi": "Product description",
  "harga": 100000,
  "stok": 50,
  "kategori_id": 1
}
```

**PUT /api/produk/{id}**
- Description: Update product
- Parameters: `id` (integer) - Product ID
- Body: Same as POST

**DELETE /api/produk/{id}**
- Description: Delete product
- Parameters: `id` (integer) - Product ID

### Response Format

#### Success Response
```json
{
  "status": "success",
  "message": "Operation completed successfully",
  "data": {}
}
```

#### Error Response
```json
{
  "status": "error",
  "message": "Error description",
  "errors": {
    "field_name": ["Validation error message"]
  }
}
```

### HTTP Status Codes
- `200` - Success
- `201` - Created
- `400` - Bad Request
- `404` - Not Found
- `422` - Validation Error
- `500` - Internal Server Error

## Development

### Project Structure
```
cbi-prod-man/
├── app/
│   ├── Controllers/     # API Controllers
│   ├── Models/         # Data Models
│   ├── Config/         # Configuration files
│   └── Views/          # View templates
├── docker/             # Docker configuration
│   ├── apache-config.conf
│   ├── init-db.sql     # SQL Server initialization script
│   ├── php.ini
│   └── startup.sh      # SQL Server startup script
├── public/             # Web root
└── writable/           # Logs and cache
```

### Useful Commands

```bash
# Stop containers
docker-compose down

# Rebuild containers
docker-compose up -d --build

# View application logs
docker-compose logs -f web

# View SQL Server logs
docker-compose logs -f sqlserver

# Access application container
docker-compose exec web bash

# Access SQL Server using sqlcmd
docker-compose exec sqlserver /opt/mssql-tools18/bin/sqlcmd -S localhost -U sa -P 'YourStrong@Passw0rd123' -C

# Run migrations
docker-compose exec web php spark migrate

# Run seeders
docker-compose exec web php spark db:seed
```

### SQL Server Management

```bash
# Connect to SQL Server from host machine
sqlcmd -S localhost,1433 -U sa -P 'YourStrong@Passw0rd123' -C

# Or use SQL Server Management Studio (SSMS)
# Server: localhost,1433
# Authentication: SQL Server Authentication
# Login: sa
# Password: YourStrong@Passw0rd123
```

### Testing

```bash
# Run tests
docker-compose exec web php vendor/bin/phpunit

# Run specific test
docker-compose exec web php vendor/bin/phpunit tests/unit/HealthTest.php
```

## Deployment

For production deployment:

1. **Change SQL Server Password:** Use a strong, unique password
2. **Enable Encryption:** Set `database.default.encrypt = true`
3. **Use SQL Server Standard/Enterprise:** For production workloads
4. **Configure SSL:** Enable HTTPS and proper SSL certificates
5. **Environment Variables:** Use secure environment variable management

## Important Notes

- **Security:** This is a prototype application. Do not use in production without proper security review.
- **Database:** The application uses Microsoft SQL Server 2022 Express in Docker container.
- **Environment:** Make sure to update `.env` file for different environments.
- **Logs:** Application logs are stored in `writable/logs/` directory.
- **SQL Server:** Uses Microsoft ODBC Driver 18 for SQL Server.
- **PHP Extensions:** Includes sqlsrv and pdo_sqlsrv for SQL Server connectivity.

## Troubleshooting

### Common Issues

1. **SQL Server Connection Issues:**
   ```bash
   # Check if SQL Server is running
   docker-compose logs sqlserver
   
   # Test connection
   docker-compose exec sqlserver /opt/mssql-tools18/bin/sqlcmd -S localhost -U sa -P 'YourStrong@Passw0rd123' -C -Q "SELECT @@VERSION"
   ```

2. **PHP SQL Server Extension Issues:**
   ```bash
   # Check if extensions are loaded
   docker-compose exec web php -m | grep sqlsrv
   ```

3. **Database Initialization:**
   ```bash
   # Check if database was created
   docker-compose exec sqlserver /opt/mssql-tools18/bin/sqlcmd -S localhost -U sa -P 'YourStrong@Passw0rd123' -C -Q "SELECT name FROM sys.databases"
   ```

## Repository Management

We use GitHub issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

This repository is a "distribution" one, built by our release preparation script.
Problems with it can be raised on our forum, or as issues in the main repository.

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).
