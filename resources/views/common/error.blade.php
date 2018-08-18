@if (count($errors) > 0)
    <div class="alert alert-danger">
        <h4>errors exist：</h4>
        <ul>
            @foreach ($errors->all() as $error)
                <li><i class="glyphicon glyphicon-remove"></i> {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif