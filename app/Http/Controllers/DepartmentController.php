<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->type != 'super admin' && !Auth::user()->can('manage user')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
       $PageTitle = 'Departments';
       $PageDescription='List of all departments';


        $departments = Department::orderBy('name', 'asc')->get();
        return view('department.index', compact('departments', 'PageTitle', 'PageDescription'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->type != 'super admin' && !Auth::user()->can('create user')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        return view('department.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->type != 'super admin' && !Auth::user()->can('create user')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:departments',
            'code' => 'required|string|max:50|unique:departments',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Department::create([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? 1 : 0
        ]);

        return redirect()->route('departments.index')->with('success', __('Department created successfully'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->type != 'super admin' && !Auth::user()->can('edit user')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $department = Department::find($id);
        return view('department.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->type != 'super admin' && !Auth::user()->can('edit user')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $department = Department::find($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:departments,name,' . $id,
            'code' => 'required|string|max:50|unique:departments,code,' . $id,
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $department->update([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? 1 : 0
        ]);

        return redirect()->route('departments.index')->with('success', __('Department updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->type != 'super admin' && !Auth::user()->can('delete user')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
        
        $department = Department::find($id);
        
        // Check if department has users or roles
        if ($department->users()->count() > 0) {
            return redirect()->back()->with('error', __('Cannot delete department with assigned users'));
        }
        
        if ($department->userRoles()->count() > 0) {
            return redirect()->back()->with('error', __('Cannot delete department with assigned roles'));
        }
        
        $department->delete();
        return redirect()->route('departments.index')->with('success', __('Department deleted successfully'));
    }
}
