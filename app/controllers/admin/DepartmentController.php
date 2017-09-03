<?php

namespace admin;

use View;
use BaseController;
use Validator;
use Input;
use Session;
use Redirect;
use Department;

class DepartmentController extends BaseController {
    
    /*
	|--------------------------------------------------------------------------
	| Post event create department
	|--------------------------------------------------------------------------
	*/
    
    public function postCreate()
    {
        $rules = array(
            'name' => 'required|unique:department,name'
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails())
        {
            Session::put('error_messages', $validator->messages());
            Session::put('input_values', Input::all());
            Session::flash('add_department_failed', 1);
        }
        else
        {
            $values = Input::all();
            $department = new Department;
            foreach ($values as $key => $value)
            {
                $department->{$key} = $value;
            }
            $department->save();
            
            Session::flash('add_department_success', 1);
        }
        
        return Redirect::to('admin/department');
    }
    
    /*
	|--------------------------------------------------------------------------
	| Post event edit department
	|--------------------------------------------------------------------------
	*/
    
    public function postEdit()
    {
        $rules = array(
            'name' => 'required|unique:department,name,'.Input::get('id')
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails())
        {
            Session::put('error_messages', $validator->messages());
            Session::put('input_values', Input::all());
            Session::flash('edit_department_failed', 1);
        }
        else
        {
            $values = Input::all();
            $department = Department::find(Input::get('id'));
            foreach ($values as $key => $value)
            {
                $department->{$key} = $value;
            }
            $department->save();
            
            Session::flash('edit_department_success', 1);  
        }
        
        return Redirect::to('admin/department');
    }
    
    /*
	|--------------------------------------------------------------------------
	| Get event delete job title
	|--------------------------------------------------------------------------
	*/
    
    public function getDelete($id)
    {
        $department = Department::find($id);
        if ($department == NULL)
        {
            Session::flash('not_found', 1);
        }
        else
        {            
            Department::destroy($id);
            Session::flash('delete_department_success', 1);
        }
        
        return Redirect::to('admin/department');
    }
    
    /*
	|--------------------------------------------------------------------------
	| Department list index
	|--------------------------------------------------------------------------
	*/
    
    public function getIndex()
    {
        $data = array(
            'departments' => Department::orderBy('name', 'ASC')->get()
        );
        
        if (Session::has('error_messages'))
        {
            $data['error_messages'] = Session::get('error_messages');
            $data['input_values'] = Session::get('input_values');
            Session::forget('error_messages');
            Session::forget('input_values');
        }
        
        return View::make('admin.department.index', $data);
    }
}