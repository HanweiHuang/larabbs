@extends('layouts.app')

@section('title')
My Notices
@stop

@section('content')

    <div class="container">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">

                <div class="panel-body">
                    <h3 class="text-center">
                        <span class="glyphicon glyphicon-bell" aria-hidden="true">My Notice</span>
                    </h3>
                    <hr>
                    @if($notifications->count())
                        <div class="notification-list">
                            @foreach($notifications as $notification)
                                @include('notifications.types._'.snake_case(class_basename($notification->type)))
                            @endforeach

                            {!! $notifications->render() !!}

                        </div>
                    @else
                        <div class="empty-block">No Message Notice!</div>
                    @endif

                </div>

            </div>
        </div>
    </div>
@stop