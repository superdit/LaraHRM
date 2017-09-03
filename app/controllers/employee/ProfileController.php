<?php

namespace employee;

use View;
use BaseController;
use Auth;
use Session;
use Employee;
use EmployeeContact;
use EmployeeAttendace;
use EmployeeLeave;
use EducationDegree;
use EmployeeKpiResult;
use Validator;
use Input;
use Redirect;
use SalaryComponent;
use SalaryDeduction;
use Kpi;
use Kra;
use Job;
use Workshift;
use Nation;
use EmployeeType;

class ProfileController extends BaseController {
    
    private $employee_id;
    private $attendance_per_page = 10;
    
    /*
	|--------------------------------------------------------------------------
	| Profile constructor
	|--------------------------------------------------------------------------
	*/
    
    public function __construct() 
    {
        $this->employee_id = Auth::user()->employee_id;
    }
    
    /*
	|--------------------------------------------------------------------------
	| View my profile
	|--------------------------------------------------------------------------
	*/
    
    public function getIndex()
    {
        $employee = Employee::find($this->employee_id);
        
        $data = array(
            'employee' => $employee,
            'kpi' => Kpi::where('job_id', '=', $employee->job_id)->get()
        );  
        
        return View::make('employee.profile.index', $data);
    }
    
    /*
	|--------------------------------------------------------------------------
	| Edit my profile
	|--------------------------------------------------------------------------
	*/
    
    public function getEdit()
    {
        $employee = Employee::find($this->employee_id);
        
        if ($employee == NULL)
        {
            Session::flash('not_found', 1);
            return Redirect::to('admin/employee');
        }
        else
        {
            $data = array(
                'employee' => $employee,
                'workshifts' => Workshift::all(),
                'nations' => Nation::all(),
                'emptypes' => EmployeeType::orderBy('name', 'asc')->get(),
                'jobs' => Job::orderBy('title', 'asc')->get()
            );
            return View::make('employee.profile.edit', $data);
        }
    }
    
    /*
	|--------------------------------------------------------------------------
	| Post event my profile
	|--------------------------------------------------------------------------
	*/
    
    public function postEdit()
    {
        $rules = array(
            'id_number' => 'required|unique:employee,id_number,'.Input::get('id'),
            'name' => 'required',            
            'address' => 'required',
            'email' => 'required|email|unique:employee,email,'.Input::get('id'),
            'birthdate' => 'required|date_format:"Y-m-d"',
            'phone' => 'numeric'
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
            $employee = Employee::find(Input::get('id'));
            
            if (Input::hasFile('photo'))
            {
                if ($employee->photo != "")
                {
                    @unlink($this->photo_folder . $employee->photo);
                }
                
                $photo_name = str_replace(" ", "_", Input::get('id_number')."_".Input::get('name').".".Input::file('photo')->getClientOriginalExtension());
                Input::file('photo')->move($this->photo_folder, $photo_name);
                Image::make($this->photo_folder.$photo_name)
                        ->resize(200, 256)
                        ->save($this->photo_folder . $photo_name);
                $values['photo'] = $photo_name;
            }
            else
            {
                $values['photo'] = $employee->photo;
            }
            
            foreach ($values as $key => $value)
            {
                $employee->{$key} = $value;
            }
            $employee->save();
            
            Session::flash('edit_success', 1);
        }
        
        return Redirect::to('employee/profile');
    }
    
    // <editor-fold defaultstate="collapsed" desc="TAB PROFILE">
    
    /*
	|--------------------------------------------------------------------------
	| View contact
	|--------------------------------------------------------------------------
	*/
    public function getContact()
    {
        $employee = Employee::find($this->employee_id);
        
        if ($employee == NULL)
        {
            Session::flash('not_found', 1);
            return Redirect::to('admin/employee');
        }
        else
        {
            $data = array(
                'employee' => $employee
            );
            
            if (Session::has('error_messages'))
            {
                $data['error_messages'] = Session::get('error_messages');
                $data['input_values'] = Session::get('input_values');
                Session::forget('error_messages');
                Session::forget('input_values');
            }
            
            return View::make('employee.profile.contact', $data);
        }
    }
    
    /*
	|--------------------------------------------------------------------------
	| Post event add employee contact
	|--------------------------------------------------------------------------
	*/
    
    public function postAddContact()
    {        
        $rules = array(
            'contact_name' => 'required',
            'relationship' => 'required',
//            'home_phone' => 'required',
//            'work_phone' => 'required',
//            'mobile_phone' => 'required',
            'email' => 'email'
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails())
        {
            Session::put('error_messages', $validator->messages());
            Session::put('input_values', Input::all());
            Session::flash('add_contact_failed', 1);
        }
        else
        {
            $values = Input::all();
            $contact = new EmployeeContact;
            $contact->employee_id = $this->employee_id;
            foreach ($values as $key => $value)
            {
                $contact->{$key} = $value;
            }
            $contact->save();
            
            Session::flash('add_contact_success', 1);
        }
        return Redirect::to('employee/profile/contact');
    }
    
    /*
	|--------------------------------------------------------------------------
	| Post event edit employee contact
	|--------------------------------------------------------------------------
	*/
    
    public function postEditContact()
    {
        $rules = array(
            'contact_name' => 'required',
            'relationship' => 'required',
//            'home_phone' => 'required',
//            'work_phone' => 'required',
//            'mobile_phone' => 'required',
            'email' => 'email'
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails())
        {
            Session::put('error_messages', $validator->messages());
            Session::put('input_values', Input::all());
            Session::flash('edit_contact_failed', 1);
        }
        else
        {
            $values = Input::all();
            $contact = EmployeeContact::find(Input::get('id'));
            foreach ($values as $key => $value)
            {
                $contact->{$key} = $value;
            }
            $contact->save();
            
            Session::flash('edit_contact_success', 1);  
        }
        
        return Redirect::to('employee/profile/contact');
    }
    
    /*
	|--------------------------------------------------------------------------
	| Get event delete contact from employee
	|--------------------------------------------------------------------------
	*/
    
    public function getDeleteContact($id)
    {
        $contact = EmployeeContact::find($id);
        if ($contact == NULL)
        {
            Session::flash('not_found', 1);
        }
        else
        {            
            EmployeeContact::destroy($id);
            Session::flash('delete_contact_success', 1);
        }
        
        return Redirect::to('employee/profile/contact');
    }
    
    // </editor-fold>
    
    // <editor-fold defaultstate="collapsed" desc="TAB ATTENDANCE">
    
    /*
	|--------------------------------------------------------------------------
	| Get employee attendance
	|--------------------------------------------------------------------------
	*/
    
    public function getAttendance()
    {
        $page = intval(filter_input(INPUT_GET, 'page'));
        $page = (($page === 1 || is_null($page)) ? 0 : $page); 
        $page = ($page - 1) * $this->attendance_per_page; 
        
        $data = array(
            'view' => 'attendance',
            'employee' => Employee::find($this->employee_id),
            'attendance' => EmployeeAttendace::where('employee_id', '=', $this->employee_id)
                ->orderBy('work_date', 'asc')->take($this->attendance_per_page)->skip($page)->get(),
            'paginate' => EmployeeAttendace::where('employee_id', '=', $this->employee_id)->paginate($this->attendance_per_page)
        );
        
        return View::make('employee.profile.attendance', $data);
    }
    
    /*
	|--------------------------------------------------------------------------
	| Get employee leave history
	|--------------------------------------------------------------------------
	*/
    
    public function getLeave()
    {
        $page = intval(filter_input(INPUT_GET, 'page'));
        $page = (($page === 1 || is_null($page)) ? 0 : $page); 
        $page = ($page - 1) * $this->attendance_per_page; 
        
        $data = array(
            'view' => 'leave',
            'add_success' => 0,
            'add_leave_success' => 0,
            'edit_att_success' => 0,
            'open_create_modal' => 0,
            'open_create_modal_leave' => 0,
            'open_edit_modal' => 0,
            'open_edit_modal_leave' => 0,
            'delete_success' => 0,
            'employee' => Employee::find($this->employee_id),
            'leaves' => EmployeeLeave::where('employee_id', '=', $this->employee_id)
                ->orderBy('from_date', 'asc')->take($this->attendance_per_page)->skip($page)->get(),
            'paginate' => EmployeeLeave::where('employee_id', '=', $this->employee_id)->paginate($this->attendance_per_page)
        );
        
        if (Session::has('error_messages'))
        {
            if (Session::has('add_leave_failed'))
            {
                $data['open_create_modal_leave'] = 1;
            }
            else if (Session::has('edit_leave_failed'))
            {
                $data['open_edit_modal_leave'] = 1;
            }
            
            $data['error_messages'] = Session::get('error_messages');
            $data['input_values'] = Session::get('input_values');
            Session::forget('error_messages');
            Session::forget('input_values');
        }
        
        return View::make('employee.profile.attendance', $data);
    }
    
    // </editor-fold>
    
    // <editor-fold defaultstate="collapsed" desc="TAB ATTENDANCE">
    
    /*
	|--------------------------------------------------------------------------
	| Get employee qualification
	|--------------------------------------------------------------------------
	*/
    public function getQualification()
    {   
        $employee = Employee::find($this->employee_id);
        
        if ($employee == NULL)
        {
            Session::flash('not_found', 1);
            return Redirect::to('admin/employee');
        }
        else
        {
            $data = array(
                'employee' => $employee,
                'educationDegree' => EducationDegree::orderBy('name', 'ASC')->get()
            );
            
            if (Session::has('error_messages'))
            {
                $data['error_messages'] = Session::get('error_messages');
                $data['input_values'] = Session::get('input_values');
                Session::forget('error_messages');
                Session::forget('input_values');
            }
            
            return View::make('employee.profile.qualification', $data);
        }
    }
    
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="TAB SALARY">
    
    /*
	|--------------------------------------------------------------------------
	| View salary 
	|--------------------------------------------------------------------------
	*/
    public function getSalary()
    {
        $employee = Employee::find($this->employee_id);
        
        if ($employee == NULL)
        {
            Session::flash('not_found', 1);
            return Redirect::to('employee/profile');
        }
        else
        {
            $data = array(
                'employee' => $employee,
                'salaryComponents' => SalaryComponent::orderBy('name', 'ASC')->get(),
                'salaryDeductions' => SalaryDeduction::orderBy('name', 'ASC')->get()
            );
            
            return View::make('employee.profile.salary', $data);
        }
    }
    
    // </editor-fold>
    
    // <editor-fold defaultstate="collapsed" desc="TAB LOGIN">
    
    /*
	|--------------------------------------------------------------------------
	| View login credential of employee by id
	|--------------------------------------------------------------------------
	*/
    public function getLogin()
    {
        $employee = Employee::find($this->employee_id);
        
        if ($employee == NULL)
        {
            Session::flash('not_found', 1);
            return Redirect::to('employee/profile');
        }
        else
        {
            $data = array(
                'employee' => $employee
            );
            
            if (Session::has('error_messages'))
            {
                $data['error_messages'] = Session::get('error_messages');
                $data['input_values'] = Session::get('input_values');
                Session::forget('error_messages');
                Session::forget('input_values');
            }
            
            return View::make('employee.profile.login', $data);
        }
    }
    
    // </editor-fold>
    
    // <editor-fold defaultstate="collapsed" desc="TAB PERFORMANCE">
    
    /*
	|--------------------------------------------------------------------------
	| View performance
	|--------------------------------------------------------------------------
	*/
    public function getPerformance()
    {   
        $employee = Employee::find($this->employee_id);
        
        if ($employee == NULL)
        {
            Session::flash('not_found', 1);
            return Redirect::to('employee/profile');
        }
        else
        {
            $data = array(
                'employee' => $employee,
                'kpi' => Kpi::where('job_id', '=', $employee->job_id)->get(),
                'allkpi' => Kpi::orderBy('name', 'asc')->get(),
                'jobs' => Job::orderBy('title', 'asc')->get(),
                'kra' => Kra::orderBy('name', 'asc')->get()
            );
            return View::make('employee.profile.performance', $data);
        }
    }
    
    /*
	|--------------------------------------------------------------------------
	| Kpi history list
	|--------------------------------------------------------------------------
	*/
    
    public function getKpiHistory()
    {        
        $data = array(
            'kpi_results' => EmployeeKpiResult::where('employee_id', '=', $this->employee_id)
                ->groupby('review_at')->get(array('*')),
            'employee' => Employee::find($this->employee_id)
        );
        
        return View::make('employee.profile.tabs.performance.kpi-history', $data);
    }
    
    /*
	|--------------------------------------------------------------------------
	| Kpi result 
	|--------------------------------------------------------------------------
	*/
    
    public function getKpiResult($review_at)
    {
        $employee = Employee::find($this->employee_id);
        $kpi_reviews = EmployeeKpiResult::where('employee_id', '=', $this->employee_id)
                        ->where('review_at', '=', $review_at, 'AND')->get();
        
        $data = array(
            'kpi_reviews' => $kpi_reviews,
            'employee' => $employee
        );
        
        return View::make('employee.profile.tabs.performance.kpi-result', $data);
    }
    
    // </editor-fold>
}