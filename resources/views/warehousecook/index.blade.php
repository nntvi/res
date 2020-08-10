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
                                        <input class="date form-control" name="dateStart" type="text" id="dateStart" required>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-3">
                                    <div class="form-group ">
                                        <label class="control-label">Đến ngày:</label>
                                        <input class="date form-control" name="dateEnd" type="text" id="dateEnd" required>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-3">
                                    <div class="form-group ">
                                        <label class="control-label">Chọn bếp:</label>
                                        <select name="cook" id="" class="form-control">
                                            @foreach ($cooks as $cook)
                                                <option value="{{ $cook->id }}">{{ $cook->status == '1' ? $cook->name : $cook->name . '( ngưng hoạt động)'}}</option>
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
                                        if(dateStart > dateEnd){
                                            alert("Ngày bắt đầu không nhỏ hơn ngày kết thúc");
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
                            <div class="space"></div>
                                <div>
                                        <table class="table table-striped b-t b-light" id="example{{ $cookwarehouse->id }}">
                                              <thead>
                                                <tr>
                                                  <th>STT</th>
                                                  <th>Tên Nguyên Vật liệu</th>
                                                  <th>Số lượng hiện có</th>
                                                  <th>Đơn vị</th>
                                                  <th>Ngày cập nhật</th>
                                                  <th></th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                                @php $stt = 0; @endphp
                                                @foreach ($cookwarehouse->warehouseCook as $warehouseCook)
                                                    @if ($warehouseCook->detailMaterial != null)
                                                        @php ++$stt @endphp
                                                        @if ($warehouseCook->status == '0')
                                                                <tr style="background: #fbff0094">
                                                                    <td>{{ $stt }}</td>
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
                                                                    <td class="text-right" style="color:red;font-weight: bold">Cần nhập thêm</td>
                                                                </tr>
                                                            @else
                                                                <tr>
                                                                    <td>{{ $stt }}</td>
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
                @if(session('success'))
                    toastr.success('{{ session('success') }}')
                @endif
                @if(session('info'))
                    toastr.info('{{ session('info') }}')
                @endif
        </script>
        <script type="text/javascript" language="javascript" src="{{ asset('js/data.table.js') }}"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
        <script>
            $(document).ready( function () {
                @foreach($cookWarehouse as $cookwarehouse)
                    $("table[id^='example{{ $cookwarehouse->id }}']").dataTable();
                @endforeach
                $('#example_info').addClass('text-muted');
                $('input[type="search"]').addClass('form-control');
                @foreach($cookWarehouse as $cookwarehouse)
                    $("#example{{ $cookwarehouse->id  }}_length").html(
                        `<a href="{{ route('exportcoupon.destroywarehousecook',['id' => $cookwarehouse->id]) }}" class="btn btn-sm btn-default">
                            Hủy NVL
                        </a>`
                    );
                @endforeach
            });
        </script>
        <!-- page end-->
    </div>
@endsection
