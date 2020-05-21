@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Công thức tính hệ số giá bán món ăn
        </div>
        <div class="row w3-res-tb">
            <div class="col-sm-5 m-b-xs">
                <a href="{{ route('method.storeText') }}" class="btn btn-sm btn-default">
                    Thiết lập
                </a>
            </div>
            <div class="col-sm-4">
            </div>
            <div class="col-sm-3">
                <div class="input-group">
                    <input type="text" class="input-sm form-control" placeholder="Search">
                    <span class="input-group-btn">
                        <button class="btn btn-sm btn-default" type="button">Go!</button>
                    </span>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead style="background: #faf7f8;">
                    <tr>
                        <th>STT</th>
                        <th class="text-center">Công thức bằng chữ</th>
                        <th class="text-center">Công thức bằng số</th>
                        <th class="text-center">Kết quả</th>
                        <th class="text-center">Trạng thái</th>
                        <th style="width:30px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($methods as $key => $method)
                        <tr>
                            <td rowspan="2" style="line-height: 70px">{{ $key + 1 }}</td>
                            <td class="text-center">
                                {{ $method->textTuso }}
                            </td>
                            <td class="text-center">
                                {{ $method->tuso }}
                            </td>
                            <td class="text-center" rowspan="2" style="line-height: 70px">
                                {{ $method->result }}
                            </td>
                            <td rowspan="2" style="line-height: 70px" class="text-center">
                                @if ($method->status == '1')
                                   <span style="color:red">Đang được sử dụng</span>
                                @else
                                    <span>Chưa đc sử dụng</span>
                                @endif
                            </td>
                            <td rowspan="2">
                                @if ($method->status == '1')
                                @else
                                    <a href="{{ route('method.update',['id' => $method->id ]) }}" class="active" ui-toggle-class="" onclick="return confirm('Bạn muốn kích hoạt công thức này?')">
                                        <i class="fa fa-check text-success text-active"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                {{ $method->textMauso }}
                            </td>
                            <td class="text-center">
                                {{ $method->mauso }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <footer class="panel-footer">
            <div class="row">

                <div class="col-sm-5 text-center">
                    <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
                </div>
                <div class="col-sm-7 text-right text-center-xs">
                    <ul class="pagination pagination-sm m-t-none m-b-none">
                        <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
                        <li><a href="">1</a></li>
                        <li><a href="">2</a></li>
                        <li><a href="">3</a></li>
                        <li><a href="">4</a></li>
                        <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
</div>
@endsection
