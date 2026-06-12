<?php

namespace App\Controllers;

use App\Models\LoanModel;
use App\Models\LoanDetailModel;
use App\Models\AssetModel;
use App\Models\CategoryModel;
use Hermawan\DataTables\DataTable;

class LoanController extends BaseController
{
    // ==========================================
    // MEMBER METHODS
    // ==========================================

    public function memberCatalog()
    {
        $categoryModel = new CategoryModel();
        $assetModel = new AssetModel();

        $categories = $categoryModel->findAll();
        // Load assets that are available
        $assets = $assetModel->select('assets.*, categories.name as category_name')
                             ->join('categories', 'categories.id = assets.category_id')
                             ->where('assets.status', 'tersedia')
                             ->findAll();

        return view('member/catalog', [
            'categories' => $categories,
            'assets'     => $assets
        ]);
    }

    public function storeMemberLoan()
    {
        $userId = session()->get('id');
        
        $rules = [
            'purpose'     => 'required|min_length[5]',
            'loan_date'   => 'required|valid_date[Y-m-d]',
            'return_date' => 'required|valid_date[Y-m-d]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $purpose = $this->request->getPost('purpose');
        $loanDate = $this->request->getPost('loan_date');
        $returnDate = $this->request->getPost('return_date');
        $items = $this->request->getPost('items'); // Array of asset_id => quantity

        // Validation: dates sanity
        if (strtotime($loanDate) < strtotime(date('Y-m-d'))) {
            return redirect()->back()->withInput()->with('error', 'Tanggal pinjam tidak boleh sebelum hari ini.');
        }
        if (strtotime($returnDate) < strtotime($loanDate)) {
            return redirect()->back()->withInput()->with('error', 'Tanggal kembali tidak boleh sebelum tanggal pinjam.');
        }

        // Validation: check empty cart
        if (empty($items) || !is_array($items)) {
            return redirect()->back()->withInput()->with('error', 'Keranjang peminjaman kosong. Harap pilih aset.');
        }

        // Filter empty values and validate stock
        $validItems = [];
        $assetModel = new AssetModel();

        foreach ($items as $assetId => $qty) {
            $qty = (int)$qty;
            if ($qty > 0) {
                $asset = $assetModel->find($assetId);
                if (!$asset) {
                    return redirect()->back()->withInput()->with('error', 'Aset tidak ditemukan.');
                }
                
                // Enforce stock limit check
                if ($qty > $asset['available_stock']) {
                    return redirect()->back()->withInput()->with('error', 'Aset <strong>' . esc($asset['name']) . '</strong> melebihi stok yang tersedia (' . $asset['available_stock'] . ' unit).');
                }
                
                $validItems[] = [
                    'asset_id' => $assetId,
                    'quantity' => $qty
                ];
            }
        }

        if (empty($validItems)) {
            return redirect()->back()->withInput()->with('error', 'Keranjang peminjaman kosong atau kuantitas tidak valid.');
        }

        // DB Transaction
        $db = \Config\Database::connect();
        $db->transStart();

        $loanModel = new LoanModel();
        $loanDetailModel = new LoanDetailModel();

        // Save Loan
        $loanData = [
            'user_id'     => $userId,
            'approved_by' => null,
            'purpose'     => $purpose,
            'loan_date'   => $loanDate,
            'return_date' => $returnDate,
            'status'      => 'pending'
        ];
        $loanModel->save($loanData);
        $loanId = $loanModel->getInsertID();

        // Save Details
        foreach ($validItems as $item) {
            $detailData = [
                'loan_id'  => $loanId,
                'asset_id' => $item['asset_id'],
                'quantity' => $item['quantity']
            ];
            $loanDetailModel->save($detailData);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Gagal memproses peminjaman. Silakan coba kembali.');
        }

        return redirect()->to('/member/loans')->with('success', 'Pengajuan peminjaman berhasil diajukan dan sedang menunggu persetujuan.');
    }

    public function memberLoans()
    {
        $userId = session()->get('id');
        $db = \Config\Database::connect();
        
        $loans = $db->table('loans')
                    ->select('loans.*, users.name as user_name')
                    ->join('users', 'users.id = loans.user_id')
                    ->where('loans.user_id', $userId)
                    ->orderBy('loans.created_at', 'DESC')
                    ->get()
                    ->getResultArray();

        return view('member/loans_history', ['loans' => $loans]);
    }

    public function getLoanDetails($id)
    {
        $db = \Config\Database::connect();
        
        $loan = $db->table('loans')
                    ->select('loans.*, user.name as user_name, admin.name as approved_by_name')
                    ->join('users user', 'user.id = loans.user_id')
                    ->join('users admin', 'admin.id = loans.approved_by', 'left')
                    ->where('loans.id', $id)
                    ->get()
                    ->getRowArray();

        if (!$loan) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Detail peminjaman tidak ditemukan.']);
        }

        $loanDetailModel = new LoanDetailModel();
        $items = $loanDetailModel->getDetailsByLoan($id);

        return $this->response->setJSON([
            'status' => 'success',
            'loan'   => $loan,
            'items'  => $items
        ]);
    }


    // ==========================================
    // ADMIN METHODS
    // ==========================================

    public function adminIndex()
    {
        return view('admin/loans');
    }

    public function adminAjaxList()
    {
        $db = \Config\Database::connect();
        
        // Custom builder for server-side processing
        $builder = $db->table('loans')
                      ->select('loans.id, loans.loan_date, loans.return_date, loans.status, loans.purpose, user.name as user_name, admin.name as approved_by_name, loans.user_id')
                      ->join('users user', 'user.id = loans.user_id')
                      ->join('users admin', 'admin.id = loans.approved_by', 'left');

        return DataTable::of($builder)
            ->add('action', function($row) {
                // Actions based on status
                $detailBtn = '<button class="btn btn-sm btn-outline-secondary btn-view-detail rounded-3" data-id="' . $row->id . '"><i class="bi bi-eye"></i> Detail</button>';
                
                $actions = '<div class="d-flex gap-1">' . $detailBtn;
                
                if ($row->status === 'pending') {
                    $actions .= '
                        <button class="btn btn-sm btn-success btn-approve rounded-3" data-id="' . $row->id . '"><i class="bi bi-check-lg"></i> Approve</button>
                        <button class="btn btn-sm btn-danger btn-reject rounded-3" data-id="' . $row->id . '"><i class="bi bi-x-lg"></i> Reject</button>
                    ';
                } elseif ($row->status === 'approved') {
                    $actions .= '
                        <button class="btn btn-sm btn-primary btn-borrow rounded-3" data-id="' . $row->id . '"><i class="bi bi-box-arrow-up-right"></i> Borrow</button>
                    ';
                } elseif ($row->status === 'borrowed') {
                    $actions .= '
                        <button class="btn btn-sm btn-info text-white btn-return rounded-3" data-id="' . $row->id . '"><i class="bi bi-check2-all"></i> Return</button>
                    ';
                }
                
                $actions .= '</div>';
                return $actions;
            })
            ->toJson(true);
    }

    public function approve($id)
    {
        $loanModel = new LoanModel();
        $loanDetailModel = new LoanDetailModel();
        $assetModel = new AssetModel();

        $loan = $loanModel->find($id);
        if (!$loan || $loan['status'] !== 'pending') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Status peminjaman tidak valid atau tidak ditemukan.']);
        }

        $items = $loanDetailModel->where('loan_id', $id)->findAll();
        
        // DB Transaction for stock checks and reduction
        $db = \Config\Database::connect();
        $db->transStart();

        // 1. Verify stocks
        foreach ($items as $item) {
            $asset = $assetModel->find($item['asset_id']);
            if ($asset['available_stock'] < $item['quantity']) {
                $db->transRollback();
                return $this->response->setJSON([
                    'status'  => 'error', 
                    'message' => 'Stok tidak mencukupi untuk menyetujui peminjaman ini. Aset: ' . esc($asset['name']) . ' (Sisa: ' . $asset['available_stock'] . ' unit)'
                ]);
            }
        }

        // 2. Reduce available stock
        foreach ($items as $item) {
            $asset = $assetModel->find($item['asset_id']);
            $newAvailable = $asset['available_stock'] - $item['quantity'];
            $assetModel->save([
                'id'              => $item['asset_id'],
                'available_stock' => $newAvailable
            ]);
        }

        // 3. Update Loan status
        $loanModel->save([
            'id'          => $id,
            'approved_by' => session()->get('id'),
            'status'      => 'approved'
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal memperbarui status peminjaman.']);
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'Peminjaman disetujui. Stok unit berhasil di-booking.']);
    }

    public function reject($id)
    {
        $loanModel = new LoanModel();
        $loan = $loanModel->find($id);

        if (!$loan || $loan['status'] !== 'pending') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Status peminjaman tidak valid atau tidak ditemukan.']);
        }

        $loanModel->save([
            'id'          => $id,
            'approved_by' => session()->get('id'),
            'status'      => 'rejected'
        ]);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Peminjaman ditolak.']);
    }

    public function borrow($id)
    {
        $loanModel = new LoanModel();
        $loan = $loanModel->find($id);

        if (!$loan || $loan['status'] !== 'approved') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Status peminjaman tidak valid.']);
        }

        $loanModel->save([
            'id'     => $id,
            'status' => 'borrowed'
        ]);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Aset diserahkan ke peminjam. Status diperbarui menjadi Borrowed.']);
    }

    public function returnLoan($id)
    {
        $loanModel = new LoanModel();
        $loanDetailModel = new LoanDetailModel();
        $assetModel = new AssetModel();

        $loan = $loanModel->find($id);
        if (!$loan || $loan['status'] !== 'borrowed') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Status peminjaman tidak valid.']);
        }

        $items = $loanDetailModel->where('loan_id', $id)->findAll();
        
        $db = \Config\Database::connect();
        $db->transStart();

        // Restore available stocks
        foreach ($items as $item) {
            $asset = $assetModel->find($item['asset_id']);
            $newAvailable = $asset['available_stock'] + $item['quantity'];
            
            // Safety cap: available_stock shouldn't exceed total stock
            if ($newAvailable > $asset['stock']) {
                $newAvailable = $asset['stock'];
            }

            $assetModel->save([
                'id'              => $item['asset_id'],
                'available_stock' => $newAvailable
            ]);
        }

        // Update loan status
        $loanModel->save([
            'id'     => $id,
            'status' => 'returned'
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal memproses pengembalian aset.']);
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'Aset berhasil dikembalikan. Stok unit telah dipulihkan.']);
    }
}
