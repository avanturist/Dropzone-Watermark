@extends(config("settings.theme").'.layouts.index')

@section('css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ url('/css/custom.css') }}">
    <link rel="stylesheet" href="{{ url('/css/dropzone.css') }}">

@endsection


@section('content')
    <div class="container top">
        <div class="row">
            <div class="col-sm-10 offset-sm-1">
                <h2 class="page-heading">Dropzone save <span id="counter"></span></h2>
                <form method="post" action="{{ route('dropzone.store') }}"
                      enctype="multipart/form-data" class="dropzone" id="my-dropzone">
                    {{ csrf_field() }}
                    <div class="dz-message">
                        <div class="col-xs-8">
                            <div class="message">
                                <p>Загрузіть Ваші фото</p>
                            </div>
                        </div>
                    </div>
                    <div class="fallback">
                        <input type="file" name="file" multiple>
                    </div>
                </form>
            </div>
        </div>

        {{--Dropzone Preview Template--}}
        <div id="preview" style="display: none;">

            <div class="dz-preview dz-file-preview">
                <div class="dz-image"><img data-dz-thumbnail /></div>

                <div class="dz-details">
                    <div class="dz-size"><span data-dz-size></span></div>
                    <div class="dz-filename"><span data-dz-name></span></div>
                </div>
                <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                <div class="dz-error-message"><span data-dz-errormessage></span></div>
            </div>
        </div>

    </div>
@endsection
@section('js')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="{{ url('/js/dropzone.js') }}"></script>
    <script src="{{ url('/js/dropzone-config.js')  }}"></script>
    <script src="{{ url('/js/custom.js')  }}"></script>

@endsection
