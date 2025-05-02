<?php

namespace App\Models;

use App\Models\InsurancePolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InsuranceType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'coverage_details',
    ];

    public function policies()
    {
        return $this->hasMany(InsurancePolicy::class);
    }
} 