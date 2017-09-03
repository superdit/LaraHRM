<?php

namespace admin;

use BaseController;
use View;
use Validator;
use Input;
use Session;
use Redirect;
use Workshift;

class WorkshiftController extends BaseController {
    
    private $per_page = 10;
    
    /*
	|--------------------------------------------------------------------------
	| View all available work shift
	|--------------------------------------------------------------------------
	*/

    public function getIndex()
    {        
        $page = intval(filter_input(INPUT_GET, 'page'));
        $page = (($page === 1 || is_null($page)) ? 0 : $page); 
        $page = ($page - 1) * $this->per_page; 
        
        $data = array(
            'open_create_modal' => 0,
            'open_edit_modal' => 0,
            'add_success' => 0,
            'edit_success' => 0,
            'delete_success' => 0,
            'workshift' => Workshift::orderBy('id', 'asc')->take($this->per_page)->skip($page)->get(),
            'paginate' => Workshift::paginate($this->per_page)
        );
        
        if (Session::has('error_messages'))
        {            
            if (Session::has('edit_failed'))
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
        else if (Session::has('add_success'))
        {
            $data['add_success'] = 1;
        }
        else if (Session::has('edit_success'))
        {
            $data['edit_success'] = 1;
        }
        
        if (Session::has('delete_success'))
        {
            $data['delete_success'] = 1;
        }
        
        return View::make('admin.workshift.index', $data);
    }
    
    /*
	|--------------------------------------------------------------------------
	| Post event create work shift
	|--------------------------------------------------------------------------
	*/
    
    public function postCreate()
    {        
        $rules = array(
            'name' => 'required|unique:work_shifts,name',            
            'start_work_time' => 'required|date_format:"H:i"',
            'end_work_time' => 'required|date_format:"H:i"'
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
            $workshift = new Workshift;
            foreach ($values as $key => $value)
            {
                if ($key === "days") 
                {
                    $value = implode($value, ",");
                }
                $workshift->{$key} = $value;
            }
            $workshift->save();
            
            Session::flash('add_success', 1);
        }
        
        return Redirect::to('admin/employeesetting/workshift');
    }
    
    /*
	|--------------------------------------------------------------------------
	| Post event edit work shift
	|--------------------------------------------------------------------------
	*/
    
    public function postEdit()
    {
        $rules = array(
            'name' => 'required|unique:work_shifts,name,'.Input::get('id'),
            'start_work_time' => 'required|date_format:"H:i"',
            'end_work_time' => 'required|date_format:"H:i"'
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails())
        {
            Session::put('error_messages', $validator->messages());
            Session::put('input_values', Input::all());
            Session::flash('edit_failed', 1);
        }
        else
        {
            $values = Input::all();
            $workshift = Workshift::find(Input::get('id'));
            
            foreach ($values as $key => $value)
            {
                if ($key === "days") 
                {
                    $value = implode($value, ",");
                }
                $workshift->{$key} = $value;
            }
            $workshift->save();
            
            Session::flash('edit_success', 1);
        }
        
        return Redirect::to('admin/employeesetting/workshift');
    }
    
    /*
	|--------------------------------------------------------------------------
	| Get event delete work shift
	|--------------------------------------------------------------------------
	*/
    
    public function getDelete($id)
    {
        $workshift = Workshift::find($id);
        if ($workshift == NULL)
        {
            Session::flash('not_found', 1);
        }
        else
        {            
            Workshift::destroy($id);
            Session::flash('delete_success', 1);
        }
        
        return Redirect::to('admin/employeesetting/workshift');
    }
}