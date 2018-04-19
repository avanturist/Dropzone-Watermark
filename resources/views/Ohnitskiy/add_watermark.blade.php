<h3>Фото з водяним знаком</h3>
<form action="{{ route('home') }}" method="post" enctype="multipart/form-data" >
    {{ csrf_field() }}
    <div class="form-group">
        <div class="form-group">
            <label for="img">Фото - на якому буде розміщено водяний знак</label>
            <input type="file" name="img" class="form-control" multiple id="img" >
        </div>

        @if(session('status'))
            <p class="alert alert-danger">{{ session('status') }}</p>
        @endif

        <div class="form-group">
            <label for="watermark">Фото - буде використане як 'водяний знак' (<i>формат - / .png /</i>)</label>
            <input type="file" name="watermark" class="form-control"  id="watermark" >

        </div>

        @if(session('watermark'))
            <p class="alert alert-danger">{{ session('watermark') }}</p>
        @endif

        <div class="form-group">
            <label for="foto">
                <input type="checkbox" name="foto" value="foto" id="foto"> - Вставка фото як водяний знак</label>
        </div>
        <div class="form-group">
            <label for="text">
                <input type="checkbox" name="text" value="text" id="text"> - Вставка тексту як водяний знак на фото</label>
            <input type="text" name="textmark" placeholder="Введіть тект який буде накладено на фото" class="form-control">

        </div>
    </div>
    <input type="submit" value="Зберегти" class="btn btn-success">

</form>
<script>

</script>