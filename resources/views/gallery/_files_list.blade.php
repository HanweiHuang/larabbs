@if (count($f_urls))

    @foreach ($f_urls as $f_url)
        <div class="col-md-4 col-sm-6 item">
            <div class="thumbnail">
                <img class="img-fluid" src="{{$f_url}}">
            </div>
        </div>
        @if ( ! $loop->last)
            <hr>
        @endif

    @endforeach

@else
    <div class="empty-block">Current No Data ~_~ </div>
@endif