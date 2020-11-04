<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'role', 'email', 'phone_number', 'admission_date',
    ];

    public function companie()
    {
        return $this->belongsTo(Company::class);
    }
}
