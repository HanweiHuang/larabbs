@if (count($f_urls))
    <div class="masonry_glo">
        @foreach ($f_urls as $f_url)

            <div class="item">

                <div class="thumbnail item-content">
                    <img class="img-fluid" src="{{$f_url}}">
                </div>

            </div>

        @endforeach
    </div>


@else
    <div class="empty-block">Current No Data ~_~ </div>
@endif