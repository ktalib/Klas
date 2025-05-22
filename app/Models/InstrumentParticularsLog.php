<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstrumentParticularsLog extends Model
{
    use HasFactory;
    
    protected $table = 'instrument_particulars_log';
    protected $fillable = [
        'instrument_id',
        'serial_no',
        'page_no',
        'volume_no',
        'generated_particulars_number'
    ];
    
    /**
     * Get the instrument that owns this particulars log entry
     */
    public function instrument()
    {
        return $this->belongsTo(Instrument::class, 'instrument_id');
    }
}
