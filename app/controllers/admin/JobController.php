<?php

namespace admin;

use BaseController;
use View;
use Validator;
use Input;
use Session;
use Redirect;
use Job;

class JobController extends BaseController {
    
    /*
	|--------------------------------------------------------------------------
	| Post event create job
	|--------------------------------------------------------------------------
	*/
    
    public function postCreate()
    {
        $rules = array(
            'title' => 'required|unique:jobs,title'
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
            $job = new Job;
            foreach ($values as $key => $value)
            {
                $job->{$key} = $value;
            }
            $job->save();
            
            Session::flash('add_job_success', 1);
        }
        
        return Redirect::to('admin/employeesetting/job');
    }
    
    /*
	|--------------------------------------------------------------------------
	| Post event edit job
	|--------------------------------------------------------------------------
	*/
    
    public function postEdit()
    {
        $rules = array(
            'title' => 'required|unique:jobs,title,'.Input::get('id')
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails())
        {
            Session::put('error_messages', $validator->messages());
            Session::put('input_values', Input::all());
            Session::flash('edit_job_failed', 1);
        }
        else
        {
            $values = Input::all();
            $job = Job::find(Input::get('id'));
            foreach ($values as $key => $value)
            {
                $job->{$key} = $value;
            }
            $job->save();
            
            Session::flash('edit_job_success', 1);  
        }
        
        return Redirect::to('admin/employeesetting/job');
    }
    
    /*
	|--------------------------------------------------------------------------
	| Get event delete job title
	|--------------------------------------------------------------------------
	*/
    
    public function getDelete($id)
    {
        $user = Job::find($id);
        if ($user == NULL)
        {
            Session::flash('not_found', 1);
        }
        else
        {            
            Job::destroy($id);
            Session::flash('delete_job_success', 1);
        }
        
        return Redirect::to('admin/employeesetting/job');
    }
    
    /*
	|--------------------------------------------------------------------------
	| Get list job title
	|--------------------------------------------------------------------------
	*/
    
    public function getIndex()
    {
        $data = array(
            'open_create_modal' => 0,
            'open_edit_modal' => 0,
            'edit_success' => 0,
            'delete_success' => 0,
            'jobs' => Job::orderBy('title', 'ASC')->get()
        );
        
        if (Session::has('error_messages'))
        {
            if (Session::has('edit_job_failed'))
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
        
        return View::make('admin.job.index', $data);
    }
    
}