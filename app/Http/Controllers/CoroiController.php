<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CoroiController extends Controller
{
    protected $validTables = [
        'registered_instruments' => ['id' => 'Grantor', 'type' => null],
        'SectionalCofOReg' => ['id' => 'Applicant_Name', 'type' => 'Sectional Title Certificates of Occupancy'],
        'Sectional_title_transfer' => ['id' => 'Applicant_Name', 'type' => 'Transfer of Title']
    ];

    public function index(Request $request)
    {
        // Parse URL parameters
        $url = $request->query('url', '');
        $stmRef = $request->query('STM_Ref', '');
        
        // Handle special URL format
        if (empty($stmRef) && !empty($url) && strpos($url, '?STM_Ref=') !== false) {
            $parts = explode('?STM_Ref=', $url);
            if (count($parts) == 2) {
                $tableName = $parts[0];
                $stmRef = $parts[1];
            }
        } else {
            $tableName = $url;
        }
        
        // Return mock data if STM_Ref is missing
        if (empty($stmRef)) {
            $data = $this->formatDateTimeData($this->createMockData());
        } else {
            // Search for data in the specified table or all tables
            $data = $this->findRecord($tableName, $stmRef);
        }
        
        return view('coroi.index', ['data' => $data]);
    }
    
    private function findRecord($tableName, $stmRef)
    {
        try {
            // If table is specified and valid, search there first
            if (!empty($tableName) && isset($this->validTables[$tableName])) {
                $data = $this->queryTable($tableName, $stmRef);
                if ($data) return $this->formatDateTimeData($data);
            }
            
            // Search all tables if no data found
            foreach ($this->validTables as $table => $config) {
                $data = $this->queryTable($table, $stmRef);
                if ($data) return $this->formatDateTimeData($data);
            }
            
            // Return mock data as last resort
            return $this->formatDateTimeData($this->createMockData($stmRef));
        } catch (\Exception $e) {
            Log::error('Error querying database: ' . $e->getMessage());
            return $this->formatDateTimeData($this->createMockData($stmRef));
        }
    }
    
    private function queryTable($table, $stmRef)
    {
        $config = $this->validTables[$table];
        $idColumn = $config['id'];
        $nameAlias = $idColumn === 'Grantor' ? "$idColumn as Applicant_Name" : $idColumn;
        $type = $config['type'] !== null ? "'$config[type]' as instrument_type" : 'instrument_type';
        
        $stmt = DB::connection('sqlsrv')->getPdo()->prepare("
            SELECT TOP 1
                $nameAlias,
                $type,
                volume_no,
                page_no,
                serial_no,
                deeds_time,
                deeds_date,
                STM_Ref
            FROM $table
            WHERE STM_Ref = ?
        ");
        
        $stmt->execute([$stmRef]);
        $data = $stmt->fetch(\PDO::FETCH_OBJ);
        
        if (!$data) {
            // Try with LIKE search
            $stmt = DB::connection('sqlsrv')->getPdo()->prepare("
                SELECT TOP 1
                    $nameAlias,
                    $type,
                    volume_no,
                    page_no,
                    serial_no,
                    deeds_time,
                    deeds_date,
                    STM_Ref
                FROM $table
                WHERE STM_Ref LIKE ?
            ");
            
            $stmt->execute(['%' . $stmRef . '%']);
            $data = $stmt->fetch(\PDO::FETCH_OBJ);
        }
        
        return $data;
    }
    
    private function createMockData($stmRef = null)
    {
        $year = date('Y');
        return (object)[
            'Applicant_Name' => 'DEFAULT APPLICANT',
            'instrument_type' => 'DEFAULT INSTRUMENT',
            'volume_no' => 1,
            'page_no' => 1,
            'serial_no' => 1,
            'deeds_time' => '12:00 PM',
            'deeds_date' => date('Y-m-d'),
            'STM_Ref' => $stmRef ?: "STM-{$year}-001"
        ];
    }
    
    private function formatDateTimeData($data)
    {
        if (!$data) return $this->createMockData();
        
        $data->formatted_date = isset($data->deeds_date) ? 
            date('jS F Y', strtotime($data->deeds_date)) : 
            date('jS F Y');
            
        if (isset($data->deeds_time)) {
            $data->formatted_time = date('g:i A', strtotime($data->deeds_time));
            $data->time_part = date('A', strtotime($data->deeds_time));
            $data->hour_part = date('g', strtotime($data->deeds_time));
        } else {
            $data->formatted_time = '12:00 PM';
            $data->time_part = 'PM';
            $data->hour_part = '12';
            $data->deeds_time = '12:00 PM';
        }
        
        return $data;
    }
}
