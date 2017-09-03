<?php

class EmployeeKpi extends Eloquent {

	/* Eloquent */
	protected $table = "employee_kpi";
	//public $timestamps = false;
    
    public function employee()
    {
        return $this->belongsTo('Employee', 'employee_id', 'id');
    }
    
}