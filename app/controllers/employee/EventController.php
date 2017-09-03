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

class EventController extends BaseController {
    
    public function getIndex()
    {
        return View::make('event.home.index');
    }
}