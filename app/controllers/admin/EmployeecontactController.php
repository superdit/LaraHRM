<?php

namespace admin;

use BaseController;
use Validator;
use Input;
use Session;
use Redirect;
use EmployeeContact;

class EmployeecontactController extends BaseController {
    
    /*
	|--------------------------------------------------------------------------
	| Post event add employee contact
	|--------------------------------------------------------------------------
	*/
    
    public function postAddToEmployee()
    {        
        $rules = array(
            'contact_name' => 'required',
            'relationship' => 'required',
//            'home_phone' => 'required',
//            'work_phone' => 'required',
//            'mobile_phone' => 'required',
            'email' => 'email'
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails())
        {
            Session::put('error_messages', $validator->messages());
            Session::put('input_values', Input::all());
            Session::flash('add_contact_failed', 1);
        }
        else
        {
            $values = Input::all();
            $contact = new EmployeeContact;
            foreach ($values as $key => $value)
            {
                $contact->{$key} = $value;
            }
            $contact->save();
            
            Session::flash('add_contact_success', 1);
        }
        return Redirect::to('admin/employee/contact/'.Input::get('employee_id'));
    }
    
    /*
	|--------------------------------------------------------------------------
	| Post event edit employee contact
	|--------------------------------------------------------------------------
	*/
    
    public function postEditFromEmployee()
    {
        $rules = array(
            'contact_name' => 'required',
            'relationship' => 'required',
//            'home_phone' => 'required',
//            'work_phone' => 'required',
//            'mobile_phone' => 'required',
            'email' => 'email'
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails())
        {
            Session::put('error_messages', $validator->messages());
            Session::put('input_values', Input::all());
            Session::flash('edit_contact_failed', 1);
        }
        else
        {
            $values = Input::all();
            $contact = EmployeeContact::find(Input::get('id'));
            foreach ($values as $key => $value)
            {
                $contact->{$key} = $value;
            }
            $contact->save();
            
            Session::flash('edit_contact_success', 1);  
        }
        
        return Redirect::to('admin/employee/contact/'.Input::get('employee_id'));
    }
    
    /*
	|--------------------------------------------------------------------------
	| Get event delete contact from employee
	|--------------------------------------------------------------------------
	*/
    
    public function getDeleteFromEmployee($employee_id, $id)
    {
        $contact = EmployeeContact::find($id);
        if ($contact == NULL)
        {
            Session::flash('not_found', 1);
        }
        else
        {            
            EmployeeContact::destroy($id);
            Session::flash('delete_contact_success', 1);
        }
        
        return Redirect::to('admin/employee/contact/'.$employee_id);
    }
    
}