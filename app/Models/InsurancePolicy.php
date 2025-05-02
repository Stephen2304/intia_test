<?php

namespace App\Models;

use App\Models\Client;
use App\Models\Document;
use App\Models\InsuranceType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InsurancePolicy extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'insurance_type_id',
        'policy_number',
        'start_date',
        'end_date',
        'coverage_amount',
        'annual_premium',
        'status',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function type()
    {
        return $this->belongsTo(InsuranceType::class, 'insurance_type_id');
    }
} 