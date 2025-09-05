<?php

namespace Config;

use CodeIgniter\Database\Config;

/**
 * Database Configuration
 */
class Database extends Config
{
    /**
     * The directory that holds the Migrations and Seeds directories.
     */
    public string $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;

    /**
     * Lets you choose which connection group to use if no other is specified.
     */
    public string $defaultGroup = 'default';

    /**
     * The default database connection.
     */
    public array $default = [];

    /**
     * This database connection is used when running PHPUnit database tests.
     */
    public array $tests = [];

    public function __construct()
    {
        parent::__construct();

        // Initialize default connection - aligned with .env file format
        $this->default = [
            'DSN'         => '',
            'hostname'    => $_ENV['database.default.hostname'] ?? getenv('database.default.hostname') ?? 'sqlserver',
            'username'    => $_ENV['database.default.username'] ?? getenv('database.default.username') ?? 'sa',
            'password'    => $_ENV['database.default.password'] ?? getenv('database.default.password') ?? 'YourStrong@Passw0rd123',
            'database'    => $_ENV['database.default.database'] ?? getenv('database.default.database') ?? 'cbi_prod_man',
            'DBDriver'    => $_ENV['database.default.DBDriver'] ?? getenv('database.default.DBDriver') ?? 'SQLSRV',
            'DBPrefix'    => $_ENV['database.default.DBPrefix'] ?? getenv('database.default.DBPrefix') ?? '',
            'pConnect'    => false,
            'DBDebug'     => (ENVIRONMENT !== 'production'),
            'charset'     => 'utf8',
            'DBCollat'    => '',
            'swapPre'     => '',
            'encrypt'     => filter_var($_ENV['database.default.encrypt'] ?? getenv('database.default.encrypt') ?? 'false', FILTER_VALIDATE_BOOLEAN),
            'compress'    => false,
            'strictOn'    => false,
            'failover'    => [],
            'port'        => (int)($_ENV['database.default.port'] ?? getenv('database.default.port') ?? 1433),
            'numberNative' => false,
            'dateFormat'   => [
                'date'     => 'Y-m-d',
                'datetime' => 'Y-m-d H:i:s',
                'time'     => 'H:i:s',
            ],
            'trustServerCertificate' => filter_var($_ENV['database.default.trustServerCertificate'] ?? getenv('database.default.trustServerCertificate') ?? 'true', FILTER_VALIDATE_BOOLEAN),
        ];

        // Initialize test connection
        $this->tests = [
            'DSN'         => '',
            'hostname'    => $_ENV['database.tests.hostname'] ?? getenv('database.tests.hostname') ?? $this->default['hostname'],
            'username'    => $_ENV['database.tests.username'] ?? getenv('database.tests.username') ?? $this->default['username'],
            'password'    => $_ENV['database.tests.password'] ?? getenv('database.tests.password') ?? $this->default['password'],
            'database'    => $_ENV['database.tests.database'] ?? getenv('database.tests.database') ?? 'cbi_prod_man_test',
            'DBDriver'    => $_ENV['database.tests.DBDriver'] ?? getenv('database.tests.DBDriver') ?? $this->default['DBDriver'],
            'DBPrefix'    => $_ENV['database.tests.DBPrefix'] ?? getenv('database.tests.DBPrefix') ?? 'test_',
            'pConnect'    => false,
            'DBDebug'     => true,
            'charset'     => 'utf8',
            'DBCollat'    => '',
            'swapPre'     => '',
            'encrypt'     => filter_var($_ENV['database.tests.encrypt'] ?? getenv('database.tests.encrypt') ?? $this->default['encrypt'], FILTER_VALIDATE_BOOLEAN),
            'compress'    => false,
            'strictOn'    => false,
            'failover'    => [],
            'port'        => (int)($_ENV['database.tests.port'] ?? getenv('database.tests.port') ?? $this->default['port']),
            'numberNative' => false,
            'dateFormat'   => [
                'date'     => 'Y-m-d',
                'datetime' => 'Y-m-d H:i:s',
                'time'     => 'H:i:s',
            ],
            'trustServerCertificate' => filter_var($_ENV['database.tests.trustServerCertificate'] ?? getenv('database.tests.trustServerCertificate') ?? $this->default['trustServerCertificate'], FILTER_VALIDATE_BOOLEAN),
        ];
    }
}