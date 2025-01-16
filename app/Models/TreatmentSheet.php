<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreatmentSheet extends Model
{
    use HasFactory;
    protected $table = 'treatment_sheet';
    protected $fillable = [
        'appointment_id',
        'medication_name',
        'dosage',
        'root',
        'time_of_admission',
        'signature',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
