<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryIssue extends Model
{
    use HasFactory;

    protected $fillable = [
        'part_id',
        'employee_id',
        'department_id',
        'quantity_issued',
        'issue_date'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'part_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}