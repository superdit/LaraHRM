<?php

class EmployeeAttendace extends Eloquent {

	/* Eloquent */
	protected $table = "employee_attendance";
	public $timestamps = false;
		
    public function employee()
    {
        return $this->belongsTo('Employee', 'employee_id');
    }
}