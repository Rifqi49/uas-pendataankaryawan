<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salary extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'basic_salary',
        'allowance',
        'deduction',
        'total_salary',
    ];

    protected static function booted()
    {
        static::saving(function ($salary) {
            $salary->total_salary = $salary->basic_salary + $salary->allowance - $salary->deduction;
        });
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}