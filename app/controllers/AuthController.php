<?php

class AuthController extends BaseController {
    
    public function getIndex()
    {
        return Redirect::to('auth/signin');
    }
    
    public function getSignin()
    {        
        return View::make('auth.signin');
    }
    
    public function getSignout()
    {        
        Auth::logout();
        return Redirect::to('auth/signin');
    }
    
    public function postSignin()
    {
        if (Auth::attempt(array('email'=>Input::get('email'), 'password'=>Input::get('password')))) 
        {
            //echo Auth::user()->role; exit;
            
            if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
            {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
            else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
            {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            else
            {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            
            $user = User::find(Auth::user()->id);
            $user->last_login = date("Y-m-d H:i:s");
            $user->last_user_agent = $_SERVER['HTTP_USER_AGENT'];
            $user->last_ip = $ip;
            $user->save();
            if ($user->role === "admin")
            {
                return Redirect::to('admin/employee');
            }
            else
            {
                return Redirect::to('employee/home');
            }
		} 
        else 
        {
			return Redirect::to('auth/signin')
				->with('message', 'Your username/password combination was incorrect');
		}
    }
}