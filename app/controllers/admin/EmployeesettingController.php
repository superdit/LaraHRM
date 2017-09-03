<?php

namespace admin;

use BaseController;
use View;


class EmployeesettingController extends BaseController {

    public function getIndex()
    {
        return View::make('admin.employeesetting.index');
    }
    
    public function getEmploymenttype()
    {
        return View::make('admin.employeesetting.index');
    }
    
    public function getEdudegree()
    {
        return View::make('admin.employeesetting.index');
    }
    
    public function getNation()
    {
        return View::make('admin.employeesetting.index');
    }
    
    public function getJob()
    {
        return View::make('admin.employeesetting.index');
    }
    
    public function getSalarycomponent()
    {
        return View::make('admin.employeesetting.index');
    }
    
    public function getWorkshift()
    {
        return View::make('admin.employeesetting.index');
    }
    
    public function getPerformance()
    {
        return View::make('admin.employeesetting.index');
    }
    
    public function getFilterKpi($kra_id = 0, $job_id = 0)
    {
        $data = array(
            'kra_id' => $kra_id,
            'job_id' => $job_id
        );
        return View::make('admin.employeesetting.index', $data);
    }
    
    public function getEditKpiGroup($job_id)
    {
        $data = array(
            'job_id' => $job_id
        );
        return View::make('admin.employeesetting.index', $data);
    }
}