<?php

namespace admin;

use BaseController;
use View;
use Validator;
use Input;
use Session;
use Redirect;
use SalaryComponent;
use SalaryDeduction;

class SalarycomponentController extends BaseController {
    
    /*
	|--------------------------------------------------------------------------
	| Event create
	|--------------------------------------------------------------------------
	*/
    
    public function postCreate()
    {
        $rules = array(
            'name' => 'required|unique:salary_component,name',
            'amount' => 'required|numeric'
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails())
        {
            Session::put('error_messages', $validator->messages());
            Session::put('input_values', Input::all());
            Session::flash('add_salcomp_failed', 1);
        }
        else
        {
            $values = Input::all();
            $salaryComponent = new SalaryComponent;
            foreach ($values as $key => $value)
            {
                $salaryComponent->{$key} = $value;
            }
            $salaryComponent->save();
            
            Session::flash('add_salcomp_success', 1);
        }
        
        return Redirect::to('admin/employeesetting/salarycomponent');
    }
    
    /*
	|--------------------------------------------------------------------------
	| Post event edit job
	|--------------------------------------------------------------------------
	*/
    
    public function postEdit()
    {
        $rules = array(
            'name' => 'required|unique:salary_component,name,'.Input::get('id'),
            'amount' => 'required|numeric'
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails())
        {
            Session::put('error_messages', $validator->messages());
            Session::put('input_values', Input::all());
            Session::flash('edit_salcomp_failed', 1);
        }
        else
        {
            $values = Input::all();
            $salaryComponent = SalaryComponent::find(Input::get('id'));
            foreach ($values as $key => $value)
            {
                $salaryComponent->{$key} = $value;
            }
            $salaryComponent->save();
            
            Session::flash('edit_salcomp_success', 1);  
        }
        
        return Redirect::to('admin/employeesetting/salarycomponent');
    }
    
    /*
	|--------------------------------------------------------------------------
	| Get event delete salary component
	|--------------------------------------------------------------------------
	*/
    
    public function getDelete($id)
    {
        $salaryComponent = SalaryComponent::find($id);
        if ($salaryComponent == NULL)
        {
            Session::flash('not_found', 1);
        }
        else
        {            
            $salaryComponent::destroy($id);
            Session::flash('delete_salcomp_success', 1);
        }
        
        return Redirect::to('admin/employeesetting/salarycomponent');
    }
    
    /*
	|--------------------------------------------------------------------------
	| Get list salary component
	|--------------------------------------------------------------------------
	*/
    
    public function getIndex()
    {
        $data = array(
            'open_create_modal' => 0,
            'open_edit_modal' => 0,
            'salaryComponents' => SalaryComponent::orderBy('name', 'ASC')->get(),
            'salaryDeductions' => SalaryDeduction::orderBy('name', 'ASC')->get()
        );
        
        if (Session::has('error_messages'))
        {
            if (Session::has('edit_salcomp_failed'))
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
        
        return View::make('admin.salarycomponent.index', $data);
    }
    
    
    /*
	|--------------------------------------------------------------------------
	| Event create salary deduction
	|--------------------------------------------------------------------------
	*/
    
    public function postCreateDeduction()
    {
        $rules = array(
            'name' => 'required|unique:salary_deduction,name',
            'amount' => 'required|numeric'
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails())
        {
            Session::put('error_messages', $validator->messages());
            Session::put('input_values', Input::all());
            Session::flash('add_saldeduc_failed', 1);
        }
        else
        {
            $values = Input::all();
            $salaryDeduction = new SalaryDeduction;
            foreach ($values as $key => $value)
            {
                $salaryDeduction->{$key} = $value;
            }
            $salaryDeduction->save();
            
            Session::flash('add_saldeduc_success', 1);
        }
        
        return Redirect::to('admin/employeesetting/salarycomponent');
    }
    
    /*
	|--------------------------------------------------------------------------
	| Post event edit salary deduction
	|--------------------------------------------------------------------------
	*/
    
    public function postEditDeduction()
    {
        $rules = array(
            'name' => 'required|unique:salary_deduction,name,'.Input::get('id'),
            'amount' => 'required|numeric'
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails())
        {
            Session::put('error_messages', $validator->messages());
            Session::put('input_values', Input::all());
            Session::flash('edit_saldeduc_failed', 1);
        }
        else
        {
            $values = Input::all();
            $salaryDeduction = SalaryDeduction::find(Input::get('id'));
            foreach ($values as $key => $value)
            {
                $salaryDeduction->{$key} = $value;
            }
            $salaryDeduction->save();
            
            Session::flash('edit_saldeduc_success', 1);  
        }
        
        return Redirect::to('admin/employeesetting/salarycomponent');
    }
    
    /*
	|--------------------------------------------------------------------------
	| Get event delete salary deduction
	|--------------------------------------------------------------------------
	*/
    
    public function getDeleteDeduction($id)
    {
        $salaryDeduction = SalaryDeduction::find($id);
        if ($salaryDeduction == NULL)
        {
            Session::flash('not_found', 1);
        }
        else
        {            
            $salaryDeduction::destroy($id);
            Session::flash('delete_saldeduc_success', 1);
        }
        
        return Redirect::to('admin/employeesetting/salarycomponent');
    }
}
    