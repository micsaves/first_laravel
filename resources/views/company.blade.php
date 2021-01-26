@extends('app')
@section('title','Company')
@section('header', 'Company Page')
@section('content')
    <form method="POST" action="company">
        <input type="text" name="company_name" placeholder="Enter Company Name">
        <button type="submit">Submit</button>
        @csrf
    </form>
    <br>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Company Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $key => $companies)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$companies->company_name}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection