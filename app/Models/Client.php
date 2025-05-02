<?php

namespace App\Models;

use App\Models\Branch;
use App\Models\InsurancePolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'code',
        'first_name',
        'last_name',
        'birth_date',
        'address',
        'city',
        'phone',
        'email',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function policies()
    {
        return $this->hasMany(InsurancePolicy::class);
    }
} 