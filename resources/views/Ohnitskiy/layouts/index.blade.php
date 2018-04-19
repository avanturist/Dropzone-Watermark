<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    @yield('css')

</head>
<body>

<nav>
    <div class="container">
        <div class="row header">
            @if(url()->current() == url('/'))
                <div class="col-md-12">
                    <a href="{{ url('/dropzone') }}" class="glyphicon glyphicon-home"> PageDropzone</a>
                </div>
            @else
                <div class="col-md-12">
                    <div class="row header" style="text-align: center">
                        <div class="col-md-4">
                            <a href="{{ url('/') }}" class="glyphicon glyphicon-home"> На головну</a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ url('/dropzone') }}" class="glyphicon glyphicon-save-file"> PageDropzone</a>
                        </div>
                        <div class="col-md-4">
                                <a href="{{ url('/images') }}" class="glyphicon glyphicon-picture"> Збережені фото</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</nav>

    @yield('content')


@yield('js')

</body>
</html>
