<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table            = 'produk';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['kategori_id', 'nama_produk', 'harga', 'stok'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'kategori_id' => 'required|is_natural_no_zero',
        'nama_produk' => 'required|max_length[150]',
        'harga'       => 'required|decimal|greater_than[0]',
        'stok'        => 'required|is_natural',
    ];
    protected $validationMessages   = [
        'kategori_id' => [
            'required'           => 'Kategori harus dipilih',
            'is_natural_no_zero' => 'Kategori harus valid'
        ],
        'nama_produk' => [
            'required'   => 'Nama produk harus diisi',
            'max_length' => 'Nama produk maksimal 150 karakter'
        ],
        'harga' => [
            'required'     => 'Harga harus diisi',
            'decimal'      => 'Harga harus berupa angka',
            'greater_than' => 'Harga harus lebih dari 0'
        ],
        'stok' => [
            'required'   => 'Stok harus diisi',
            'is_natural' => 'Stok harus berupa angka positif'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Get products with category information for DataTables
     */
    public function getProductsWithCategory(): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table($this->table . ' p');
        
        return $builder->select('p.id, p.nama_produk, p.harga, p.stok, k.nama_kategori')
                       ->join('kategori k', 'p.kategori_id = k.id', 'left')
                       ->orderBy('p.id', 'DESC')
                       ->get()
                       ->getResultArray();
    }

    /**
     * Get single product with category information
     */
    public function getProductWithCategory(int $id): ?array
    {
        $db = \Config\Database::connect();
        $builder = $db->table($this->table . ' p');
        
        $result = $builder->select('p.*, k.nama_kategori')
                          ->join('kategori k', 'p.kategori_id = k.id', 'left')
                          ->where('p.id', $id)
                          ->get()
                          ->getRowArray();
        
        return $result ?: null;
    }

    /**
     * Get products data for DataTables AJAX request
     */
    public function getDataTablesData(array $request): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table($this->table . ' p');
        
        // Basic query with JOIN
        $builder->select('p.id, p.nama_produk, p.harga, p.stok, k.nama_kategori')
                ->join('kategori k', 'p.kategori_id = k.id', 'left');
        
        // Search functionality
        if (!empty($request['search']['value'])) {
            $searchValue = $request['search']['value'];
            $builder->groupStart()
                    ->like('p.nama_produk', $searchValue)
                    ->orLike('k.nama_kategori', $searchValue)
                    ->orLike('p.harga', $searchValue)
                    ->orLike('p.stok', $searchValue)
                    ->groupEnd();
        }
        
        // Total records without filtering
        $totalRecords = $db->table($this->table)->countAllResults();
        
        // Total records with filtering
        $totalFiltered = $builder->countAllResults(false);
        
        // Order
        if (isset($request['order']) && !empty($request['order'])) {
            $columns = ['p.id', 'p.nama_produk', 'k.nama_kategori', 'p.harga', 'p.stok'];
            $orderColumn = $columns[$request['order'][0]['column']] ?? 'p.id';
            $orderDir = $request['order'][0]['dir'] ?? 'desc';
            $builder->orderBy($orderColumn, $orderDir);
        } else {
            $builder->orderBy('p.id', 'DESC');
        }
        
        // Limit
        if (isset($request['length']) && $request['length'] != -1) {
            $builder->limit($request['length'], $request['start'] ?? 0);
        }
        
        $data = $builder->get()->getResultArray();
        
        return [
            'draw'            => $request['draw'] ?? 1,
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data'            => $data
        ];
    }
}