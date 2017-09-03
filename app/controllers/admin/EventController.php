<?php

namespace admin;

use BaseController;
use View;
use Validator;
use Input;
use Session;
use Redirect;
use Events;

class EventController extends BaseController {
    
    private $per_page = 10;
    
    public function getIndex()
    {
        $data = array();
        
        if (Session::has('error_messages'))
        {
            $data['error_messages'] = Session::get('error_messages');
            $data['input_values'] = Session::get('input_values');
            Session::forget('error_messages');
            Session::forget('input_values');
        }
        
        return View::make('admin.event.index', $data);
    }
    
    public function getList()
    {        
        $page = intval(filter_input(INPUT_GET, 'page'));
        $page = (($page === 1 || is_null($page)) ? 0 : $page); 
        $page = ($page - 1) * $this->per_page; 
        
        $data = array(
            'events' => Events::orderBy('start', 'asc')->take($this->per_page)->skip($page)->get(),
            'paginate' => Events::paginate($this->per_page)
        );
        
        return View::make('admin.event.list', $data);
    }
    
    public function getEventThisMonth()
    {
        return Events::get()->toJson();
    }
    
    public function postCreate()
    {
        $rules = array(
            'title' => 'required',
            'start' => 'required'
            //'end' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails())
        {
            Session::put('error_messages', $validator->messages());
            Session::put('input_values', Input::all());
            Session::flash('add_event_failed', 1);
        }
        else
        {
            $values = Input::all();
            $event = new Events();
            foreach ($values as $key => $value)
            {
                if ($key == "all_day") 
                {
                    $event->{$key} = 1;
                }
                else
                {
                    $event->{$key} = $value;
                }
            }
            $event->save();
            
            Session::flash('add_event_success', 1);
        }
        
        return Redirect::to('admin/event');
    }
    
    public function postEdit()
    {        
        $rules = array(
            'title' => 'required',
            'start' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails())
        {
            Session::put('error_messages', $validator->messages());
            Session::put('input_values', Input::all());
            Session::flash('edit_event_failed', 1);
        }
        else
        {
            $values = Input::all();
            $event = Events::find(Input::get('id'));
            foreach ($values as $key => $value)
            {
                $event->{$key} = $value;
            }
            $event->save();
            
            Session::flash('edit_event_success', 1);  
        }
        
        return Redirect::to('admin/event');
    }
    
    public function getDelete($id)
    {
        $event = Events::find($id);
        if ($event == NULL)
        {
            Session::flash('not_found', 1);
        }
        else
        {            
            Events::destroy($id);
            Session::flash('delete_event_success', 1);
        }
        
        return Redirect::to('admin/event');
    }
}
    