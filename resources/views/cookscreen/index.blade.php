@extends('layouts')
@section('content')
<div class="row">
        <div class="typo-agile">
                <h2 class="w3ls_head">Khu Vực Bếp</h2>
                <hr style="border-top: 5px solid #c1bcca;">
                <div class="panel panel-default">
                    @foreach ($result as $rs)
                            @if($rs->action_code == "COOK_1")
                                @foreach ($cooks as $cook)
                                    @if($cook->id == 1)
                                    <div class="panel-heading">
                                        <a href="{{ route('cook_screen.detail',['id' => $cook->id]) }}">{{ $cook->name }}</a>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                            @if($rs->action_code == "COOK_2")
                                @foreach ($cooks as $cook)
                                    @if($cook->id == 2)
                                    <div class="panel-heading">
                                        <a href="{{ route('cook_screen.detail',['id' => $cook->id]) }}">{{ $cook->name }}</a>
                                    </div>
                                    @endif
                                @endforeach
                            @endif

                            @if($rs->action_code == "COOK_3")
                                @foreach ($cooks as $cook)
                                    @if($cook->id == 2)
                                    <div class="panel-heading">
                                        <a href="{{ route('cook_screen.detail',['id' => $cook->id]) }}">{{ $cook->name }}</a>
                                    </div>
                                    @endif
                                @endforeach
                            @endif
                    @endforeach

                    <div class="space"></div>
                </div>
        </div>
</div>
@endsection
