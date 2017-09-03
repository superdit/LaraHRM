<?php

class Workshift extends Eloquent {

    protected $table = 'work_shifts';
    
    public function employee()
    {
        return $this->hasMany('Employee');
    }

}