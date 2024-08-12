<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'hospital_id',
        'speciality_id',
        'appointment_date',
        'status'
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id');
    }

    public function speciality()
    {
        return $this->belongsTo(Speciality::class, 'speciality_id');
    }
}
