@extends('layouts.app')

@section('title', 'Topic List')

@section('content')

    <div class="row">
        <div class="col-lg-9 col-md-9 topic-list">
            <div class="panel panel-default">

                <div class="panel-heading">
                    <ul class="nav nav-pills">
                        <li role="presentation" class="active"><a href="#">Last Reply</a></li>
                        <li role="presentation"><a href="#">New Publish</a></li>
                    </ul>
                </div>

                <div class="panel-body">
                    {{-- 话题列表 --}}
                    @include('topics._topic_list', ['topics' => $topics])
                    {{-- 分页 --}}
                    {!! $topics->appends(Request::except('page'))->render() !!}
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 sidebar">
            @include('topics._sidebar')
        </div>
    </div>

@endsection