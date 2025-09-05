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

## Requirements

### System Requirements
- **Docker** (version 20.10 or higher)
- **Docker Compose** (version 2.0 or higher)
- **Git** (for cloning the repository)

### PHP Requirements (handled by Docker)
PHP version 8.1 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)
- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) for MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) for HTTP\CURLRequest library

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
# Database Configuration
DB_HOST=db
DB_PORT=3306
DB_DATABASE=cbi_prod_man
DB_USERNAME=root
DB_PASSWORD=your_password

# App Configuration
app.baseURL=http://localhost:8080/
app.indexPage=''
app.appTimezone=Asia/Jakarta
app.defaultLocale=en

# Environment
CI_ENVIRONMENT=development
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
- **Database:** localhost:3306 (from host machine)

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
docker-compose logs -f app

# View database logs
docker-compose logs -f db

# Access application container
docker-compose exec app bash

# Access database
docker-compose exec db mysql -u root -p

# Run migrations
docker-compose exec app php spark migrate

# Run seeders
docker-compose exec app php spark db:seed
```

### Testing

```bash
# Run tests
docker-compose exec app php vendor/bin/phpunit

# Run specific test
docker-compose exec app php vendor/bin/phpunit tests/unit/HealthTest.php
```

## Deployment

For production deployment, see the deployment guide in the project documentation.

## Important Notes

- **Security:** This is a prototype application. Do not use in production without proper security review.
- **Database:** The application uses MySQL 8.0 in Docker container.
- **Environment:** Make sure to update `.env` file for different environments.
- **Logs:** Application logs are stored in `writable/logs/` directory.

## Repository Management

We use GitHub issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

This repository is a "distribution" one, built by our release preparation script.
Problems with it can be raised on our forum, or as issues in the main repository.

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).

        