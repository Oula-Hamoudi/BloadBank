<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    const SUPER_ADMIN_ROLE_ID = 1;
    const ADMIN_ROLE_ID = 2;
    const DONOR_ROLE_ID = 3;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'blood_group',
        'approved_by',
        'approval_status',
        'nid_number',
        'last_donated',
        'total_donated',
        'rejected_by',
        'reject_reason',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function approvedBy()
    {
        return $this->belongsTo(User::class,'approved_by');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
    public function isSuperAdmin()
    {
        return $this->role_id === self::SUPER_ADMIN_ROLE_ID;
    }

    public function isAdmin()
    {
        return $this->role_id === self::ADMIN_ROLE_ID;
    }

    public function isDonor()
    {
        return $this->role_id === self::DONOR_ROLE_ID;
    }

    public function bloodRequests()
    {
        return $this->belongsToMany(BloodRequest::class)
            ->withPivot(['status'])
            ->withTimestamps();
    }

    //calculating age::

    public function age($dob)
    {
       $diff = Carbon::parse($dob)->diff(Carbon::now())->y;
       return $age = $diff." years";
    }
}
