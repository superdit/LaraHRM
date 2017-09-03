<?php

class SalaryComponent extends Eloquent {

    protected $table = 'salary_component';
    public $timestamps = false;

    public function employee()
    {
        return $this->belongsToMany('Employee', 'employee_salary_component', 'salary_component_id', 'employee_id');
    }
}