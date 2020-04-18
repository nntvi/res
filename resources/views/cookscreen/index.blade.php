@extends('layouts')
@section('content')
<div class="gallery">
    <h2 class="w3ls_head">Màn hình bếp</h2>
    <div class="gallery-grids">
        <div class="gallery-top-grids">
            @foreach($data as $item)
                <div class="col-sm-4 gallery-grids-left">
                    <div class="gallery-grid">
                        <a class="" href="{{ route('cook_screen.detail',['id' => $item->id]) }}" data-lightbox="example-set"
                            data-title="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus vitae cursus ligula">
                            <img src="images/cook.jpg" alt="" />
                            <div class="captn">
                                <h4>{{ $item->name }}</h4>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
            <div class="clearfix"> </div>
        </div>
        {{--  <script src="js/lightbox-plus-jquery.min.js"> </script>  --}}

    </div>
</div>
@endsection
