<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use App\Models\KategoriModel;

class Produk extends BaseController
{
    protected $produkModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->produkModel = new ProdukModel();
        $this->kategoriModel = new KategoriModel();
    }

    /**
     * Display list of products with DataTables
     */
    public function index(): string
    {
        $data = [
            'title' => 'Daftar Produk'
        ];

        return view('produk/index', $data);
    }

    /**
     * Get data for DataTables AJAX request
     */
    public function data()
    {
        $request = $this->request->getGet();
        
        $data = $this->produkModel->getDataTablesData($request);
        
        // Format data for DataTables
        foreach ($data['data'] as &$row) {
            $row['harga'] = 'Rp ' . number_format($row['harga'], 0, ',', '.');
            $row['stok'] = number_format($row['stok']);
            $row['aksi'] = '
                <a href="' . base_url('produk/edit/' . $row['id']) . '" class="btn btn-sm btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <button type="button" class="btn btn-sm btn-danger" onclick="deleteProduk(' . $row['id'] . ')">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            ';
        }

        return $this->response->setJSON($data);
    }

    /**
     * Show form for creating new product
     */
    public function create(): string
    {
        $data = [
            'title'      => 'Tambah Produk',
            'categories' => $this->kategoriModel->getForDropdown(),
            'validation' => \Config\Services::validation()
        ];

        return view('produk/create', $data);
    }

    /**
     * Store new product
     */
    public function store()
    {
        $rules = [
            'kategori_id' => 'required|is_natural_no_zero',
            'nama_produk' => 'required|max_length[150]',
            'harga'       => 'required|decimal|greater_than[0]',
            'stok'        => 'required|is_natural',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Validate if category exists
        $kategori = $this->kategoriModel->find($this->request->getPost('kategori_id'));
        if (!$kategori) {
            return redirect()->back()->withInput()->with('error', 'Kategori yang dipilih tidak valid');
        }

        $data = [
            'kategori_id' => $this->request->getPost('kategori_id'),
            'nama_produk' => $this->request->getPost('nama_produk'),
            'harga'       => $this->request->getPost('harga'),
            'stok'        => $this->request->getPost('stok')
        ];

        if ($this->produkModel->insert($data)) {
            return redirect()->to('/produk')->with('success', 'Produk berhasil ditambahkan');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan produk');
        }
    }

    /**
     * Show form for editing product
     */
    public function edit(int $id): string
    {
        $produk = $this->produkModel->find($id);

        if (!$produk) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan');
        }

        $data = [
            'title'      => 'Edit Produk',
            'produk'     => $produk,
            'categories' => $this->kategoriModel->getForDropdown(),
            'validation' => \Config\Services::validation()
        ];

        return view('produk/edit', $data);
    }

    /**
     * Update product
     */
    public function update(int $id)
    {
        $produk = $this->produkModel->find($id);

        if (!$produk) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan');
        }

        $rules = [
            'kategori_id' => 'required|is_natural_no_zero',
            'nama_produk' => 'required|max_length[150]',
            'harga'       => 'required|decimal|greater_than[0]',
            'stok'        => 'required|is_natural',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Validate if category exists
        $kategori = $this->kategoriModel->find($this->request->getPost('kategori_id'));
        if (!$kategori) {
            return redirect()->back()->withInput()->with('error', 'Kategori yang dipilih tidak valid');
        }

        $data = [
            'kategori_id' => $this->request->getPost('kategori_id'),
            'nama_produk' => $this->request->getPost('nama_produk'),
            'harga'       => $this->request->getPost('harga'),
            'stok'        => $this->request->getPost('stok')
        ];

        if ($this->produkModel->update($id, $data)) {
            return redirect()->to('/produk')->with('success', 'Produk berhasil diperbarui');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui produk');
        }
    }

    /**
     * Delete product
     */
    public function delete(int $id)
    {
        $produk = $this->produkModel->find($id);

        if (!$produk) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ]);
        }

        if ($this->produkModel->delete($id)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Produk berhasil dihapus'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menghapus produk'
            ]);
        }
    }
}