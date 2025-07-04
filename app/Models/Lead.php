<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company',
        'created_by',
        'assigned_to',
        'stage',
        'closing_date',
        'amount',
        'status'
    ];
}
