<?php

namespace App\Models;

use CodeIgniter\Model;

class LoanModel extends Model
{
    protected $table            = 'loans';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id', 
        'approved_by', 
        'purpose', 
        'loan_date', 
        'return_date', 
        'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'user_id'     => 'required|is_natural_no_zero',
        'approved_by' => 'permit_empty|is_natural_no_zero',
        'purpose'     => 'required|min_length[5]',
        'loan_date'   => 'required|valid_date',
        'return_date' => 'required|valid_date',
        'status'      => 'required|in_list[pending,approved,rejected,borrowed,returned]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
