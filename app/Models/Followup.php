<?php 

// app/Models/Followup.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Followup extends Model
{
    use HasFactory;

    protected $table = 'followup'; // Make sure this is the name of your table
    protected $fillable = [
        'appointment_id',
        'patient_id',
        'doctor_id',
        'hospital_id',
        'speciality_id',
        'appointment_date',
        'date',
        'time_slot',
        'title',
        'description',
        'status',
        'scheduled',
        'patient_name',
        'opd_number',
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
        'pulse',
        'bp',
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
        'remarks','scheduled'
    ];

    // Optionally, you can add relationships here if needed (e.g., appointment, patient, etc.)

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

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
