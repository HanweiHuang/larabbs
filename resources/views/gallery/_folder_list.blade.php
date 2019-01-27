@if (count($folders))

    <ul class="media-list">
        @foreach ($folders as $folder)
            <li class="media">
                <div class="media-left">
                    <a href="">
                        {{-- <img class="media-object img-thumbnail" style="width: 52px; height: 52px;" src=""> --}}
                        <span class="glyphicon glyphicon-folder-close"></span>
                    </a>
                </div>

                <div class="media-body">

                    <div class="media-heading">
                        <a href="{{route('folders.show', $folder->name)}}" title="{{ $folder->name }}">
                            {{ $folder->name }}
                        </a>
                        <a class="pull-right" href="" >
                            <span class="badge">  </span>
                        </a>
                    </div>

                    <div class="media-body meta">
                        <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                        <span class="timeago" title="最后活跃于">{{ $folder->updated_at->diffForHumans() }}</span>
                    </div>

                </div>
            </li>

            @if ( ! $loop->last)
                <hr>
            @endif

        @endforeach
    </ul>

@else
    <div class="empty-block">Current No Data ~_~ </div>
@endif