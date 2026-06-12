<?php

namespace App\Models;

use CodeIgniter\Model;

class LoanDetailModel extends Model
{
    protected $table            = 'loan_details';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['loan_id', 'asset_id', 'quantity'];

    // Validation
    protected $validationRules      = [
        'loan_id'  => 'required|is_natural_no_zero',
        'asset_id' => 'required|is_natural_no_zero',
        'quantity' => 'required|integer|greater_than[0]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Helper to get loan details with asset names
    public function getDetailsByLoan($loanId)
    {
        return $this->select('loan_details.*, assets.name as asset_name, assets.image as asset_image, assets.condition as asset_condition')
                    ->join('assets', 'assets.id = loan_details.asset_id')
                    ->where('loan_details.loan_id', $loanId)
                    ->findAll();
    }
}
