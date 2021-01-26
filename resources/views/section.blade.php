@extends('app')
@section('title','Section')
@section('header', 'Section Page')
@section('content')
    <form method="POST" action="section">
        <select name="company_code" id="company_code_select">
            @foreach($companies_data as $key => $companies)
                <option value={{$companies->company_code}}>{{$companies->company_name}}</option>
            @endforeach
        </select>

        <select name="department_code" id="department_code_select">
        </select>
        <input type="text" name="section_name" placeholder="Enter Section Name">
        <button type="submit">Submit</button>
        @csrf
    </form>
    <br>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Company Name</th>
                <th>Department Name</th>
                <th>Section Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $key => $sections)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$sections->company_name}}</td>
                    <td>{{$sections->department_name}}</td>
                    <td>{{$sections->section_name}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
<script>
var departments_data = {!! json_encode($departments_data) !!};

window.addEventListener("load", function() {
    myFunction();
});

document.getElementById("company_code_select").addEventListener("change", function() {
    myFunction();
});



function myFunction(){
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
</script>
@endsection

