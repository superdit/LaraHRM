<?php

namespace admin;

use BaseController;
use View;
use Validator;
use Input;
use Session;
use Redirect;
use Kpi;
use Kra;
use Job;
use EmployeeKpi;

class PerformanceController extends BaseController {
    
    /*
	|--------------------------------------------------------------------------
	| Post event create kpi
	|--------------------------------------------------------------------------
	*/
    
    public function postCreateKpi()
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
            Session::flash('add_kpi_failed', 1);
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
        
        return Redirect::to('admin/employeesetting/performance');
    }
    
    /*
	|--------------------------------------------------------------------------
	| Post event edit kpi
	|--------------------------------------------------------------------------
	*/
    
    public function postEditKpi()
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
        
        return Redirect::to('admin/employeesetting/performance');
    }
    
    /*
	|--------------------------------------------------------------------------
	| Get event delete kpi
	|--------------------------------------------------------------------------
	*/
    
    public function getDeleteKpi($id)
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
        
        return Redirect::to('admin/employeesetting/performance');
    }
    
    /* ---------------------------------------------------------------------- */
    /* KRA------------------------------------------------------------------- */
    /* ---------------------------------------------------------------------- */
    
    /*
	|--------------------------------------------------------------------------
	| Post event create kpi
	|--------------------------------------------------------------------------
	*/
    
    public function postCreateKra()
    {
        $rules = array(
            'name' => 'required|unique:kra,name'
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails())
        {
            Session::put('error_messages', $validator->messages());
            Session::put('input_values', Input::all());
            Session::flash('add_kra_failed', 1);
        }
        else
        {
            $values = Input::all();
            $kra = new Kra;
            foreach ($values as $key => $value)
            {
                $kra->{$key} = $value;
            }
            $kra->save();
            
            Session::flash('add_kra_success', 1);
        }
        
        Session::flash('tab_kra', 1);
        
        return Redirect::to('admin/employeesetting/performance');
    }
    
    /*
	|--------------------------------------------------------------------------
	| Post event edit kra
	|--------------------------------------------------------------------------
	*/
    
    public function postEditKra()
    {
        $rules = array(
            'name' => 'required|unique:kra,name,'.Input::get('id')
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails())
        {
            Session::put('error_messages', $validator->messages());
            Session::put('input_values', Input::all());
            Session::flash('edit_kra_failed', 1);
        }
        else
        {
            $values = Input::all();
            $kra = Kra::find(Input::get('id'));
            foreach ($values as $key => $value)
            {
                $kra->{$key} = $value;
            }
            $kra->save();
            
            Session::flash('edit_kra_success', 1);  
        }
        
        Session::flash('tab_kra', 1);
        
        return Redirect::to('admin/employeesetting/performance');
    }
    
    /*
	|--------------------------------------------------------------------------
	| Get event delete kra
	|--------------------------------------------------------------------------
	*/
    
    public function getDeleteKra($id)
    {
        $kra = Kra::find($id);
        if ($kra == NULL)
        {
            Session::flash('not_found', 1);
        }
        else
        {            
            Kra::destroy($id);
            Session::flash('delete_kra_success', 1);
        }
        
        Session::flash('tab_kra', 1);
        
        return Redirect::to('admin/employeesetting/performance');
    }
    
    /*
	|--------------------------------------------------------------------------
	| Kpi & Kra list index
	|--------------------------------------------------------------------------
	*/
    
    public function getIndex()
    {        
        $data = array(
            'kpi' => Kpi::all(),
            'kpi_distinct' => Kpi::distinct()->lists('job_id'),
            'kra' => Kra::orderBy('name', 'ASC')->get(),
            'jobs' => Job::orderBy('title', 'ASC')->get()
        );
        
        if (Session::has('error_messages'))
        {
            $data['error_messages'] = Session::get('error_messages');
            $data['input_values'] = Session::get('input_values');
            Session::forget('error_messages');
            Session::forget('input_values');
        }
        
        return View::make('admin.performance.index', $data);
    }
    
    /*
	|--------------------------------------------------------------------------
	| Kpi list based on kra & job
	|--------------------------------------------------------------------------
	*/
    
    public function getFilterKpi($kra_id, $job_id)
    {
        if ($kra_id != 0 && $job_id != 0)
        {
            $kpi = Kpi::where('kra_id', '=', $kra_id)->where('job_id', '=', $job_id, 'AND')->get();
        } 
        else if ($kra_id == 0 && $job_id != 0)
        {
            $kpi = Kpi::where('job_id', '=', $job_id)->get();
        }
        else if ($kra_id != 0 && $job_id == 0)
        {
            $kpi = Kpi::where('kra_id', '=', $kra_id)->get();
        }
        
        $data = array(
            'kpi' => $kpi,
            'kra' => Kra::orderBy('name', 'ASC')->get(),
            'kpi_distinct' => Kpi::distinct()->lists('job_id'),
            'jobs' => Job::orderBy('title', 'ASC')->get(),
            'kra_id' => $kra_id,
            'job_id' => $job_id,
            'selected_job' => Job::find($job_id)
        );
        
        return View::make('admin.performance.index', $data);
    }
    
    /*
	|--------------------------------------------------------------------------
	| add kpi group
	|--------------------------------------------------------------------------
	*/
    
    public function postAddKpiGroup()
    {
        $values = Input::all();
        
        $total_weight = 0;
        $is_blank = FALSE;
        $is_numeric = TRUE;
        foreach ($values['default_weight'] as $index => $weight)
        {
            if ($values['name'][$index] == "" || 
                    $values['default_weight'][$index] == "" ||
                    $values['default_target'][$index] == "") {
                $is_blank = TRUE;
            }
            
            if (!is_numeric($values['default_weight'][$index]) || 
                    !is_numeric($values['default_target'][$index])) {
                $is_numeric = FALSE;
            }
            
            $total_weight += $weight;
        }
        
        if ($total_weight == 100 && $is_numeric && !$is_blank)
        {
            foreach ($values['default_weight'] as $index => $weight)
            {
                $kpi = new Kpi;
                $kpi->name = $values['name'][$index];
                $kpi->job_id = $values['job_id'];
                $kpi->kra_id = $values['kra_id'][$index];
                $kpi->default_weight = $values['default_weight'][$index];
                $kpi->default_target = $values['default_target'][$index];
                $kpi->save();
            }
            Session::flash('add_kpigroup_success', 1);  
        }
        else
        {
            Session::put('input_values', $values);
            Session::put('error_messages', 1);
            Session::flash('add_kpigroup_failed', 1); 
        }
        
        return Redirect::to('admin/employeesetting/performance');
    }
    
    /*
	|--------------------------------------------------------------------------
	| edit kpi based on job id
	|--------------------------------------------------------------------------
	*/
    
    public function getEditKpiGroup($job_id)
    {
        $data = array(
            'kpi' => Kpi::all(),
            'kpi_distinct' => Kpi::distinct()->lists('job_id'),
            'job_kpis' => Kpi::where('job_id', '=', $job_id)->get(),
            'selected_job' => Job::find($job_id),
            'kra' => Kra::orderBy('name', 'ASC')->get(),
            'jobs' => Job::orderBy('title', 'ASC')->get(),
            'view_edit' => TRUE
        );
        
        if (Session::has('error_messages'))
        {
            $data['error_messages'] = Session::get('error_messages');
            $data['input_values'] = Session::get('input_values');
            Session::forget('error_messages');
            Session::forget('input_values');
        }
        
        return View::make('admin.performance.index', $data);
    }
    
    /*
	|--------------------------------------------------------------------------
	| post edit kpi based on job id
	|--------------------------------------------------------------------------
	*/
    
    public function postEditKpiGroup()
    {
        $values = Input::all();
        
        $total_weight = 0;
        $is_blank = TRUE;
        $is_numeric = TRUE;
        
        foreach ($values['default_weight'] as $index => $weight)
        {
            if ($values['name'][$index] == "" || 
                    $values['default_weight'][$index] == "" ||
                    $values['default_target'][$index] == "") {
                $is_blank = FALSE;
            }
            
            if (!is_numeric($values['default_weight'][$index]) || 
                    !is_numeric($values['default_target'][$index])) {
                $is_numeric = FALSE;
            }
            
            $total_weight += $weight;
        }
        
        // Get existing kpi
        $existing_kpi = Kpi::where('job_id', '=', $values['job_id'])->lists('id');
        foreach ($existing_kpi as $kpi_id)
        {
            if (!in_array($kpi_id, $values['id']))
            {
                Kpi::destroy($kpi_id);
            }
        }
        
        if ($total_weight == 100 && $is_numeric && $is_blank)
        {
            foreach ($values['default_weight'] as $index => $weight)
            {
                if ($values['id'][$index] == '')
                {
                    $kpi = new Kpi;
                }
                else
                {
                    $kpi = Kpi::find($values['id'][$index]);   
                }
                
                $kpi->name = $values['name'][$index];
                $kpi->job_id = $values['job_id'];
                $kpi->kra_id = $values['kra_id'][$index];
                $kpi->default_weight = $values['default_weight'][$index];
                $kpi->default_target = $values['default_target'][$index];
                $kpi->save();
            }
            
            Session::flash('edit_kpigroup_success', 1);  
            return Redirect::to('admin/employeesetting/filter-kpi/0/'.$values['job_id']);
        }
        else
        {
            Session::put('input_values', $values);
            Session::put('error_messages', 1);
            Session::flash('edit_kpigroup_failed', 1); 
            return Redirect::to('admin/employeesetting/edit-kpi-group/'.$values['job_id']);
        }
    }
    
    /*
	|--------------------------------------------------------------------------
	| delete all kpi based on job id
	|--------------------------------------------------------------------------
	*/
    
    public function getDeleteKpiGroup($job_id)
    {
        Kpi::where('job_id', '=', $job_id)->delete();
        Session::flash('delete_kpigroup_success', 1); 
        return Redirect::to('admin/employeesetting/performance');
    }
    
    
    
    /*
	|--------------------------------------------------------------------------
	| add kpi to employee
	|--------------------------------------------------------------------------
	*/
    
    public function postAddKpiToEmployee()
    {
        $values = Input::all();
        $empkpi = new EmployeeKpi;
        foreach ($values as $key => $value)
        {
            $empkpi->{$key} = $value;
        }
        $empkpi->save();

        Session::flash('add_empkpi_success', 1);  
        
        return Redirect::to('admin/employee/performance/'.Input::get('employee_id'));
    }
    
    /*
	|--------------------------------------------------------------------------
	| delete kpi from employee
	|--------------------------------------------------------------------------
	*/
    
    public function getDeleteKpiFromEmployee($id, $employee_id)
    {
//        $values = Input::all();
//        $empkpi = new EmployeeKpi;
//        foreach ($values as $key => $value)
//        {
//            $empkpi->{$key} = $value;
//        }
//        $empkpi->save();
//
//        Session::flash('add_empkpi_success', 1);  
//        
//        return Redirect::to('admin/employee/performance/'.Input::get('employee_id'));
    }
    
    
    /*
	|--------------------------------------------------------------------------
	| write kpi review to employee
	|--------------------------------------------------------------------------
	*/
    
    public function postWriteKpiReview()
    {
        $values = Input::all();
        var_dump($values); exit;
//        $empkpi = new EmployeeKpi;
//        foreach ($values as $key => $value)
//        {
//            $empkpi->{$key} = $value;
//        }
//        $empkpi->save();
//
//        Session::flash('add_empkpi_success', 1);  
        
        return Redirect::to('admin/employee/performance/'.Input::get('employee_id'));
    }
    
}