<?php

namespace api;

use BaseController;
use Input;
use Employee;
use Session;
use Redirect;
use DB;

class EmployeeController extends BaseController {
    
    public function getSearch()
    {
        $values = Input::all();
        
        $query = Employee::where('id_number', 'LIKE', '%' . $values['q'] . '%')
                ->where('name', 'LIKE', '%' . $values['q'] . '%', 'OR')
                ->where('address', 'LIKE', '%' . $values['q'] . '%', 'OR')
                ->where('email', 'LIKE', '%' . $values['q'] . '%', 'OR');
        
        $total = $query->count();
        
        $page = $values['page'];
        $page = (($page === 1 || is_null($page)) ? 0 : $page); 
        $page = ($page - 1) * $values['page_limit']; 
        
        $json = $query->orderBy('id', 'asc')->take($values['page_limit'])
                ->skip($page)->get()->toJson();
        
        echo $values['callback'].'({"total":' . $total . ', "employees":' . $json . '})';
    }
}