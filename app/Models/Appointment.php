<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospital_id',
        'speciality_id', // Use speciality_id for department_id
        'doctor_id',
        'date',
        'time_slot',
        'title',
        'description',
        'status',
        'opd_number',
        'patient_name',
        'age',
        'age_month',
        'mobile_number',
        'sex',
        'village',
        'taluka',
        'opd_date',
        'provisional',
        'weight',
        'height',
        'temperature',
        'bp',
        'pulse',
        'spo2',
        'rr',
        'paller',
        'clubbing',
        'cyanosis',
        'oedema',
        'RS',
        'CVS',
        'CNS',
        'PA',
        'LMP',
        'G',
        'P',
        'L',
        'A',
        'age_of_last_child',
        'type_of_last_delivery',
        'personal_ho',
        'past_ho',
        'chief_complaint',
        'past_history',
        'family_history',
        'vitals_general_examination',
        'personal_history',
        'allergic_history',
        'obstetric_history',
        'treatment',
        'remarks'
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
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
