<?php

namespace App\Controllers;

use App\Models\KategoriModel;
use App\Models\ProdukModel;

class Home extends BaseController
{
    public function index(): string
    {
        $kategoriModel = new KategoriModel();
        $produkModel = new ProdukModel();

        $data = [
            'title' => 'Dashboard',
            'totalKategori' => $kategoriModel->countAll(),
            'totalProduk' => $produkModel->countAll(),
            'recentProducts' => $produkModel->getProductsWithCategory()
        ];

        return view('home/index', $data);
    }
}