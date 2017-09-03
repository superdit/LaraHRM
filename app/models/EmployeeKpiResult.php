<?php

class EmployeeKpiResult extends Eloquent {

	/* Eloquent */
	protected $table = "employee_kpi_result";
	//public $timestamps = false;
    
    public function employee()
    {
        return $this->belongsTo('Employee', 'employee_id', 'id');
    }
    
    public function reviewer()
    {
        return $this->belongsTo('Employee', 'reviewer_id', 'id');
    }
    
    public function kpi()
    {
        return $this->belongsTo('Kpi', 'kpi_id', 'id');
    }
}