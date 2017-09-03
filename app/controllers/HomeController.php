<?php

class HomeController extends BaseController {

	public function getIndex()
    {
        return View::make('home.checkin');
    }
    
    public function postAjaxCheckIn()
    {
        $employee = Employee::where('id_number', '=', $_POST['id_number'])->first();
        
        if (!is_null($employee)) 
        {
            $work_date = date('Y-m-d');
            $attendance = EmployeeAttendace::where('employee_id', '=', $employee->id)
                            ->where('work_date', '=', $work_date)->first();
            
            if (is_null($attendance))
            {
                // put image 
                $upload_dir = 'uploads/employee/attendance/check_in/';
                $img = str_replace('data:image/png;base64,', '', $_POST['img']);
                $img = str_replace(' ', '+', $img);
                $data = base64_decode($img);

                $filename = $employee->id . '_' . $employee->id_number . '_' . date('YmdHis') . '.jpg';

                file_put_contents($upload_dir . $filename, $data);

                // checkin employee attendance
                $employeeAttendace = new EmployeeAttendace;
                $employeeAttendace->employee_id = $employee->id;
                $employeeAttendace->work_date = $work_date;
                $employeeAttendace->check_in_time = date('H:i:s');
                $employeeAttendace->save();
                
                // employee check in
                echo 1;
            }
            else 
            {
                // employee already check in
                echo 2;
            }
        }
        else
        {
            // employee not found
            echo 0;
        }
    }
    
    public function postAjaxCheckOut()
    {
        $employee = Employee::where('id_number', '=', $_POST['id_number'])->first();
        
        if (!is_null($employee)) 
        {
            $work_date = date('Y-m-d');
            $attendance = EmployeeAttendace::where('employee_id', '=', $employee->id)
                            ->where('work_date', '=', $work_date)->first();
            
            if (is_null($attendance))
            {
                // put image 
                $upload_dir = 'uploads/employee/attendance/check_out/';
                $img = str_replace('data:image/png;base64,', '', $_POST['img']);
                $img = str_replace(' ', '+', $img);
                $data = base64_decode($img);

                $filename = $employee->id . '_' . $employee->id_number . '_' . date('YmdHis') . '.jpg';

                file_put_contents($upload_dir . $filename, $data);

                // checkout employee attendance
                $employeeAttendace = new EmployeeAttendace;
                $employeeAttendace->employee_id = $employee->id;
                $employeeAttendace->work_date = $work_date;
                $employeeAttendace->check_out_time = date('H:i:s');
                $employeeAttendace->save();
                
                // employee check out created
                echo 1;
            }
            else 
            {
                if ($attendance->check_out_time === NULL)
                {
                    // put image 
                    $upload_dir = 'uploads/employee/attendance/check_out/';
                    $img = str_replace('data:image/png;base64,', '', $_POST['img']);
                    $img = str_replace(' ', '+', $img);
                    $data = base64_decode($img);

                    $filename = $employee->id . '_' . $employee->id_number . '_' . date('YmdHis') . '.jpg';

                    file_put_contents($upload_dir . $filename, $data);
                    
                    $attendance->check_out_time = date('H:i:s');
                    $attendance->save();
                    
                    // employee check out update
                    echo 1;
                }
                else
                {
                    // employee already check out
                    echo 2;
                }
            }
        }
        else
        {
            // employee not found
            echo 0;
        }
    }
}