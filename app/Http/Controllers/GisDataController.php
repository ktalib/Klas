<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;

class ApplicationMotherController extends Controller
{

 

     public function AssignRole()
    {
        $user = Auth::user();
        $role = $user->assign_role;

        if ($role == 'owner') {
            return 'owner';
        } elseif (strpos($role, 'Programmes -') !== false) {
            return 'programmes';
        } else {
            return 'access denied';
        }
    }

    public function index()
    {
        

        return view('gis.index', compact('Main_application', 'role'));
    }
   
 
}
