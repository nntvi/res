@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Công thức tính hệ số giá bán món ăn
        </div>
        <div class="row w3-res-tb">
            <div class="col-sm-5 m-b-xs">
                <a href="#myModal" data-toggle="modal" class="btn btn-sm btn-default">
                    Tạo mới
                </a>
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                    <h4 class="modal-title">Tạo công thức tính hệ số giá bán</h4>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('method.storyQty') }}" method="get">
                                        @csrf
                                        <div class="form-group row">
                                            <div class="col-xs-6">
                                                <label>Số lượng phần tử trên tử</label>
                                                <input type="number" class="form-control" name="qtyTu" required>
                                            </div>
                                            <div class="col-xs-6">
                                                <label>Số lượng phần tử dưới mẫu</label>
                                                <input type="number" class="form-control" name="qtyMau" required>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-default">Tạo</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="col-sm-4">
                    <script>
                            @if($errors->any())
                                @foreach($errors->all() as $error)
                                    toastr.error('{{ $error }}')
                                @endforeach
                            @endif
                            @if(session('success'))
                                toastr.success('{{ session('success') }}')
                            @endif
                            @if(session('warning'))
                                toastr.warning('{{ session('warning') }}')
                            @endif
                    </script>
            </div>
            <div class="col-sm-3">
                {{--  <div class="input-group">
                    <input type="text" class="input-sm form-control" placeholder="Search">
                    <span class="input-group-btn">
                        <button class="btn btn-sm btn-default" type="button">Go!</button>
                    </span>
                </div>  --}}
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
                                    <a href="{{ route('method.delete',['id' => $method->id ]) }}" class="active" ui-toggle-class="" onclick="return confirm('Bạn muốn xóa công thức này?')">
                                            <i class="fa fa-times text-danger"></i>
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
                    <small class="text-muted inline m-t-sm m-b-sm">hiển thị 1-5 công thức</small>
                </div>
                <div class="col-sm-7 text-right text-center-xs">
                    <ul class="pagination pagination-sm m-t-none m-b-none">
                        {{ $methods->links() }}
                    </ul>
                </div>
            </div>
        </footer>
    </div>
</div>
@endsection
