<?php

class EmployeeContact extends Eloquent {

	/* Eloquent */
	protected $table = "employee_contact";
	public $timestamps = false;
		
    public function employee()
    {
        return $this->belongsTo('Employee', 'employee_id');
    }
}