<?php

namespace employee;

use View;
use BaseController;
use Validator;
use Input;
use User;
use Session;
use Redirect;
use Hash;

class HomeController extends BaseController {
    
    public function getIndex()
    {
        return View::make('employee.home.index');
    }
}