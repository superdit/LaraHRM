<?php

namespace admin;

use BaseController;
use View;
use Validator;
use Input;
use Session;
use Redirect;
use EmployeeType;

class EmployeetypeController extends BaseController {
    
    /*
	|--------------------------------------------------------------------------
	| Index employee type list
	|--------------------------------------------------------------------------
	*/
    
    public function getIndex()
    {
        $data = array(
            'open_create_modal' => 0,
            'open_edit_modal' => 0,
            'add_user_success' => 0,
            'edit_success' => 0,
            'delete_success' => 0,
            'emptypes' => EmployeeType::orderBy('name', 'ASC')->get()
        );
        
        if (Session::has('error_messages'))
        {
            if (Session::has('edit_emptype_failed'))
            {
                $data['open_edit_modal'] = 1;
            }
            else 
            {
                $data['open_create_modal'] = 1;
            }
            $data['error_messages'] = Session::get('error_messages');
            $data['input_values'] = Session::get('input_values');
            Session::forget('error_messages');
            Session::forget('input_values');
        }
        
        return View::make('admin.employeetype.index', $data);
    }
    
    /*
	|--------------------------------------------------------------------------
	| Get event delete employeetype
	|--------------------------------------------------------------------------
	*/
    
    public function getDelete($id)
    {
        $emptype = EmployeeType::find($id);
        if ($emptype == NULL)
        {
            Session::flash('not_found', 1);
        }
        else
        {            
            EmployeeType::destroy($id);
            Session::flash('delete_emptype_success', 1);
        }
        
        return Redirect::to('admin/employeesetting/employmenttype');
    }
    
    /*
	|--------------------------------------------------------------------------
	| Event create new employee type
	|--------------------------------------------------------------------------
	*/
    
    public function postCreate()
    {
        $rules = array(
            'name' => 'required|unique:employee_type,name'
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails())
        {
            Session::put('error_messages', $validator->messages());
            Session::put('input_values', Input::all());
        }
        else
        {
            $values = Input::all();
            $type = new EmployeeType;
            foreach ($values as $key => $value)
            {
                $type->{$key} = $value;
            }
            $type->save();
            
            Session::flash('add_emptype_success', 1);
        }
        
        return Redirect::to('admin/employeesetting/employmenttype');
    }
    
    /*
	|--------------------------------------------------------------------------
	| Event edit employee type
	|--------------------------------------------------------------------------
	*/
    
    public function postEdit()
    {
        $rules = array(
            'name' => 'required|unique:employee_type,name,'.Input::get('id')
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails())
        {
            Session::put('error_messages', $validator->messages());
            Session::put('input_values', Input::all());
            Session::flash('edit_emptype_failed', 1);
        }
        else
        {
            $values = Input::all();
            $emptype = EmployeeType::find(Input::get('id'));
            foreach ($values as $key => $value)
            {
                $emptype->{$key} = $value;
            }
            $emptype->save();
            
            Session::flash('edit_emptype_success', 1);  
        }
        
        return Redirect::to('admin/employeesetting/employmenttype');
    }
}