<?php

namespace admin;

use View;
use BaseController;
use Validator;
use Input;
use User;
use Session;
use Redirect;
use Hash;

class UserController extends BaseController {
    
    /*
	|--------------------------------------------------------------------------
	| User list index
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
            'users' => User::all()
        );
        
        if (Session::has('error_messages'))
        {
            if (Session::has('edit_user_failed'))
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
        
        return View::make('admin.user.index', $data);
    }
    
    /*
	|--------------------------------------------------------------------------
	| Event create user list
	|--------------------------------------------------------------------------
	*/
    
    public function postCreate()
    {
        $rules = array(
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|alpha_num|min:4|same:cpassword|regex:/\pL/|regex:/\pN/',
            'cpassword' => 'required|alpha_num|min:4|same:password|regex:/\pL/|regex:/\pN/'
        );
        
        $messages = array(
            'regex' => 'Password must contain alphanumeric'
        );

        $validator = Validator::make(Input::all(), $rules, $messages);
        
        if ($validator->fails())
        {
            Session::put('error_messages', $validator->messages());
            Session::put('input_values', Input::all());
            Session::flash('add_user_failed', 1);
        }
        else
        {            
            $values = Input::all();
            $user = new User;
            foreach ($values as $key => $value)
            {
                if ($key == "password") 
                {
                    $value = Hash::make($value);
                }
                
                if ($key != "cpassword") 
                {
                    $user->{$key} = $value;
                }
            }
            $user->save();
            
            Session::flash('add_user_success', 1);
        }
        
        if (null !== Input::get('employee_id'))
        {
            // create from employee detail > tab > login credential
            return Redirect::to('admin/employee/login/'.Input::get('employee_id'));
        }
        else
        {
            // create from user list 
            return Redirect::to('admin/user');
        }
    }
    
    /*
	|--------------------------------------------------------------------------
	| Post event edit user
	|--------------------------------------------------------------------------
	*/
    
    public function postEdit()
    {
        $update_password = false;
        
        $rules = array(
            'username' => 'required|unique:users,username,'.Input::get('id'),
            'email' => 'required|email|unique:users,email,'.Input::get('id')
        );
        
        if (Input::get('password') != "" && Input::get('cpassword') != "")
        {
            $rules['password'] = 'required|alpha_num|min:4|same:cpassword|regex:/\pL/|regex:/\pN/';
            $rules['cpassword'] = 'required|alpha_num|min:4|same:password|regex:/\pL/|regex:/\pN/';
            $update_password = true;
        }
        
        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails())
        {
            Session::put('error_messages', $validator->messages());
            Session::put('input_values', Input::all());
            Session::flash('edit_user_failed', 1);
        }
        else
        {
            $values = Input::all();
            $user = User::find(Input::get('id'));
            foreach ($values as $key => $value)
            {
                if ($update_password) 
                {
                    if ($key == "password")
                    {
                        $value = Hash::make($value);
                    }
                    
                    if ($key != "cpassword")
                    {
                        $user->{$key} = $value;
                    }
                }
                
                if (!$update_password)
                {
                    if ($key != "cpassword" && $key != "password")
                    {
                        $user->{$key} = $value;
                    }
                }
                
            }
            $user->save();
            
            Session::flash('edit_user_success', 1);  
        }
        
        if (null !== Input::get('employee_id'))
        {
            // edit from employee detail > tab > login credential
            return Redirect::to('admin/employee/login/'.Input::get('employee_id'));
        }
        else
        {
            // edit from user list
            return Redirect::to('admin/user');
        }
    }
    
    /*
	|--------------------------------------------------------------------------
	| Get event delete user
	|--------------------------------------------------------------------------
	*/
    
    public function getDelete($id)
    {
        $user = User::find($id);
        if ($user == NULL)
        {
            Session::flash('not_found', 1);
        }
        else
        {            
            User::destroy($id);
            Session::flash('delete_user_success', 1);
        }
        
        return Redirect::to('admin/user');
    }
}