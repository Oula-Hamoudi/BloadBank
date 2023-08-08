<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'father',
        'mother',
        'dob',
        'gender',
        'division',
        'district',
        'thana',
        'postOffice',
        'postCode',
        'profile_image',
        'nid_image',
        'phone'
    ];
    

    
}
