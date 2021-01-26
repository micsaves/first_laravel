@extends('app')
@section('title','Employee')
@section('header', 'Employee Page')
@section('content')
    <form method="POST" action="employee">
        <select name="company_code" id="company_code_select">
            @foreach($companies_data as $key => $companies)
                <option value={{$companies->company_code}}>{{$companies->company_name}}</option>
            @endforeach
        </select>

        <select name="department_code" id="department_code_select">
        </select>

        <select name="section_code" id="section_code_select">
        </select>

        <select name="gender">
            <option value=1>Male</option>
            <option value=0>Female</option>
        </select>

        <select name="contract_status">
            <option value="R">Regular</option>
            <option value="C">Contractual</option>
        </select>

        <input type="text" name="employee_name" placeholder="Enter Employee Name">
        <button type="submit">Submit</button>
        @csrf
    </form>
    <br>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Employee Name</th>
                <th>Gender</th>
                <th>Contract Status</th>
                <th>Company Name</th>
                <th>Department Name</th>
                <th>Section Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $key => $employees)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$employees->employee_name}}</td>
                    <td>{{$employees->gender}}</td>
                    <td>{{$employees->contract_status}}</td>
                    <td>{{$employees->company_name}}</td>
                    <td>{{$employees->department_name}}</td>
                    <td>{{$employees->section_name}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

<script>
var departments_data = {!! json_encode($departments_data) !!};
var sections_data = {!! json_encode($sections_data) !!};

window.addEventListener("load", function() {
    change_company();
    change_department();
});

document.getElementById("company_code_select").addEventListener("change", function() {
    change_company();
    change_department();
});

document.getElementById("department_code_select").addEventListener("change", function() {
    change_department();
});



function change_company(){
    var x = document.getElementById("department_code_select");
    var y = departments_data.filter(rec=>{
        return rec.company_code  ==  document.getElementById("company_code_select").value
    }) 


    var ctr = y.length > 0 ? y.length : x.length

    for(var z = 0; z <= ctr; z++){
        x.remove(0)
    }
    for(var i = 0 ; i < y.length ; i++){
        if(y.length > 0){
            var option = document.createElement("option");
            option.text = y[i].department_name;
            option.value = y[i].department_code;
            x.add(option);
        }
    }
}

function change_department(){
    var x = document.getElementById("section_code_select");
    var y = sections_data.filter(rec=>{
        return rec.company_code  ==  document.getElementById("company_code_select").value
        && rec.department_code  ==  document.getElementById("department_code_select").value
    }) 


    var ctr = y.length > 0 ? y.length : x.length

    for(var z = 0; z <= ctr; z++){
        x.remove(0)
    }
    for(var i = 0 ; i < y.length ; i++){
        if(y.length > 0){
            var option = document.createElement("option");
            option.text = y[i].section_name;
            option.value = y[i].section_code;
            x.add(option);
        }
    }
}
</script>
@endsection