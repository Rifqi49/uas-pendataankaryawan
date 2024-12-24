<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'birth_date',
        'address',
        'email',
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'employee_id');
    }

    public function salaries()
    {
        return $this->hasMany(Salary::class, 'employee_id');
    }
}
