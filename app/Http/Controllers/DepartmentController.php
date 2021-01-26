<?php

namespace App\Http\Controllers;

use App\Company;
use App\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class DepartmentController extends Controller
{
    public function get_data(){
        // $companies_data = Company::all();
        $data = Department::from('departments as D')
            ->leftjoin('companies as C', 'C.company_code', '=', 'D.company_code')
            ->select('C.company_code','C.company_name', 'D.department_code', 'D.department_name')
            ->orderBy('C.company_code', 'asc')
            ->orderBy('D.department_code', 'asc')
            ->get();
        return $data;
        // return view('department',compact('data','companies_data'));
    }

    public function insert_data(Request $req){
        //get the parameter value
        $params_code = $req->input('company_code');
        $params_name = $req->input('department_name');

        //check if the params_name is existing to the database
        $if_exist = Department::select('department_name')
                    ->where('company_code', $params_code)
                    ->where('department_name',strtoupper($params_name))
                    ->get();

        //Condition if the data is unique or no same value to the database
        if(count($if_exist) == 0 && $params_name != ''){

            //Get the last code with incrementation
            $last_code = Department::select(DB::raw('department_code + 1 as new_code'))
                    ->where('company_code', $params_code)
                    ->orderBy('department_code', 'desc')
                    ->limit(1)
                    ->get();

            //Add '0' Prefix 
            $new_id = str_pad(count($last_code) > 0 ? $last_code[0]->new_code : '1', 3, '0', STR_PAD_LEFT);
            
            //Insert Function
            Department::insert(['company_code'=>$params_code, 'department_code'=>$new_id, 'department_name'=>$params_name, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s'), 'updated_by'=>'36825']);
        }

        //Redirecting of previous routes that you enter
        // return Redirect::back();
        return $this->get_data();
    }
}
