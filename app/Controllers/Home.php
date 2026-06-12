<?php

namespace App\Controllers;

use App\Models\AssetModel;
use App\Models\CategoryModel;
use App\Models\LoanModel;
use App\Models\UserModel;

class Home extends BaseController
{
    public function index(): string
    {
        $assetModel = new AssetModel();
        $categoryModel = new CategoryModel();
        $loanModel = new LoanModel();
        $userModel = new UserModel();

        // Pull stats
        $stats = [
            'total_categories' => $categoryModel->countAllResults(),
            'total_assets'     => $assetModel->countAllResults(),
            'total_loans'      => $loanModel->countAllResults(),
            'active_loans'     => $loanModel->whereIn('status', ['approved', 'borrowed'])->countAllResults(),
            'available_assets' => $assetModel->where('available_stock >', 0)->countAllResults(),
            'total_members'    => $userModel->where('role', 'member')->countAllResults(),
        ];

        // Pull assets with category name
        $assets = $assetModel->select('assets.*, categories.name as category_name')
                             ->join('categories', 'categories.id = assets.category_id')
                             ->findAll();

        return view('public/landing', [
            'stats'  => $stats,
            'assets' => $assets
        ]);
    }

    public function assetDetail($id)
    {
        $assetModel = new AssetModel();
        $asset = $assetModel->select('assets.*, categories.name as category_name')
                            ->join('categories', 'categories.id = assets.category_id')
                            ->find($id);

        if (!$asset) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Aset tidak ditemukan.']);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => [
                'name'            => esc($asset['name']),
                'category_name'   => esc($asset['category_name']),
                'description'     => nl2br(esc($asset['description'] ?: 'Tidak ada deskripsi.')),
                'stock'           => (int)$asset['stock'],
                'available_stock' => (int)$asset['available_stock'],
                'condition'       => esc($asset['condition']),
                'status'          => esc($asset['status']),
                'image'           => $asset['image'] ? base_url('uploads/assets/' . $asset['image']) : base_url('HIMAKOM Logo.png')
            ]
        ]);
    }

    public function catalog()
    {
        return redirect()->to('/#catalog');
    }
}
