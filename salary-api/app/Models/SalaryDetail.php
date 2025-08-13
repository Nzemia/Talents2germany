<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'salary_local_currency',
        'salary_in_euros',
        'commission',
        'displayed_salary',
    ];

    protected $casts = [
        'salary_local_currency' => 'decimal:2',
        'salary_in_euros' => 'decimal:2',
        'commission' => 'decimal:2',
        'displayed_salary' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Auto-calculate displayed salary when saving
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($salaryDetail) {
            if ($salaryDetail->salary_in_euros && $salaryDetail->commission) {
                $salaryDetail->displayed_salary = $salaryDetail->salary_in_euros + $salaryDetail->commission;
            }
        });
    }
}