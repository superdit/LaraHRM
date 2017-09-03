<?php

class Kra extends Eloquent {

    protected $table = 'kra';
    public $timestamps = false;

    public function kpi()
    {
        return $this->hasMany('Kpi', 'kra_id', 'id');
    }
}