@extends(config("settings.theme").'.layouts.index')

@section('css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ url('/css/custom.css') }}">
    <link rel="stylesheet" href="{{ url('/css/dropzone.css') }}">

@endsection
@section('content')

    <div class="container top">
        <table class="table table-responsive table-hover">
            <thead>
            <tr>
                <th>Картинка</th>
                <th>Імя картинки</th>
                <th>Видалити</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($photos))
                <h3>Збережені фото</h3>
                @foreach($photos as $photo)
                    <tr>
                        <td><img src="{{ config('settings.theme') }}/images/dropzone/{{ $photo->foto_name }}" alt="{{ $photo->foto_name }}" class="img-thumbnail"></td>
                        <td>{{ $photo->foto_name }}</td>

                        {{--kod delete image --}}
                        <td>Видалити</td>
                    </tr>
                @endforeach
            @endif
            </tbody>

        </table>

    </div>
@endsection
@section('js')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="{{ url('/js/dropzone.js') }}"></script>
    <script src="{{ url('/js/dropzone-config.js')  }}"></script>
    <script src="{{ url('/js/custom.js')  }}"></script>

@endsection