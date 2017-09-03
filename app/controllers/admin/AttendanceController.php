<?php

namespace admin;

use BaseController;
use Validator;
use Input;
use Session;
use Redirect;
use EmployeeAttendace;
use EmployeeLeave;


class AttendanceController extends BaseController {
    
    /*
	|--------------------------------------------------------------------------
	| Post event add attendance, redirect to admin/employee/attendance
	|--------------------------------------------------------------------------
	*/
    
    public function postAdd()
    {        
        $rules = array(
            'work_date' => 'required|date_format:"Y-m-d"',         
            'check_in_time' => 'required|date_format:"H:i"',
            'check_out_time' => 'required|date_format:"H:i"'
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails())
        {
            Session::put('error_messages', $validator->messages());
            Session::put('input_values', Input::all());
            Session::flash('add_att_failed', 1);
        }
        else
        {
            $values = Input::all();
            $attendance = new EmployeeAttendace;
            foreach ($values as $key => $value)
            {
                $attendance->{$key} = $value;
            }
            $attendance->save();
            
            Session::flash('add_att_success', 1);
        }
        
        return Redirect::to('admin/employee/attendance/' . Input::get('employee_id'));
    }
    
    /*
	|--------------------------------------------------------------------------
	| Post event edit attendance, redirect to admin/employee/attendance
	|--------------------------------------------------------------------------
	*/
    
    public function postEdit()
    {        
        $rules = array(
            'work_date' => 'required|date_format:"Y-m-d"',         
            'check_in_time' => 'required|date_format:"H:i"',
            'check_out_time' => 'required|date_format:"H:i"'
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails())
        {
            Session::put('error_messages', $validator->messages());
            Session::put('input_values', Input::all());
            Session::flash('edit_att_failed', 1);
        }
        else
        {
            $values = Input::all();
            $attendance = EmployeeAttendace::find(Input::get('id'));
            foreach ($values as $key => $value)
            {
                $attendance->{$key} = $value;
            }
            $attendance->save();
            
            Session::flash('edit_att_success', 1);   
        }
        
        return Redirect::to('admin/employee/attendance/' . Input::get('employee_id'));
    }
    
    /*
	|--------------------------------------------------------------------------
	| Get event delete attendance, redirect to admin/employee/attendance
	|--------------------------------------------------------------------------
	*/
    
    public function getDelete($id)
    {
        $attendance = EmployeeAttendace::find($id);
        
        if (!is_null($attendance->check_in_time))
        {
            $check_in_img = 'uploads/employee/attendance/check_in/' . $attendance->employee_id . "_" . $attendance->employee->id_number . "_" . str_replace("-", "", $attendance->work_date) . str_replace(":", "", $attendance->check_in_time) . ".jpg"; 
            @unlink($check_in_img);
        }
        
        if (!is_null($attendance->check_out_time))
        {
            $check_out_img = 'uploads/employee/attendance/check_out/' . $attendance->employee_id . "_" . $attendance->employee->id_number . "_" . str_replace("-", "", $attendance->work_date) . str_replace(":", "", $attendance->check_out_time) . ".jpg"; 
            @unlink($check_out_img);
        }
        
        EmployeeAttendace::destroy($id);
        
        Session::flash('delete_att_success', 1);
        
        return Redirect::to('admin/employee/attendance/' . $attendance->employee_id);
    }
    
    /*
	|--------------------------------------------------------------------------
	| Post event add leave permission, redirect to admin/employee/leave
	|--------------------------------------------------------------------------
	*/
    
    public function postAddLeave()
    {        
        $rules = array(
            'from_date' => 'required|date_format:"Y-m-d"',
            'to_date' => 'required|date_format:"Y-m-d"'
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails())
        {
            Session::put('error_messages', $validator->messages());
            Session::put('input_values', Input::all());
            Session::flash('add_leave_failed', 1);
        }
        else
        {
            $values = Input::all();
            $leave = new EmployeeLeave;
            foreach ($values as $key => $value)
            {
                $leave->{$key} = $value;
            }
            $leave->save();
            
            Session::flash('add_leave_success', 1);
        }
        
        return Redirect::to('admin/employee/leave/' . Input::get('employee_id'));
    }
    
    /*
	|--------------------------------------------------------------------------
	| Post event edit leave permission, redirect to admin/employee/leave
	|--------------------------------------------------------------------------
	*/
    
    public function postEditLeave()
    {        
        $rules = array(
            'from_date' => 'required|date_format:"Y-m-d"',
            'to_date' => 'required|date_format:"Y-m-d"'
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails())
        {
            Session::put('error_messages', $validator->messages());
            Session::put('input_values', Input::all());
            Session::flash('add_leave_failed', 1);
        }
        else
        {
            $values = Input::all();
            $leave = EmployeeLeave::find(Input::get('id'));
            foreach ($values as $key => $value)
            {
                $leave->{$key} = $value;
            }
            $leave->save();
            
            Session::flash('edit_leave_success', 1);
        }
        
        return Redirect::to('admin/employee/leave/' . Input::get('employee_id'));
    }
    
    /*
	|--------------------------------------------------------------------------
	| Get event delete leave, redirect to admin/employee/leave
	|--------------------------------------------------------------------------
	*/
    
    public function getDeleteLeave($employee_id, $id)
    {
        EmployeeLeave::destroy($id);
        
        Session::flash('delete_leave_success', 1);
        
        return Redirect::to('admin/employee/leave/' . $employee_id);
    }
}