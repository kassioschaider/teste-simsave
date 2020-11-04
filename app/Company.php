<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'cnpj', 'address',
    ];
    protected $appends = ['links'];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function getLinksAttribute($links): array
    {
        return [
            'self' => '/api/company/' . $this->id,
            'employees' => '/api/company/' . $this->id . '/employees'
        ];
    }
}
