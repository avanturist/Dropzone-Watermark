@if(session('delete'))
    <p class="alert alert-danger">{{ session('delete') }}</p>
@endif
<h3>Завантажені фото</h3>
<table class="table table-hover table-responsive">
    <thead>
    <tr>
        <th>Картинка</th>
        <th>Імя Картинки</th>
        <th>Видалити</th>
    </tr>
    </thead>
    <tbody>

    @foreach($fotos as $foto)
        <tr>
            <td><img src="{{ asset(config('settings.theme')) }}/images/{{ $foto->filename }}" alt="{{ $foto->filename }}" class="img-thumbnail"  ></td>
            <td>{{ $foto->filename }}</td>
            <td>
                {!! Form::open(['route' => ['delete',$foto->id], 'method'=>'post']) !!}
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                {!! Form::submit('Видалити', ['class'=>'btn btn-danger']) !!}
                {!! Form::close() !!}
            </td>
        </tr>

    @endforeach

    </tbody>

</table>

{{--slider-show --}}
@if(!empty($fotos) && is_object($fotos))
    <div class="slideshow-container">

            @foreach($fotos as $foto)
                <div class="mySlides">
                    <img src="{{ asset(config('settings.theme')) }}/images/{{ $foto->filename }}" alt="{{ $foto->filename }}" class="img-thumbnail img-slider"  >
                </div>
            @endforeach
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>

    </div>
@endif