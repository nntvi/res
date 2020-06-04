@extends('layouts')
@section('content')
<div class="form-w3layouts">
    <h2 class="w3ls_head">Kho Bếp</h2>
        <div class="row">
            <section class="panel" style="margin: 1em;">
                <div class="panel-body">
                    <div class="space"></div>
                        <form action="{{ route('warehousecook.report') }}" method="post" onsubmit="return validateForm()">
                            @csrf
                            <div class="row">
                                <div class="col-xs-6 col-sm-3">
                                    <div class="form-group ">
                                        <label class="control-label">Báo cáo theo</label>
                                                <select class="form-control" id="timeReport">
                                                        <option value="0">Hôm nay</option>
                                                        <option value="1">Hôm qua</option>
                                                        <option value="2">Tuần này</option>
                                                        <option value="3">Tuần trước</option>
                                                        <option value="4">Tháng này</option>
                                                        <option value="5">Tháng trước</option>
                                                        <option value="6">Quý này</option>
                                                        <option value="7">Quý trước</option>
                                                        <option value="8">Năm nay</option>
                                                </select>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-3">
                                    <div class="form-group ">
                                        <label class="control-label">Từ ngày:</label>
                                        <input class="date form-control" name="dateStart" type="text" id="dateStart">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-3">
                                    <div class="form-group ">
                                        <label class="control-label">Đến ngày:</label>
                                        <input class="date form-control" name="dateEnd" type="text" id="dateEnd">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-3">
                                    <div class="form-group ">
                                        <label class="control-label">Chọn bếp:</label>
                                        <select name="cook" id="" class="form-control">
                                            @foreach ($cooks as $cook)
                                                <option value="{{ $cook->id }}">{{ $cook->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <script type="text/javascript">
                                    $('.date').datepicker({
                                        format: 'yyyy-mm-dd'
                                    });

                                    function validateForm() {
                                        var dateStart = document.getElementById('dateStart').value;
                                        var dateEnd = document.getElementById('dateEnd').value;

                                        if (dateStart == null || dateStart == "") {
                                            alert("Không để trống ngày bắt đầu");
                                            return false;
                                        }
                                        if (dateEnd == null || dateEnd == "") {
                                            alert("Không để trống ngày kết thúc");
                                            return false;
                                        }
                                        return true;
                                    }
                                </script>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 text-center">
                                    <button type="submit" class="btn green-meadow radius">Tìm kiếm</button>
                                </div>
                            </div>
                    </form>
                </div>
            </section>
        </div>
        <!-- page start-->
        @foreach ($cookWarehouse as $cookwarehouse)
        <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            {{ $cookwarehouse->name }}
                            <span class="tools pull-right">
                                <a class="fa fa-chevron-down" href="javascript:;"></a>
                             </span>
                        </header>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12 text-right">
                                    <a href="{{ route('exportcoupon.destroywarehousecook',['id' => $cookwarehouse->id]) }}" class="btn btn-danger">
                                        Hủy NVL
                                    </a>
                                </div>
                            </div>
                            <div class="space"></div>
                                <div class="table-responsive">
                                        <table class="table table-striped b-t b-light">
                                              <thead>
                                                <tr>
                                                  <th>STT</th>
                                                  <th>Tên Nguyên Vật liệu</th>
                                                  <th>Số lượng hiện có</th>
                                                  <th>Đơn vị</th>
                                                  <th>Ngày cập nhật</th>
                                                  <th>Tình trạng</th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                                @foreach ($cookwarehouse->warehouseCook as $key => $warehouseCook)
                                                @if ($warehouseCook->status == '0')
                                                    <tr style="background: #fbff0094">
                                                        <td>{{$key+1}}</td>
                                                        <td>{{$warehouseCook->detailMaterial->name}}</td>
                                                        <td>{{$warehouseCook->qty}}</td>
                                                        <td>
                                                            @if ($warehouseCook->unit == null)
                                                                Rỗng
                                                            @else
                                                            {{$warehouseCook->unit->name}}
                                                            @endif
                                                        </td>
                                                        <td>{{$warehouseCook->updated_at}}</td>
                                                        <td style="color:red;font-weight: bold">Cần nhập thêm</td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td>{{$key+1}}</td>
                                                        <td>{{$warehouseCook->detailMaterial->name}}</td>
                                                        <td>{{$warehouseCook->qty}}</td>
                                                        <td>
                                                            @if ($warehouseCook->unit == null)
                                                                Rỗng
                                                            @else
                                                            {{$warehouseCook->unit->name}}
                                                            @endif
                                                        </td>
                                                        <td>{{$warehouseCook->updated_at}}</td>
                                                        <td> </td>
                                                    </tr>
                                                @endif
                                                @endforeach
                                              </tbody>
                                        </table>
                                    </div>
                        </div>
                    </section>
                </div>
            </div>
        @endforeach
        <script>
                @if($errors->any())
                    @foreach($errors->all() as $error)
                        toastr.error('{{ $error }}')
                    @endforeach
                @endif
                @if(session('success'))
                    toastr.success('{{ session('success') }}')
                @endif
                @if(session('info'))
                    toastr.info('{{ session('info') }}')
                @endif
        </script>
        <!-- page end-->
    </div>
@endsection
