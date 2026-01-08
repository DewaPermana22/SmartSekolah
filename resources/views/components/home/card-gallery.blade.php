@props(['img' => '', 'title' => '', 'date' => ''])

<div class="card-gallery-home">
    <img src="{{ asset($img) }}" alt="Galeri Image"/>
    <div class="content-card-gallery-home">
    <div class="text-card-gallery-home">
        <h3>{{ $title }}</h3>
        <p>{{ $date }}</p>
    </div>

    <div id="maximize-gallery-card" class="group">@include('_home.icons.maximize')</div>
    </div>

</div>