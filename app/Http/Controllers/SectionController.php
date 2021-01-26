<?php

namespace App\Http\Controllers;

use App\Company;
use App\Department;
use App\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class SectionController extends Controller
{
    public function get_data(){
        // $companies_data = Company::all();
        // $departments_data = Department::all();
        $data = Section::select('companies.company_code','companies.company_name', 'departments.department_code', 'departments.department_name', 'sections.section_code', 'sections.section_name')
            ->leftjoin('companies', 'companies.company_code', '=', 'sections.company_code')
            ->leftjoin('departments', function($join) {
                $join->on('departments.company_code', '=', 'companies.company_code')
                    ->on('departments.department_code', '=', 'sections.department_code');
            })
            ->orderBy('companies.company_code', 'asc')
            ->orderBy('departments.department_code', 'asc')
            ->orderBy('sections.section_code', 'asc')
            ->get();
        return $data;
        // return view('section', compact('data', 'companies_data', 'departments_data'));
    }

    public function insert_data(Request $req){
        //get the parameter value
        $params_comp_code = $req->input('company_code');
        $params_dept_code = $req->input('department_code');
        $params_name = $req->input('section_name');

        //check if the params_name is existing to the database
        $if_exist = Section::select('section_name')
                    ->where('company_code', $params_comp_code)
                    ->where('department_code', $params_dept_code)
                    ->where('section_name',strtoupper($params_name))
                    ->get();

        //Condition if the data is unique or no same value to the database
        if(count($if_exist) == 0 && $params_name != '' && $params_dept_code != ''){
            //Get the last code with incrementation
            $last_code = Section::select(DB::raw('section_code + 1 as new_code'))
                    ->where('company_code', $params_comp_code)
                    ->where('department_code', $params_dept_code)
                    ->orderBy('section_code', 'desc')
                    ->limit(1)
                    ->get();
            
            //Add '0' Prefix 
            $new_id = str_pad(count($last_code) > 0 ? $last_code[0]->new_code : '1', 3, '0', STR_PAD_LEFT);
            
            //Insert Function
            Section::insert(['company_code'=>$params_comp_code, 'department_code'=>$params_dept_code, 'section_code'=>$new_id, 'section_name'=>$params_name, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s'), 'updated_by'=>'36825']);
        } 
        
        //Redirecting of previous routes that you enter
        // return Redirect::back();
        return $this->get_data();
    }
}
