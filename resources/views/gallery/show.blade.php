@extends('layouts.app')

@section('title', 'Gallery')

@section('content')

    <div class="row folders-show gallery">
        <div class="col-lg-9 col-md-9 topic-list">


            <div class="alert alert-info" role="alert">
                {{trans('gallery.folder_name') .': '. $folder}}
            </div>


            <div class="panel panel-default">

                <div class="panel-heading">
                    <ul class="nav nav-pills">
                         {{-- <li class="{{ active_class( ! if_query('order', 'recent') ) }}"><a href="{{ Request::url() }}?order=default">{{trans('topic.order_by_reply')}}</a></li>
                         <li class="{{ active_class(if_query('order', 'recent')) }}"><a href="{{ Request::url() }}?order=recent">{{trans('topic.order_by_public')}}</a></li> --}}

                    </ul>
                </div>

                <div class="panel-body">

                    {{-- 话题列表 --}}
                    {{-- @include('gallery._lib_list', ['topics' => $topics]) --}}

                    @include('gallery._files_list', ['files' => $files, 'f_urls' => $f_urls])

                    {{-- 分页 --}}
                    {{-- {!! $topics->appends(Request::except('page'))->render() !!} --}}
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 sidebar">
             {{-- @include('topics._sidebar') --}}
        </div>
    </div>

@endsection