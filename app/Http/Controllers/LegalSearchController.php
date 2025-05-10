<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class LegalSearchController extends Controller
{
    public function index()
    { 
        $PageTitle = 'Legal Search - On-Premise Official';
        $PageDescription = '';
        $Main_application = DB::connection('sqlsrv')->table('dbo.mother_applications')->get();
        return view('legal_search.index', compact('Main_application', 'PageTitle', 'PageDescription'));
    }

    public function report()
    {
        return view('legal_search.report');
    }

    public function legal_search_report()
    {
        $PageTitle = 'Legal Search Report';
        return view('legal_search.legal_search_report');
    }
    
   
   
}