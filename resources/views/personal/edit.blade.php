@extends('page-template')
@section('page-content')
    @if($user != null)
        <h1>Edit {{$user->id}}</h1>
    @else
        <h1>New user</h1>
    @endif
@endsection
