<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return Redirect::to('home');
});

Route::controller('home', 'HomeController');
Route::controller('auth', 'AuthController');

Route::filter('role', function()
{
    if (Auth::check()) 
    {
        if (Auth::user()->role != 'admin' && Auth::user()->role != 'employee') 
        {
            return Redirect::to('auth/signin');
        }
    }
    else
    {
        return Redirect::to('auth/signin');
    }
});

Route::group(array('before' => 'role'), function()
{
    if (null !== Auth::user())
    {
        if (Auth::user()->role == "admin")
        {
            Route::controller('admin/user', 'admin\UserController');
            Route::controller('admin/event', 'admin\EventController');
            Route::controller('admin/salarycomponent', 'admin\SalarycomponentController');
            Route::controller('admin/edudegree', 'admin\EdudegreeController');
            Route::controller('admin/education', 'admin\EducationController');
            Route::controller('admin/employee', 'admin\EmployeeController');
            Route::controller('admin/employeecontact', 'admin\EmployeecontactController');
            Route::controller('admin/employeetype', 'admin\EmployeetypeController');
            Route::controller('admin/employeesetting', 'admin\EmployeesettingController');
            Route::controller('admin/workshift', 'admin\WorkshiftController');
            Route::controller('admin/attendance', 'admin\AttendanceController');
            Route::controller('admin/nation', 'admin\NationController');
            Route::controller('admin/department', 'admin\DepartmentController');
            Route::controller('admin/job', 'admin\JobController');
            Route::controller('admin/kpi', 'admin\KpiController');
            Route::controller('admin/performance', 'admin\PerformanceController');
            Route::controller('admin/skill', 'admin\SkillController');
            Route::controller('admin/workexp', 'admin\WorkexpController');
            Route::controller('admin/setting', 'admin\SettingController');
        }
        else if (Auth::user()->role == "employee")
        {
            Route::controller('employee/home', 'employee\HomeController');
            Route::controller('employee/profile', 'employee\ProfileController');
            Route::controller('employee/event', 'employee\EventController');
            Route::controller('employee/team', 'employee\TeamController');
        }
    }
        
    // api 
    Route::controller('api/employee', 'api\EmployeeController');
});

Route::filter('employee', function()
{
    if(Auth::user()->role != 'employee') 
    {
        return Redirect::to('auth/signin');
    }
});

