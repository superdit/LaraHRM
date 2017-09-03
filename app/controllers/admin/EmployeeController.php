<?php

namespace admin;

use BaseController;
use View;
use Validator;
use Input;
use Employee;
use Workshift;
use Session;
use Redirect;
use Image;
use EmployeeAttendace;
use EmployeeLeave;
use EmployeeType;
use EmployeeSalaryComponent;
use EmployeeSalaryDeduction;
use EmployeeKpi;
use EmployeeKpiResult;
use SalaryComponent;
use SalaryDeduction;
use EducationDegree;
use Nation;
use Job;
use Kpi;
use Kra;
use DB;

class EmployeeController extends BaseController {
    
    private $per_page = 10;
    private $photo_folder = 'uploads/employee/default_photos/';

	/*
	|--------------------------------------------------------------------------
	| View all available employee
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
            'employee' => Employee::orderBy('id', 'asc')->take($this->per_page)->skip($page)->get(),
            'paginate' => Employee::paginate($this->per_page),
            'emptypes' => EmployeeType::orderBy('name', 'asc')->get(),
            'jobs' => Job::orderBy('title', 'asc')->get()
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
        
        return View::make('admin.employee.index', $data);
    }
     
    /*
	|--------------------------------------------------------------------------
	| Add new employee form
	|--------------------------------------------------------------------------
	*/
    
    public function getAdd()
    {
        $data = array(
            'emptypes' => EmployeeType::orderBy('name', 'asc')->get(),
            'jobs' => Job::orderBy('title', 'asc')->get(),
            'workshifts' => Workshift::all(),
            'nations' => Nation::all()
        );
        
        return View::make('admin.employee.add', $data);
    }
    
    /*
	|--------------------------------------------------------------------------
	| Post add new employee event
	|--------------------------------------------------------------------------
	*/
    
    public function postAdd()
    {
        $rules = array(
            'id_number' => 'required|unique:employee,id_number',
            'name' => 'required',            
            'address' => 'required',
            'email' => 'required|email|unique:employee,email',
            'birthdate' => 'required|date_format:"Y-m-d"',
            'phone' => 'numeric'
        );
        
        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails())
        {
            Session::put('error_messages', $validator->messages());
            Session::put('input_values', Input::all());
            
            return Redirect::to('admin/employee/add');
        }
        else
        {            
            $values = Input::all();
            
            if (Input::hasFile('photo'))
            {
                $photo_name = str_replace(" ", "_", Input::get('id_number')."_".Input::get('name').".".Input::file('photo')->getClientOriginalExtension());
                Input::file('photo')->move($this->photo_folder, $photo_name);
                Image::make($this->photo_folder.$photo_name)
                        ->resize(200, 256)
                        ->save($this->photo_folder . $photo_name);
                $values['photo'] = $photo_name;
            }
            else
            {
                $values['photo'] = "";
            }
            
            $employee = new Employee;
            foreach ($values as $key => $value)
            {
                $employee->{$key} = $value;
            }
            $employee->save();
            
            Session::flash('add_success', 1);
            
            return Redirect::to('admin/employee');
        }
    }
            
    /*
	|--------------------------------------------------------------------------
	| Post event create employee
	|--------------------------------------------------------------------------
	*/
    
    public function postCreate()
    {
        $rules = array(
            'id_number' => 'required|unique:employee,id_number',
            'name' => 'required',            
            'address' => 'required',
            'email' => 'required|email|unique:employee,email',
            'birthdate' => 'required|date_format:"Y-m-d"',
            'phone' => 'numeric'
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
            
            if (Input::hasFile('photo'))
            {
                $photo_name = str_replace(" ", "_", Input::get('id_number')."_".Input::get('name').".".Input::file('photo')->getClientOriginalExtension());
                Input::file('photo')->move($this->photo_folder, $photo_name);
                Image::make($this->photo_folder.$photo_name)
                        ->resize(200, 256)
                        ->save($this->photo_folder . $photo_name);
                $values['photo'] = $photo_name;
            }
            else
            {
                $values['photo'] = "";
            }
            
            $employee = new Employee;
            foreach ($values as $key => $value)
            {
                $employee->{$key} = $value;
            }
            $employee->save();
            
            Session::flash('add_success', 1);
        }
        
        return Redirect::to('admin/employee');
    }
    
    /*
	|--------------------------------------------------------------------------
	| Get edit employee
	|--------------------------------------------------------------------------
	*/
    
    public function getEdit($id)
    {
        $employee = Employee::find($id);
        
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
            return View::make('admin.employee.edit', $data);
        }
    }
    
    /*
	|--------------------------------------------------------------------------
	| Post event edit employee form
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
        
        return Redirect::to('admin/employee/view/'.Input::get('id'));
    }
    
    /*
	|--------------------------------------------------------------------------
	| Post event edit employee from modal box
	|--------------------------------------------------------------------------
	*/
    
    public function postEditFromModal()
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
        
        return Redirect::to('admin/employee');
    }
        
    /*
	|--------------------------------------------------------------------------
	| Delete one employee by id
	|--------------------------------------------------------------------------
	*/
    public function getDelete($id)
    {
        $employee = Employee::find($id);
        if ($employee == NULL)
        {
            Session::flash('not_found', 1);
        }
        else
        {
            if ($employee->photo != "")
            {
                @unlink($this->photo_folder . $employee->photo);
            }
            
            Employee::destroy($id);
            Session::flash('delete_success', 1);
        }
        
        return Redirect::to('admin/employee');
    }
    
    /*
	|--------------------------------------------------------------------------
	| Delete selected employee by id
	|--------------------------------------------------------------------------
	*/
    public function getDeleteSelected($ids)
    {        
        DB::transaction(function($ids) use ($ids)
        {   
            $arr_ids = explode("_", $ids);
            
            foreach($arr_ids as $id) {
                $employee = Employee::find($id);
                if ($employee == NULL)
                {
                    Session::flash('not_found', 1);
                }
                else
                {
                    if ($employee->photo != "")
                    {
                        @unlink($this->photo_folder . $employee->photo);
                    }

                    Employee::destroy($id);
                }
            }
            
            Session::flash('delete_success', 1);
        });
        
        return Redirect::to('admin/employee');
    }
    
    /*
	|--------------------------------------------------------------------------
	| View employee by id
	|--------------------------------------------------------------------------
	*/
    public function getView($id)
    {   
        $employee = Employee::find($id);
        
        if ($employee == NULL)
        {
            Session::flash('not_found', 1);
            return Redirect::to('admin/employee');
        }
        else
        {
            $data = array(
                'employee' => $employee,
                'kpi' => Kpi::where('job_id', '=', $employee->job_id)->get()
                //'salaryComponents' => SalaryComponent::orderBy('name', 'ASC')->get()
            );
            return View::make('admin.employee.view', $data);
        }
    }

    /*
	|--------------------------------------------------------------------------
	| Search employee by any field
	|--------------------------------------------------------------------------
	*/
    public function getSearch($key = "")
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
            'key' => $key,
            'employee' => Employee::where('id_number', 'LIKE', '%' . $key . '%')
                ->where('name', 'LIKE', '%' . $key . '%', 'OR')
                ->where('address', 'LIKE', '%' . $key . '%', 'OR')
                ->where('email', 'LIKE', '%' . $key . '%', 'OR')
                ->orderBy('id', 'asc')->take($this->per_page)->skip($page)->get(),
            'paginate' => Employee::where('id_number', 'LIKE', '%' . $key . '%')
                ->where('name', 'LIKE', '%' . $key . '%', 'OR')
                ->where('address', 'LIKE', '%' . $key . '%', 'OR')
                ->where('email', 'LIKE', '%' . $key . '%', 'OR')
                ->orderBy('id', 'asc')->paginate($this->per_page),
            'emptypes' => EmployeeType::orderBy('name', 'asc')->get(),
            'jobs' => Job::orderBy('title', 'asc')->get()
        );
        
        return View::make('admin.employee.index', $data);
    }
    
    /*
	|--------------------------------------------------------------------------
	| Advance Search employee GET Method
	|--------------------------------------------------------------------------
	*/
    public function getAdvSearch()
    {
        $page = intval(filter_input(INPUT_GET, 'page'));
        $page = (($page === 1 || is_null($page)) ? 0 : $page); 
        $page = ($page - 1) * $this->per_page;
        
        $employee = Employee::orderBy('id', 'asc');
        $id_number = false;
        $name = false;
        $employee_type_id = false;
        
        if (!empty(Input::get('id_number')))
        {
            $employee = $employee->where('id_number', 'LIKE', '%' . Input::get('id_number') . '%');
            $id_number = true;
        }
        
        if (!empty(Input::get('name')))
        {
            if ($id_number)
            {
                $employee = $employee->where('name', 'LIKE', '%' . Input::get('name') . '%', 'AND');
            }
            else
            {
                $employee = $employee->where('name', 'LIKE', '%' . Input::get('name') . '%');
            }
            $name = true;
        }
        
        if (!empty(Input::get('employee_type_id')) && Input::get('employee_type_id') !== 0)
        {
            if ($name)
            {
                $employee = $employee->where('employee_type_id', '=', Input::get('employee_type_id'), 'AND');
            }
            else
            {
                $employee = $employee->where('employee_type_id', '=', Input::get('employee_type_id'));                
            }
            $employee_type_id = true;
        }
        
        if (!empty(Input::get('job_id')) && Input::get('employee_type_id') !== 0)
        {
            if ($employee_type_id)
            {
                $employee = $employee->where('job_id', '=', Input::get('job_id'), 'AND');
            }
            else
            {
                $employee = $employee->where('job_id', '=', Input::get('job_id'));
            }
        }
        $data = array(
            'open_create_modal' => 0,
            'open_edit_modal' => 0,
            'add_success' => 0,
            'edit_success' => 0,
            'delete_success' => 0,
            'paginate' => $employee->paginate($this->per_page),
            'employee' => $employee->take($this->per_page)->skip($page)->get(),
            'emptypes' => EmployeeType::orderBy('name', 'asc')->get(),
            'jobs' => Job::orderBy('title', 'asc')->get(),
            'isAdvSearch' => 1,
            'advSearchValue' => Input::all()
        );
        //var_dump($data["paginate"]->getTotal(), $data["paginate"]->getPerPage(), $data["paginate"]->count(), $page); exit;
        //$data["paginate"]->setBaseUrl('adv-search?id_number='.Input::get('id_number').'&name='.Input::get('name').'&employee_type_id='.Input::get('employee_type_id').'&job_id='.Input::get('job_id'));
        
        return View::make('admin.employee.index', $data);
    }
    
    /*
	|--------------------------------------------------------------------------
	| Advance Search employee by any field
	|--------------------------------------------------------------------------
	*/
    public function postAdvSearch()
    {
        $page = intval(filter_input(INPUT_GET, 'page'));
        $page = (($page === 1 || is_null($page)) ? 0 : $page); 
        $page = ($page - 1) * $this->per_page;
        
        $employee = Employee::orderBy('id', 'asc');
        $id_number = false;
        $name = false;
        $employee_type_id = false;
        
        if (!empty(Input::get('id_number')))
        {
            $employee = $employee->where('id_number', 'LIKE', '%' . Input::get('id_number') . '%');
            $id_number = true;
        }
        
        if (!empty(Input::get('name')))
        {
            if ($id_number)
            {
                $employee = $employee->where('name', 'LIKE', '%' . Input::get('name') . '%', 'AND');
            }
            else
            {
                $employee = $employee->where('name', 'LIKE', '%' . Input::get('name') . '%');
            }
            $name = true;
        }
        
        if (!empty(Input::get('employee_type_id')))
        {
            if ($name)
            {
                $employee = $employee->where('employee_type_id', '=', Input::get('employee_type_id'), 'AND');
            }
            else
            {
                $employee = $employee->where('employee_type_id', '=', Input::get('employee_type_id'));                
            }
            $employee_type_id = true;
        }
        
        if (!empty(Input::get('job_id')))
        {
            if ($employee_type_id)
            {
                $employee = $employee->where('job_id', '=', Input::get('job_id'), 'AND');
            }
            else
            {
                $employee = $employee->where('job_id', '=', Input::get('job_id'));
            }
        }
        $data = array(
            'open_create_modal' => 0,
            'open_edit_modal' => 0,
            'add_success' => 0,
            'edit_success' => 0,
            'delete_success' => 0,
            'employee' => $employee->take($this->per_page)->skip($page)->get(),
            'paginate' => $employee->paginate($this->per_page),
            'emptypes' => EmployeeType::orderBy('name', 'asc')->get(),
            'jobs' => Job::orderBy('title', 'asc')->get(),
            'isAdvSearch' => 1,
            'advSearchValue' => Input::all()
        );
        
        return View::make('admin.employee.index', $data);
    }
    
    /*
	|--------------------------------------------------------------------------
	| Get employee attendance
	|--------------------------------------------------------------------------
	*/
    
    public function getAttendance($id)
    {
        $page = intval(filter_input(INPUT_GET, 'page'));
        $page = (($page === 1 || is_null($page)) ? 0 : $page); 
        $page = ($page - 1) * $this->per_page; 
        
        $data = array(
            'view' => 'attendance',
            'add_success' => 0,
            'add_leave_success' => 0,
            'edit_att_success' => 0,
            'open_create_modal' => 0,
            'open_create_modal_leave' => 0,
            'open_edit_modal' => 0,
            'open_edit_modal_leave' => 0,
            'delete_success' => 0,
            'employee' => Employee::find($id),
            'attendance' => EmployeeAttendace::where('employee_id', '=', $id)
                ->orderBy('work_date', 'asc')->take($this->per_page)->skip($page)->get(),
            'paginate' => EmployeeAttendace::where('employee_id', '=', $id)->paginate($this->per_page),
            'salaryComponents' => SalaryComponent::orderBy('name', 'ASC')->get()
        );
        
        if (Session::has('error_messages'))
        {
            if (Session::has('edit_att_failed'))
            {
                $data['open_edit_modal'] = 1;
            }
            else if (Session::has('add_att_failed'))
            {
                $data['open_create_modal'] = 1;
            }
            
            $data['error_messages'] = Session::get('error_messages');
            $data['input_values'] = Session::get('input_values');
            Session::forget('error_messages');
            Session::forget('input_values');
        } 
        
        return View::make('admin.employee.attendance', $data);
    }
    
    /*
	|--------------------------------------------------------------------------
	| Get employee leave history
	|--------------------------------------------------------------------------
	*/
    
    public function getLeave($id)
    {
        $page = intval(filter_input(INPUT_GET, 'page'));
        $page = (($page === 1 || is_null($page)) ? 0 : $page); 
        $page = ($page - 1) * $this->per_page; 
        
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
            'employee' => Employee::find($id),
            'leaves' => EmployeeLeave::where('employee_id', '=', $id)
                ->orderBy('from_date', 'asc')->take($this->per_page)->skip($page)->get(),
            'paginate' => EmployeeLeave::where('employee_id', '=', $id)->paginate($this->per_page),
            'salaryComponents' => SalaryComponent::orderBy('name', 'ASC')->get()
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
        
        return View::make('admin.employee.attendance', $data);
    }
    
    /*
	|--------------------------------------------------------------------------
	| View salary employee by id
	|--------------------------------------------------------------------------
	*/
    public function getSalary($id)
    {   
        $employee = Employee::find($id);
        
        if ($employee == NULL)
        {
            Session::flash('not_found', 1);
            return Redirect::to('admin/employee');
        }
        else
        {
            $data = array(
                'employee' => $employee,
                'salaryComponents' => SalaryComponent::orderBy('name', 'ASC')->get(),
                'salaryDeductions' => SalaryDeduction::orderBy('name', 'ASC')->get()
            );
            
            return View::make('admin.employee.salary', $data);
        }
    }
    
    /*
	|--------------------------------------------------------------------------
	| Event Add Employee Salary Component
	|--------------------------------------------------------------------------
	*/
    
    public function postAddSalaryComponent()
    {
        $values = Input::all();
        $empSalComp = new EmployeeSalaryComponent;
        foreach ($values as $key => $value)
        {
            $empSalComp->{$key} = $value;
        }
        $empSalComp->save();

        Session::flash('add_empsalcomp_success', 1);
        
        return Redirect::to('admin/employee/salary/'.Input::get('employee_id'));
    }
    
    /*
	|--------------------------------------------------------------------------
	| Event Delete Employee Salary Component
	|--------------------------------------------------------------------------
	*/
    
    public function getDeleteSalaryComponent($employee_id, $salary_component_id)
    {
        EmployeeSalaryComponent::where('employee_id', '=', $employee_id)
                ->where('salary_component_id', '=', $salary_component_id, 'AND')->delete();
        
        Session::flash('delete_empsalcomp_success', 1);
        
        return Redirect::to('admin/employee/salary/'.$employee_id);
    }
    
    /*
	|--------------------------------------------------------------------------
	| Event Add Employee Salary Deduction
	|--------------------------------------------------------------------------
	*/
    
    public function postAddSalaryDeduction()
    {
        $values = Input::all();
        $empSalDeduc = new EmployeeSalaryDeduction;
        foreach ($values as $key => $value)
        {
            $empSalDeduc->{$key} = $value;
        }
        $empSalDeduc->save();

        Session::flash('add_empsaldeduc_success', 1);
        
        return Redirect::to('admin/employee/salary/'.Input::get('employee_id'));
    }
    
    /*
	|--------------------------------------------------------------------------
	| Event Delete Employee Salary Component
	|--------------------------------------------------------------------------
	*/
    
    public function getDeleteSalaryDeduction($employee_id, $salary_deduction_id)
    {
        EmployeeSalaryDeduction::where('employee_id', '=', $employee_id)
                ->where('salary_deduction_id', '=', $salary_deduction_id, 'AND')->delete();
        
        Session::flash('delete_empsaldeduc_success', 1);
        
        return Redirect::to('admin/employee/salary/'.$employee_id);
    }
    
    /*
	|--------------------------------------------------------------------------
	| View qualification of employee by id
	|--------------------------------------------------------------------------
	*/
    public function getQualification($id)
    {   
        $employee = Employee::find($id);
        
        if ($employee == NULL)
        {
            Session::flash('not_found', 1);
            return Redirect::to('admin/employee');
        }
        else
        {
            $data = array(
                'employee' => $employee,
                'educationDegree' => EducationDegree::orderBy('name', 'ASC')->get(),
            );
            
            if (Session::has('error_messages'))
            {
                $data['error_messages'] = Session::get('error_messages');
                $data['input_values'] = Session::get('input_values');
                Session::forget('error_messages');
                Session::forget('input_values');
            }
            
            return View::make('admin.employee.qualification', $data);
        }
    }
    
    /*
	|--------------------------------------------------------------------------
	| View login credential of employee by id
	|--------------------------------------------------------------------------
	*/
    public function getLogin($id)
    {
        $employee = Employee::find($id);
        
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
            
            return View::make('admin.employee.login', $data);
        }
    }
    
    /*
	|--------------------------------------------------------------------------
	| View contact of employee by id
	|--------------------------------------------------------------------------
	*/
    public function getContact($id)
    {
        $employee = Employee::find($id);
        
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
            
            return View::make('admin.employee.contact', $data);
        }
    }
    
    /*
	|--------------------------------------------------------------------------
	| View employee performance by id
	|--------------------------------------------------------------------------
	*/
    public function getPerformance($id)
    {   
        $employee = Employee::find($id);
        
        if ($employee == NULL)
        {
            Session::flash('not_found', 1);
            return Redirect::to('admin/employee');
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
            return View::make('admin.employee.performance', $data);
        }
    }
    
    /*
	|--------------------------------------------------------------------------
	| Add employee kpi review
	|--------------------------------------------------------------------------
	*/
    public function getAddKpiReview($employee_id)
    {
        $employee = Employee::find($employee_id);
        $kpi = EmployeeKpi::where('employee_id', '=', $employee_id);
        
        if ($kpi->count() == 0)
        {
            $kpi = Kpi::where('job_id', '=', $employee->job_id)->get();
        }
        
        $data = array(
            'kpi' => $kpi,
            'employee' => $employee
        );
        
        if (Session::has('error_messages'))
        {
            $data['input_values'] = Session::get('input_values');
            Session::forget('input_values');
        }
        
        return View::make('admin.employee.tabs.performance.add-kpi-review', $data);
    }
    
    /*
	|--------------------------------------------------------------------------
	| Event Add employee kpi review
	|--------------------------------------------------------------------------
	*/
    public function postAddKpiReview()
    {
        $values = Input::all();
        
        $is_reviewer = ($values['reviewer_id'] == "" ? FALSE : TRUE);
        $is_blank = FALSE;
        $is_numeric = TRUE;
        
        foreach ($values['weight'] as $index => $weight)
        {
            if ($values['realization'][$index] == "") {
                $is_blank = TRUE;
            }
            
            if (!is_numeric($values['realization'][$index])) {
                $is_numeric = FALSE;
            }
        }
        
        if ($is_numeric && !$is_blank && $is_reviewer)
        {
            $date_now = date('Y-m-d');
            
            foreach ($values['weight'] as $index => $weight)
            {
                $kpi_result = new EmployeeKpiResult;
                $kpi_result->employee_id = $values['employee_id'];
                $kpi_result->reviewer_id = $values['reviewer_id'];
                $kpi_result->kpi_id = $values['kpi_id'][$index];
                $kpi_result->weight = $values['weight'][$index];
                $kpi_result->target = $values['target'][$index];
                $kpi_result->realization = $values['realization'][$index];
                $kpi_result->note = trim($values['note'][$index]);
                $kpi_result->review_at = $date_now;
                $kpi_result->save();
            }
            Session::flash('add_kpireview_success', 1);  
            
            return Redirect::to('admin/employee/kpi-history/'.$values['employee_id']);
        }
        else
        {
            Session::put('error_messages', 1);
            Session::put('input_values', Input::all());
            Session::flash('add_kpireview_failed', 1); 
            
            return Redirect::to('admin/employee/add-kpi-review/'.$values['employee_id']);
        }
    }
    
    /*
	|--------------------------------------------------------------------------
	| Edit employee kpi review
	|--------------------------------------------------------------------------
	*/
    public function getEditKpiReview($employee_id, $review_at)
    {
        $employee = Employee::find($employee_id);
        $kpi_reviews = EmployeeKpiResult::where('employee_id', '=', $employee_id)
                        ->where('review_at', '=', $review_at, 'AND')->get();
        
        $data = array(
            'kpi_reviews' => $kpi_reviews,
            'employee' => $employee
        );
        
        if (Session::has('error_messages'))
        {
            $data['input_values'] = Session::get('input_values');
            Session::forget('input_values');
        }
        
        return View::make('admin.employee.tabs.performance.edit-kpi-review', $data);
    }
    
    /*
	|--------------------------------------------------------------------------
	| Post event edit employee kpi review
	|--------------------------------------------------------------------------
	*/
    public function postEditKpiReview()
    {
        $values = Input::all();        
        
        $is_reviewer = ($values['reviewer_id'] == "" ? FALSE : TRUE);
        $is_blank = FALSE;
        $is_numeric = TRUE;
        
        foreach ($values['realization'] as $index => $weight)
        {
            if ($values['realization'][$index] == "") {
                $is_blank = TRUE;
            }
            
            if (!is_numeric($values['realization'][$index])) {
                $is_numeric = FALSE;
            }
        }
        
        if ($is_numeric && !$is_blank && $is_reviewer)
        {            
            foreach ($values['realization'] as $index => $weight)
            {
                $kpi_result = EmployeeKpiResult::find($values['kpi_result_id'][$index]);
                $kpi_result->reviewer_id = $values['reviewer_id'];
                $kpi_result->realization = $values['realization'][$index];
                $kpi_result->note = trim($values['note'][$index]);
                $kpi_result->save();
            }
            Session::flash('edit_kpireview_success', 1);  
            
            return Redirect::to('admin/employee/kpi-history/'.$values['employee_id']);
        }
        else
        {
            Session::put('error_messages', 1);
            Session::put('input_values', Input::all());
            Session::flash('add_kpireview_failed', 1); 
            
            return Redirect::to('admin/employee/edit-kpi-review/'.$values['employee_id'].'/'.$values['review_at']);
        }
    }
    
    /*
	|--------------------------------------------------------------------------
	| Delete employee kpi review
	|--------------------------------------------------------------------------
	*/
    
    public function getDeleteKpiReview($employee_id, $review_at)
    {
        EmployeeKpiResult::where('review_at', '=', $review_at)->where('employee_id', '=', $employee_id, 'AND')
                ->delete();
        
        Session::flash('delete_kpireview_success', 1); 
        
        return Redirect::to('admin/employee/kpi-history/'.$employee_id);
    }
    
    /*
	|--------------------------------------------------------------------------
	| Employee kpi history list
	|--------------------------------------------------------------------------
	*/
    
    public function getKpiHistory($employee_id)
    {        
        $data = array(
            'kpi_results' => EmployeeKpiResult::where('employee_id', '=', $employee_id)
                ->groupby('review_at')->get(array('*')),
            'employee' => Employee::find($employee_id)
        );
        
        return View::make('admin.employee.tabs.performance.kpi-history', $data);
    }
    
    /*
	|--------------------------------------------------------------------------
	| Employee edit kpi list
	|--------------------------------------------------------------------------
	*/
    
    public function getEditKpi($employee_id)
    {
        $employee = Employee::find($employee_id);
                
        $data = array(
            'employee' => $employee,
            'kpi' => Kpi::where('job_id', '=', $employee->job_id)->get()
        );
        
        return View::make('admin.employee.edit-kpi-list', $data);
    }
    
    /*
	|--------------------------------------------------------------------------
	| Employee kpi result
	|--------------------------------------------------------------------------
	*/
    
    public function getKpiResult($employee_id, $review_at)
    {
        $employee = Employee::find($employee_id);
        $kpi_reviews = EmployeeKpiResult::where('employee_id', '=', $employee_id)
                        ->where('review_at', '=', $review_at, 'AND')->get();
        
        $data = array(
            'kpi_reviews' => $kpi_reviews,
            'employee' => $employee
        );
        
        return View::make('admin.employee.tabs.performance.kpi-result', $data);
    }
}