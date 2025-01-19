<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = ['doctor_id', 'pharmacist_id', 'patient_id', 'notes','status'];

    // Define the relationship between Prescription and Appointment
    public function appointment()
    {
        return $this->belongsTo(Appointment::class,'appointment_id');
    }

    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    
}
