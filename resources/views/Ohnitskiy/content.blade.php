<hr>
<div class="container">
    @include(config("settings.theme").'.add_watermark')
</div>
<hr>
<div class="container">
    @include(config("settings.theme").'.loaded_foto')
    <div class="modal" id="Modal">

        <span class="close">&times;</span>
        <img class="modal-content" id="img">
        <div id="caption"></div>

    </div>
</div>