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

class TeamController extends BaseController {
    
    public function getIndex()
    {
        return View::make('team.home.index');
    }
}