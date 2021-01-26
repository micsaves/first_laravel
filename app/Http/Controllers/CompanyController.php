<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CompanyController extends Controller
{
    public function get_data(){
        $data = Company::all();
        // return view('company',compact('data'));
        return $data;
    }

    
    public function insert_data(Request $req){
        //get the parameter value
        $params_name = $req->input('company_name');

        //check if the parameter/params_name is existing to the database
        $if_exist = Company::select('company_name')
                    ->where('company_name',strtoupper($params_name))
                    ->get();

        //Condition if the data is unique or no same value to the database
        if(count($if_exist) == 0 && $params_name != ''){ 

            //Get the last code with incrementation
            $last_code = Company::select(DB::raw('company_code + 1 as new_code'))
            ->orderBy('company_code', 'desc')
            ->limit(1)
            ->get();

            //Add '0' Prefix 
            $new_id = str_pad(count($last_code) > 0 ? $last_code[0]->new_code : '1', 3, '0', STR_PAD_LEFT);
            
            //Insert Function
            Company::insert(['company_code'=>$new_id, 'company_name'=>strtoupper($params_name), 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s'), 'updated_by'=>'36825']);
        }
        
        //Redirecting of previous routes that you enter
        // return Redirect::back();
        return $this->get_data(); 
        }
}
