<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table            = 'kategori';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_kategori', 'deskripsi'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'nama_kategori' => 'required|max_length[100]',
    ];
    protected $validationMessages   = [
        'nama_kategori' => [
            'required'   => 'Nama kategori harus diisi',
            'max_length' => 'Nama kategori maksimal 100 karakter'
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
     * Get all categories for dropdown
     */
    public function getForDropdown(): array
    {
        return $this->select('id, nama_kategori')
                    ->orderBy('nama_kategori', 'ASC')
                    ->findAll();
    }

    /**
     * Check if category has products
     */
    public function hasProducts(int $id): bool
    {
        $db = \Config\Database::connect();
        $builder = $db->table('produk');
        
        $count = $builder->where('kategori_id', $id)->countAllResults();
        
        return $count > 0;
    }
}