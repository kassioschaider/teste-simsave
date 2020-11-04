<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'role', 'email', 'phone_number', 'admission_date', 'company_id',
    ];
    protected $appends = ['links'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getLinksAttribute($links): array
    {
        return [
            'self' => '/api/employee/' . $this->id,
            'company' => '/api/company/' . $this->company_id
        ];
    }
}
