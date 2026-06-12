<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\CategoryModel;
use App\Models\AssetModel;
use App\Models\LoanModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $role = session()->get('role');
        if ($role === 'admin') {
            return redirect()->to('/admin');
        }
        return redirect()->to('/member');
    }

    public function admin()
    {
        $userModel = new UserModel();
        $categoryModel = new CategoryModel();
        $assetModel = new AssetModel();
        $loanModel = new LoanModel();

        // 1. Core Summary Metrics
        $totalUsers = $userModel->countAllResults();
        $totalCategories = $categoryModel->countAllResults();
        $totalAssets = $assetModel->countAllResults();
        $totalLoans = $loanModel->countAllResults();
        $activeLoans = $loanModel->whereIn('status', ['approved', 'borrowed'])->countAllResults();
        
        // Sum stock of assets
        $totalStock = $assetModel->selectSum('stock')->first();
        $totalAvailableStock = $assetModel->selectSum('available_stock')->first();
        $availableAssetsCount = $assetModel->where('available_stock >', 0)->countAllResults();

        // 2. Data for Chart 1: Monthly Loans (Current Year)
        $db = \Config\Database::connect();
        $monthlyQuery = $db->table('loans')
                           ->select("MONTH(loan_date) as month, COUNT(id) as count")
                           ->where("YEAR(loan_date)", date('Y'))
                           ->groupBy("month")
                           ->get()
                           ->getResultArray();

        $monthlyData = array_fill(1, 12, 0); // Fill January to December with 0
        foreach ($monthlyQuery as $row) {
            $monthlyData[(int)$row['month']] = (int)$row['count'];
        }
        $chartMonthly = array_values($monthlyData);

        // 3. Data for Chart 2: Assets per Category
        $categoryQuery = $db->table('assets')
                            ->select("categories.name as category_name, COUNT(assets.id) as count")
                            ->join("categories", "categories.id = assets.category_id")
                            ->groupBy("categories.name")
                            ->get()
                            ->getResultArray();

        $chartCategoryLabels = [];
        $chartCategoryData = [];
        foreach ($categoryQuery as $row) {
            $chartCategoryLabels[] = $row['category_name'];
            $chartCategoryData[] = (int)$row['count'];
        }

        return view('admin/dashboard', [
            'metrics' => [
                'total_users'       => $totalUsers,
                'total_categories'  => $totalCategories,
                'total_assets'      => $totalAssets,
                'total_loans'       => $totalLoans,
                'active_loans'      => $activeLoans,
                'available_assets'  => $availableAssetsCount,
                'total_stock'       => (int)($totalStock['stock'] ?? 0),
                'available_stock'   => (int)($totalAvailableStock['available_stock'] ?? 0),
            ],
            'chartMonthly'        => json_encode($chartMonthly),
            'chartCategoryLabels' => json_encode($chartCategoryLabels),
            'chartCategoryData'   => json_encode($chartCategoryData),
        ]);
    }

    public function member()
    {
        $userId = session()->get('id');
        $loanModel = new LoanModel();

        // Member Metrics
        $totalLoans = $loanModel->where('user_id', $userId)->countAllResults();
        $pendingLoans = $loanModel->where('user_id', $userId)->where('status', 'pending')->countAllResults();
        $activeLoans = $loanModel->where('user_id', $userId)->whereIn('status', ['approved', 'borrowed'])->countAllResults();
        $returnedLoans = $loanModel->where('user_id', $userId)->where('status', 'returned')->countAllResults();

        // Get latest loans with asset details
        $db = \Config\Database::connect();
        $latestLoans = $db->table('loans')
                          ->select('loans.*, users.name as user_name')
                          ->join('users', 'users.id = loans.user_id')
                          ->where('loans.user_id', $userId)
                          ->orderBy('loans.created_at', 'DESC')
                          ->limit(5)
                          ->get()
                          ->getResultArray();

        return view('member/dashboard', [
            'metrics' => [
                'total_loans'   => $totalLoans,
                'pending_loans' => $pendingLoans,
                'active_loans'  => $activeLoans,
                'returned_loans'=> $returnedLoans,
            ],
            'latestLoans' => $latestLoans
        ]);
    }

    public function profile()
    {
        $userModel = new UserModel();
        $user = $userModel->find(session()->get('id'));
        return view('member/profile', ['user' => $user]);
    }

    public function updateProfile()
    {
        $userId = session()->get('id');
        $userModel = new UserModel();

        $rules = [
            'name'  => 'required|min_length[3]|max_length[255]',
            'email' => 'required|valid_email|is_unique[users.email,id,' . $userId . ']',
        ];

        if ($this->request->getPost('password')) {
            $rules['password'] = 'required|min_length[6]';
            $rules['password_confirm'] = 'required|matches[password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id'    => $userId,
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        if ($userModel->save($data)) {
            // Update session
            session()->set('name', $data['name']);
            session()->set('email', $data['email']);
            return redirect()->back()->with('success', 'Profil Anda berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui profil.');
    }
}
