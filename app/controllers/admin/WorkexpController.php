<?php

namespace admin;

use BaseController;
use Input;
use Session;
use Validator;
use WorkExperience;
use Redirect;

class WorkexpController extends BaseController {
    
    /*
	|--------------------------------------------------------------------------
	| Post event add employee work
	|--------------------------------------------------------------------------
	*/
    
    public function postAddToEmployee()
    {        
        $rules = array(
            'company_name' => 'required',
            'from_date' => 'required|date_format:"Y-m-d"',  
            'to_date' => 'required|date_format:"Y-m-d"',  
            'job_title' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails())
        {
            Session::put('error_messages', $validator->messages());
            Session::put('input_values', Input::all());
            Session::flash('add_workexp_failed', 1);
        }
        else
        {
            $values = Input::all();
            $workExperience = new WorkExperience;
            foreach ($values as $key => $value)
            {
                $workExperience->{$key} = $value;
            }
            $workExperience->save();
            
            Session::flash('add_workexp_success', 1);
        }
        return Redirect::to('admin/employee/qualification/'.Input::get('employee_id'));
    }
    
    /*
	|--------------------------------------------------------------------------
	| Post event edit employee work experience
	|--------------------------------------------------------------------------
	*/
    
    public function postEditFromEmployee()
    {
        $rules = array(
            'company_name' => 'required',
            'from_date' => 'required|date_format:"Y-m-d"',  
            'to_date' => 'required|date_format:"Y-m-d"',  
            'job_title' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails())
        {
            Session::put('error_messages', $validator->messages());
            Session::put('input_values', Input::all());
            Session::flash('edit_workexp_failed', 1);
        }
        else
        {
            $values = Input::all();
            $workExperience = WorkExperience::find(Input::get('id'));
            foreach ($values as $key => $value)
            {
                $workExperience->{$key} = $value;
            }
            $workExperience->save();
            
            Session::flash('edit_workexp_success', 1);  
        }
        
        return Redirect::to('admin/employee/qualification/'.Input::get('employee_id'));
    }
    
    /*
	|--------------------------------------------------------------------------
	| Get event delete work experience from employee
	|--------------------------------------------------------------------------
	*/
    
    public function getDeleteFromEmployee($employee_id, $id)
    {
        $workExperience = WorkExperience::find($id);
        if ($workExperience == NULL)
        {
            Session::flash('not_found', 1);
        }
        else
        {            
            WorkExperience::destroy($id);
            Session::flash('delete_workexp_success', 1);
        }
        
        return Redirect::to('admin/employee/qualification/'.$employee_id);
    }
}
