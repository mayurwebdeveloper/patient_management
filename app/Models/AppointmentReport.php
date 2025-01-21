<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Report;

class AppointmentReport extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'appointment_report';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'appointment_id',
        'followup_id',
        'report_id',
        'date',
        'status',
    ];

    /**
     * Get the appointment associated with this report.
     */
    public function appointment()
    {
        return $this->belongsTo(App\Models\Appointment::class);
    }

    /**
     * Get the followup associated with this report.
     */
    public function followup()
    {
        return $this->belongsTo(App\Models\Followup::class);
    }

    /**
     * Get the report details.
     */
    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
