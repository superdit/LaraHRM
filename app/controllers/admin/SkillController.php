<?php

namespace admin;

use BaseController;
use Input;
use Session;
use Validator;
use Redirect;
use Skill;

class SkillController extends BaseController {
    
    /*
	|--------------------------------------------------------------------------
	| Post event add employee work
	|--------------------------------------------------------------------------
	*/
    
    public function postAddToEmployee()
    {        
        $rules = array(
            'name' => 'required',
            'level' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails())
        {
            Session::put('error_messages', $validator->messages());
            Session::put('input_values', Input::all());
            Session::flash('add_skill_failed', 1);
        }
        else
        {
            $values = Input::all();
            
            $skill = new Skill;
            foreach ($values as $key => $value)
            {
                $skill->{$key} = $value;
            }
            $skill->save();
            
            Session::flash('add_skill_success', 1);
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
            'name' => 'required',
            'level' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails())
        {
            Session::put('error_messages', $validator->messages());
            Session::put('input_values', Input::all());
            Session::flash('edit_skill_failed', 1);
        }
        else
        {
            $values = Input::all();
            $skill = Skill::find(Input::get('id'));
            foreach ($values as $key => $value)
            {
                $skill->{$key} = $value;
            }
            $skill->save();
            
            Session::flash('edit_skill_success', 1);  
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
        $skill = Skill::find($id);
        if ($skill == NULL)
        {
            Session::flash('not_found', 1);
        }
        else
        {            
            Skill::destroy($id);
            Session::flash('delete_skill_success', 1);
        }
        
        return Redirect::to('admin/employee/qualification/'.$employee_id);
    }
}