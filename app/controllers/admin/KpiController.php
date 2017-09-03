<?php

namespace admin;

use BaseController;
use View;
use Validator;
use Input;
use Session;
use Redirect;
use Kpi;
use Job;

class KpiController extends BaseController {
    
    /*
	|--------------------------------------------------------------------------
	| Post event create kpi
	|--------------------------------------------------------------------------
	*/
    
    public function postCreate()
    {
        $rules = array(
            'name' => 'required',
            'minimum_rating' => 'required|numeric',
            'maximum_rating' => 'required|numeric'
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
            $kpi = new Kpi;
            foreach ($values as $key => $value)
            {
                $kpi->{$key} = $value;
            }
            $kpi->save();
            
            Session::flash('add_kpi_success', 1);
        }
        
        return Redirect::to('admin/kpi');
    }
    
    /*
	|--------------------------------------------------------------------------
	| Post event edit kpi
	|--------------------------------------------------------------------------
	*/
    
    public function postEdit()
    {
        $rules = array(
            'name' => 'required',
            'minimum_rating' => 'required|numeric',
            'maximum_rating' => 'required|numeric'
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails())
        {
            Session::put('error_messages', $validator->messages());
            Session::put('input_values', Input::all());
            Session::flash('edit_kpi_failed', 1);
        }
        else
        {
            $values = Input::all();
            $kpi = Kpi::find(Input::get('id'));
            foreach ($values as $key => $value)
            {
                $kpi->{$key} = $value;
            }
            $kpi->save();
            
            Session::flash('edit_kpi_success', 1);  
        }
        
        return Redirect::to('admin/kpi');
    }
    
    /*
	|--------------------------------------------------------------------------
	| Get event delete kpi
	|--------------------------------------------------------------------------
	*/
    
    public function getDelete($id)
    {
        $kpi = Kpi::find($id);
        if ($kpi == NULL)
        {
            Session::flash('not_found', 1);
        }
        else
        {            
            Kpi::destroy($id);
            Session::flash('delete_kpi_success', 1);
        }
        
        return Redirect::to('admin/kpi');
    }
    
    /*
	|--------------------------------------------------------------------------
	| Kpi list index
	|--------------------------------------------------------------------------
	*/
    
    public function getIndex()
    {        
        $data = array(
            'open_create_modal' => 0,
            'open_edit_modal' => 0,
            'add_kpi_success' => 0,
            'edit_success' => 0,
            'delete_success' => 0,
            'kpi' => Kpi::all(),
            'jobs' => Job::orderBy('title', 'ASC')->get()
        );
        
        if (Session::has('error_messages'))
        {
            if (Session::has('edit_kpi_failed'))
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
        
        return View::make('admin.kpi.index', $data);
    }
    
    
    
}