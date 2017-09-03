<?php

namespace admin;

use BaseController;
use View;
use Validator;
use Input;
use Session;
use Redirect;
use Nation;

class NationController extends BaseController {
    
    /*
	|--------------------------------------------------------------------------
	| Post event create nation
	|--------------------------------------------------------------------------
	*/
    
    public function postCreate()
    {
        $rules = array(
            'name' => 'required|unique:nations,name'
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
            $nation = new Nation;
            foreach ($values as $key => $value)
            {
                $nation->{$key} = $value;
            }
            $nation->save();
            
            Session::flash('add_nation_success', 1);
        }
        
        return Redirect::to('admin/employeesetting/nation');
    }
    
    /*
	|--------------------------------------------------------------------------
	| Get event delete nation
	|--------------------------------------------------------------------------
	*/
    
    public function getDelete($id)
    {
        $nation = Nation::find($id);
        if ($nation == NULL)
        {
            Session::flash('not_found', 1);
        }
        else
        {            
            Nation::destroy($id);
            Session::flash('delete_nation_success', 1);
        }
        
        return Redirect::to('admin/employeesetting/nation');
    }
    
    /*
	|--------------------------------------------------------------------------
	| Event edit employee type
	|--------------------------------------------------------------------------
	*/
    
    public function postEdit()
    {
        $rules = array(
            'name' => 'required|unique:nations,name,'.Input::get('id')
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails())
        {
            Session::put('error_messages', $validator->messages());
            Session::put('input_values', Input::all());
            Session::flash('edit_nation_failed', 1);
        }
        else
        {
            $values = Input::all();
            $nation = Nation::find(Input::get('id'));
            foreach ($values as $key => $value)
            {
                $nation->{$key} = $value;
            }
            $nation->save();
            
            Session::flash('edit_nation_success', 1);  
        }
        
        return Redirect::to('admin/employeesetting/nation');
    }
    
    /*
	|--------------------------------------------------------------------------
	| Index nation list
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
            'nations' => Nation::orderBy('name', 'ASC')->get()
        );
        
        if (Session::has('error_messages'))
        {
            if (Session::has('edit_nation_failed'))
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
        
        return View::make('admin.nation.index', $data);
    }
    
}