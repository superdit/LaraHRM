<?php

class Employee extends Eloquent {

    protected $table = 'employee';
    
    public function workshift()
    {
        return $this->belongsTo('Workshift');
    }
    
    public function user()
    {
        return $this->hasOne('User', 'employee_id', 'id');
    }
    
    public function contact()
    {
        return $this->hasMany('EmployeeContact', 'employee_id', 'id')->orderBy('contact_name', 'ASC');
    }
    
    public function nation()
    {
        return $this->belongsTo('Nation');
    }

    public function employeetype()
    {
        return $this->belongsTo('EmployeeType', 'employee_type_id', 'id');
    }
    
    public function job()
    {
        return $this->belongsTo('Job', 'job_id', 'id');
    }
    
    public function kpi()
    {
        return $this->belongsToMany('Kpi', 'employee_kpi', 'employee_id', 'kpi_id');
    }
    
    public function salarycomponent()
    {
        return $this->belongsToMany('SalaryComponent', 'employee_salary_component', 'employee_id', 'salary_component_id');
    }
    
    public function salarydeduction()
    {
        return $this->belongsToMany('SalaryDeduction', 'employee_salary_deduction', 'employee_id', 'salary_deduction_id');
    }
    
    public function workexperience()
    {
        return $this->hasMany('WorkExperience', 'employee_id', 'id')->orderBy('from_date', 'ASC');
    }
    
    public function education()
    {
        return $this->hasMany('Education', 'employee_id', 'id')->orderBy('start_date', 'ASC');
    }
    
    public function attendance() 
    {
        return $this->hasMany('EmployeeAttendance', 'employee_id', 'id');
    }
    
    public function skill()
    {
        return $this->hasMany('Skill', 'employee_id', 'id')->orderBy('name', 'ASC');
    }
}