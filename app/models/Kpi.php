<?php

class Kpi extends Eloquent {

    protected $table = 'kpi';
    public $timestamps = false;

    public function job()
    {
        return $this->belongsTo('Job', 'job_id', 'id');
    }
    
    public function kra()
    {
        return $this->belongsTo('Kra', 'kra_id', 'id');
    }
    
    public function employee()
    {
        return $this->belongsToMany('Employee', 'employee_kpi', 'kpi_id', 'employee_id');
    }
}