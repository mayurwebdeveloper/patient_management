<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'dosage', 'frequency', 'prescription_id'];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }
}
