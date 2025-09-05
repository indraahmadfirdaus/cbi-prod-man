USE master;
GO

-- Create database if not exists
IF NOT EXISTS (SELECT name FROM sys.databases WHERE name = 'cbi_prod_man')
BEGIN
    CREATE DATABASE cbi_prod_man;
END
GO

-- Grant permissions to sa user
USE cbi_prod_man;
GO

-- Create tables
IF NOT EXISTS (SELECT * FROM sysobjects WHERE name='kategori' AND xtype='U')
BEGIN
    CREATE TABLE kategori (
        id INT IDENTITY(1,1) PRIMARY KEY,
        nama_kategori NVARCHAR(100) NOT NULL,
        deskripsi NVARCHAR(255),
        created_at DATETIME2 DEFAULT GETDATE(),
        updated_at DATETIME2 DEFAULT GETDATE()
    );
END
GO

IF NOT EXISTS (SELECT * FROM sysobjects WHERE name='produk' AND xtype='U')
BEGIN
    CREATE TABLE produk (
        id INT IDENTITY(1,1) PRIMARY KEY,
        nama_produk NVARCHAR(100) NOT NULL,
        kategori_id INT NOT NULL,
        harga DECIMAL(15,2) NOT NULL,
        stok INT NOT NULL DEFAULT 0,
        deskripsi NVARCHAR(500),
        created_at DATETIME2 DEFAULT GETDATE(),
        updated_at DATETIME2 DEFAULT GETDATE(),
        FOREIGN KEY (kategori_id) REFERENCES kategori(id)
    );
END
GO

-- Insert sample data
IF NOT EXISTS (SELECT * FROM kategori)
BEGIN
    INSERT INTO kategori (nama_kategori, deskripsi) VALUES 
    ('Elektronik', 'Produk elektronik dan gadget'),
    ('Pakaian', 'Pakaian dan aksesoris'),
    ('Makanan', 'Makanan dan minuman');
END
GO

IF NOT EXISTS (SELECT * FROM produk)
BEGIN
    INSERT INTO produk (nama_produk, kategori_id, harga, stok, deskripsi) VALUES 
    ('Laptop Gaming', 1, 15000000.00, 5, 'Laptop gaming high performance'),
    ('Smartphone Android', 1, 8000000.00, 10, 'Smartphone Android terbaru'),
    ('Kaos Polo', 2, 150000.00, 25, 'Kaos polo berkualitas tinggi'),
    ('Celana Jeans', 2, 300000.00, 15, 'Celana jeans premium'),
    ('Kopi Arabica', 3, 50000.00, 100, 'Kopi arabica pilihan');
END
GO