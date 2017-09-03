<?php

namespace admin;

use BaseController;
use Input;
use Validator;
use Redirect;
use Session;
use Education;

class EducationController extends BaseController {
    
    /*
	|--------------------------------------------------------------------------
	| Post event add employee work
	|--------------------------------------------------------------------------
	*/
    
    public function postAddToEmployee()
    {        
        $rules = array(
            'school_name' => 'required',
            'start_date' => 'required|date_format:"Y-m-d"',  
            'graduate_date' => 'required|date_format:"Y-m-d"',  
            'field_of_study' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails())
        {
            Session::put('error_messages', $validator->messages());
            Session::put('input_values', Input::all());
            Session::flash('add_education_failed', 1);
        }
        else
        {
            $values = Input::all();
            $education = new Education;
            foreach ($values as $key => $value)
            {
                $education->{$key} = $value;
            }
            $education->save();
            
            Session::flash('add_education_success', 1);
        }
        return Redirect::to('admin/employee/qualification/'.Input::get('employee_id'));
    }
    
    /*
	|--------------------------------------------------------------------------
	| Post event edit employee education
	|--------------------------------------------------------------------------
	*/
    
    public function postEditFromEmployee()
    {
        $rules = array(
            'school_name' => 'required',
            'start_date' => 'required|date_format:"Y-m-d"',  
            'graduate_date' => 'required|date_format:"Y-m-d"',  
            'field_of_study' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails())
        {
            Session::put('error_messages', $validator->messages());
            Session::put('input_values', Input::all());
            Session::flash('edit_education_failed', 1);
        }
        else
        {
            $values = Input::all();
            
            $education = Education::find(Input::get('id'));
            foreach ($values as $key => $value)
            {
                $education->{$key} = $value;
            }
            $education->save();
            
            Session::flash('edit_education_success', 1);  
        }
        
        return Redirect::to('admin/employee/qualification/'.Input::get('employee_id'));
    }
    
    /*
	|--------------------------------------------------------------------------
	| Get event delete education from employee
	|--------------------------------------------------------------------------
	*/
    
    public function getDeleteFromEmployee($employee_id, $id)
    {
        $education = Education::find($id);
        if ($education == NULL)
        {
            Session::flash('not_found', 1);
        }
        else
        {            
            Education::destroy($id);
            Session::flash('delete_education_success', 1);
        }
        
        return Redirect::to('admin/employee/qualification/'.$employee_id);
    }
}

