<?php

class SalaryDeduction extends Eloquent {

    protected $table = 'salary_deduction';
    public $timestamps = false;

    public function employee()
    {
        return $this->belongsToMany('Employee', 'employee_salary_deduction', 'salary_deduction_id', 'employee_id');
    }
}