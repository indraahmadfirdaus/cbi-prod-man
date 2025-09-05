<?php

namespace App\Controllers;

use App\Models\KategoriModel;

class Kategori extends BaseController
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
    }

    /**
     * Display list of categories
     */
    public function index(): string
    {
        $data = [
            'title'      => 'Daftar Kategori',
            'categories' => $this->kategoriModel->orderBy('id', 'DESC')->findAll()
        ];

        return view('kategori/index', $data);
    }

    /**
     * Show form for creating new category
     */
    public function create(): string
    {
        $data = [
            'title'      => 'Tambah Kategori',
            'validation' => \Config\Services::validation()
        ];

        return view('kategori/create', $data);
    }

    /**
     * Store new category
     */
    public function store()
    {
        $rules = [
            'nama_kategori' => 'required|max_length[100]',
            'deskripsi'     => 'permit_empty|max_length[1000]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'nama_kategori' => $this->request->getPost('nama_kategori'),
            'deskripsi'     => $this->request->getPost('deskripsi')
        ];

        if ($this->kategoriModel->insert($data)) {
            return redirect()->to('/kategori')->with('success', 'Kategori berhasil ditambahkan');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan kategori');
        }
    }

    /**
     * Show form for editing category
     */
    public function edit(int $id): string
    {
        $kategori = $this->kategoriModel->find($id);

        if (!$kategori) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kategori tidak ditemukan');
        }

        $data = [
            'title'      => 'Edit Kategori',
            'kategori'   => $kategori,
            'validation' => \Config\Services::validation()
        ];

        return view('kategori/edit', $data);
    }

    /**
     * Update category
     */
    public function update(int $id)
    {
        $kategori = $this->kategoriModel->find($id);

        if (!$kategori) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kategori tidak ditemukan');
        }

        $rules = [
            'nama_kategori' => 'required|max_length[100]',
            'deskripsi'     => 'permit_empty|max_length[1000]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'nama_kategori' => $this->request->getPost('nama_kategori'),
            'deskripsi'     => $this->request->getPost('deskripsi')
        ];

        if ($this->kategoriModel->update($id, $data)) {
            return redirect()->to('/kategori')->with('success', 'Kategori berhasil diperbarui');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui kategori');
        }
    }

    /**
     * Delete category
     */
    public function delete(int $id)
    {
        $kategori = $this->kategoriModel->find($id);

        if (!$kategori) {
            return redirect()->to('/kategori')->with('error', 'Kategori tidak ditemukan');
        }

        // Check if category has products
        if ($this->kategoriModel->hasProducts($id)) {
            return redirect()->to('/kategori')->with('error', 'Tidak dapat menghapus kategori yang masih memiliki produk');
        }

        if ($this->kategoriModel->delete($id)) {
            return redirect()->to('/kategori')->with('success', 'Kategori berhasil dihapus');
        } else {
            return redirect()->to('/kategori')->with('error', 'Gagal menghapus kategori');
        }
    }
}