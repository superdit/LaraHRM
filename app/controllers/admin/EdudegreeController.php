<?php

namespace admin;

use BaseController;
use View;
use Validator;
use Input;
use Session;
use Redirect;
use EducationDegree;

class EdudegreeController extends BaseController {
    
     /*
	|--------------------------------------------------------------------------
	| Post event create education degree
	|--------------------------------------------------------------------------
	*/
    
    public function postCreate()
    {
        $rules = array(
            'name' => 'required|unique:education_degree,name'
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails())
        {
            Session::put('error_messages', $validator->messages());
            Session::put('input_values', Input::all());
            Session::flash('add_edudegree_failed', 1);
        }
        else
        {
            $values = Input::all();
            $eduDegree = new EducationDegree;
            foreach ($values as $key => $value)
            {
                $eduDegree->{$key} = $value;
            }
            $eduDegree->save();
            
            Session::flash('add_edudegree_success', 1);
        }
        
        return Redirect::to('admin/employeesetting/edudegree');
    }
    
    /*
	|--------------------------------------------------------------------------
	| Post event edit job
	|--------------------------------------------------------------------------
	*/
    
    public function postEdit()
    {
        $rules = array(
            'name' => 'required|unique:education_degree,name,'.Input::get('id')
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails())
        {
            Session::put('error_messages', $validator->messages());
            Session::put('input_values', Input::all());
            Session::flash('edit_edudegree_failed', 1);
        }
        else
        {            
            $values = Input::all();
            $eduDegree = EducationDegree::find(Input::get('id'));
            foreach ($values as $key => $value)
            {
                $eduDegree->{$key} = $value;
            }
            $eduDegree->save();
            
            Session::flash('edit_edudegree_success', 1);  
        }
        
        return Redirect::to('admin/employeesetting/edudegree');
    }
    
    /*
	|--------------------------------------------------------------------------
	| Get event delete education degree
	|--------------------------------------------------------------------------
	*/
    
    public function getDelete($id)
    {
        $eduDegree = EducationDegree::find($id);
        if ($eduDegree == NULL)
        {
            Session::flash('not_found', 1);
        }
        else
        {            
            $eduDegree::destroy($id);
            Session::flash('delete_edudegree_success', 1);
        }
        
        return Redirect::to('admin/employeesetting/edudegree');
    }
    
    /*
	|--------------------------------------------------------------------------
	| Get list education degree
	|--------------------------------------------------------------------------
	*/
    
    public function getIndex()
    {
        $data = array(
            'eduDegree' => EducationDegree::orderBy('name', 'ASC')->get()
        );
        
        if (Session::has('error_messages'))
        {
            $data['error_messages'] = Session::get('error_messages');
            $data['input_values'] = Session::get('input_values');
            Session::forget('error_messages');
            Session::forget('input_values');
        }
        
        return View::make('admin.edudegree.index', $data);
    }
}
    