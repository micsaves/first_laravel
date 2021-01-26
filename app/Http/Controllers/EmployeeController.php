<?php

namespace App\Http\Controllers;

use App\Company;
use App\Department;
use App\Employee;
use App\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class EmployeeController extends Controller
{
    public function get_data(){
        // $companies_data = Company::all();
        // $departments_data = Department::all();
        // $sections_data = Section::all();
        $data = Employee::from('employees as E')
                ->select('E.employee_name', DB::raw('CASE WHEN E.gender = 1 THEN "Male" ELSE "Female" END as gender, CASE WHEN E.contract_status = "R" THEN "Regular" ELSE "Contractual" END as contract_status'), 'C.company_name', 'D.department_name', 'S.section_name')
                ->leftjoin('companies as C', 'C.company_code', '=', 'E.company_code')
                ->leftjoin('departments as D', function($join) {
                    $join->on('D.company_code', '=', 'C.company_code')
                        ->on('D.department_code', '=', 'E.department_code');
                })
                ->leftjoin('sections as S', function($join) {
                    $join->on('S.company_code', '=', 'C.company_code')
                        ->on('S.department_code', '=', 'D.department_code')
                        ->on('S.section_code', '=', 'E.section_code');
                })
                ->orderBy('E.employee_code', 'asc')
                ->get();
        return $data;
        // return view('employee', compact('data', 'companies_data', 'departments_data', 'sections_data'));
    }

    public function insert_data(Request $req){
        //get the parameter value
        $params_comp_code = $req->input('company_code');
        $params_dept_code = $req->input('department_code');
        $params_sec_code = $req->input('section_code');
        $params_gender = $req->input('gender');
        $params_contract_status = $req->input('contract_status');
        $params_name = $req->input('employee_name');

        //check if the params_name is existing to the database
        $if_exist = Employee::select('employee_name')
                    ->where('company_code', $params_comp_code)
                    ->where('department_code', $params_dept_code)
                    ->where('section_code',$params_sec_code)
                    ->where('employee_name','like', '%'.$params_name.'%')
                    ->get();

        //Condition if the data is unique or no same value to the database
        if(count($if_exist) == 0 && $params_name != '' && $params_dept_code != '' && $params_sec_code != ''){
            //Get the last code with incrementation
            $last_code = Employee::select(DB::raw('employee_code + 1 as new_code'))
                    ->orderBy('employee_code', 'desc')
                    ->limit(1)
                    ->get();

            //Add '0' Prefix 
            $new_id = str_pad(count($last_code) > 0 ? $last_code[0]->new_code : '1', 5, '0', STR_PAD_LEFT);
            
            //Insert Function
            Employee::insert(['employee_code'=>$new_id, 'employee_name'=>$params_name, 'gender'=>$params_gender, 'contract_status'=>$params_contract_status, 'company_code'=>$params_comp_code, 'department_code'=>$params_dept_code, 'section_code'=>$params_sec_code, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s'), 'updated_by'=>'36825']);
        }
        //Redirecting of previous routes that you enter
        // return Redirect::back();
        return $this->get_data();
    }
}
