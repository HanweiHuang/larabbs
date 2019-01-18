@extends('layouts.app')
@section('title','No authority to visit')

@section('content')

<div class="col-md-4 col-md-offset-4">
    <div class="panel panel-default">
        @if(Auth::check())
            <div class="alert alert-danger text-center">
                No authority for this account
            </div>
        @else
            <div class="alert alert-danger text-center">
                Please Login First
            </div>
            <a class="btn btn-lg btn-primary btn-block" href="{{route('login')}}">
                <span class="glyphicon glyphicon-log-in" aria-hidden="true">
                    LOGIN
                </span>
            </a>
        @endif
    </div>
</div>

@stop