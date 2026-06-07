<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployerRequest extends Model
{
    protected $fillable = [
        'company_name',
        'contact_person',
        'email',
        'request_type',
        'message',
        'status',
    ];
}