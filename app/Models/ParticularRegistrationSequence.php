<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticularRegistrationSequence extends Model
{
    use HasFactory;
    
    protected $table = 'particulars_registration_sequence';
    public $timestamps = false;
    protected $fillable = ['last_serial_no', 'last_page_no', 'last_volume_no'];
    
    /**
     * Generate the next particularsRegistrationNumber
     * 
     * @return array Contains the number components and formatted string
     */
    public static function generateNext()
    {
        // Get current sequence (or create if doesn't exist)
        $sequence = self::firstOrCreate(['id' => 1], [
            'last_serial_no' => 0,
            'last_page_no' => 0,
            'last_volume_no' => 1
        ]);
        
        // Calculate next values
        $serial = $sequence->last_serial_no + 1;
        $page = $sequence->last_page_no + 1;
        $volume = $sequence->last_volume_no;
        
        // Check if we need to increment volume
        if ($serial > 300) {
            $serial = 1;
            $page = 1;
            $volume++;
        }
        
        // Update the sequence
        $sequence->update([
            'last_serial_no' => $serial,
            'last_page_no' => $page,
            'last_volume_no' => $volume
        ]);
        
        // Format the number as S/P/V
        $formatted = "{$serial}/{$page}/{$volume}";
        
        return [
            'serial_no' => $serial,
            'page_no' => $page,
            'volume_no' => $volume,
            'formatted' => $formatted
        ];
    }
}
