@extends('app')
@section('title','Department')
@section('header', 'Department Page')
@section('content')
    <form method="POST" action="department">
        <select name="company_code">
            @foreach($companies_data as $key => $companies)
                <option value={{$companies->company_code}}>{{$companies->company_name}}</option>
            @endforeach
        </select>
        <input type="text" name="department_name" placeholder="Enter Department Name">
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
            </tr>
        </thead>
        <tbody>
            @foreach($data as $key => $departments)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$departments->company_name}}</td>
                    <td>{{$departments->department_name}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection