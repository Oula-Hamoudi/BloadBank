<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BloodRequest extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'patient_name',
        'contact_name',
        'gender',
        'blood_group',
        'blood_unit',
        'hospital_name',
        'division',
        'district',
        'thana',
        'postOffice',
        'postCode',
        'email',
        'phone',
        'phone2',
        'additional',
        'reason',
        'completed_at',
        'status',
        'request_no',
        'approved_by',
        'require_date',
        'official_report',
        'rejected_by',
        'reject_reason'
    ];
   
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function donorId()
    {
        return $this->belongsTo(User::class, 'donor_id' );
    }

    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    public function donors()
    {
       return $this->belongsToMany(User::class)->withTimestamps();
    }
    
}
