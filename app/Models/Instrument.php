<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{
    use HasFactory;
    
    protected $table = 'instrument_registration';
    
    protected $fillable = [
        'MLSFileNo',
        'KAGISFileNO',
        'NewKANGISFileNo',
        'particularsRegistrationNumber',
        'instrument_type',
        'Grantor',
        'GrantorAddress',
        'Grantee',
        'GranteeAddress',
        'instrumentDate',
        'propertyDescription',
        'solicitorName',
        'solicitorAddress',
        'lga',
        'district',
        'size',
        'plotNumber'
    ];
    
    /**
     * Get the particulars log entries for this instrument
     */
    public function particularsLogs()
    {
        return $this->hasMany(InstrumentParticularsLog::class, 'instrument_id');
    }
    
    /**
     * Generate a particularsRegistrationNumber for this instrument
     * 
     * @return string The generated particularsRegistrationNumber
     */
    public function generateParticularsRegistrationNumber()
    {
        // Generate the next number
        $nextNumber = ParticularRegistrationSequence::generateNext();
        
        // Update the instrument
        $this->particularsRegistrationNumber = $nextNumber['formatted'];
        $this->save();
        
        // Log the generation
        $this->particularsLogs()->create([
            'serial_no' => $nextNumber['serial_no'],
            'page_no' => $nextNumber['page_no'],
            'volume_no' => $nextNumber['volume_no'],
            'generated_particulars_number' => $nextNumber['formatted']
        ]);
        
        return $nextNumber['formatted'];
    }
}
