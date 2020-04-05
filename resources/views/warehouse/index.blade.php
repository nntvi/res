@extends('layouts')
@section('content')
<div class="form-w3layouts">
    <h2 class="w3ls_head">Kho</h2>
    <div class="row">
        <div class="box_content">
            <div class="icon-box col-md-3 col-sm-4">
                <a class="agile-icon" href="{{ route('importcoupon.import') }}">
                    <i class="fa fa-tasks"></i> Nhập kho
                </a>
            </div>
            <div class="icon-box col-md-3 col-sm-4">
                <a class="agile-icon" href="{{ route('importcoupon.index') }}">
                    <i class="fa fa-wpforms">
                    </i> Xem Phiếu Nhập
                </a>
            </div>
            <div class="icon-box col-md-3 col-sm-4">
                <a class="agile-icon" href="#myModal" data-toggle="modal">
                    <i class="fa fa-stack-overflow">
                    </i> Xuất kho
                </a>
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal"
                    class="modal fade" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                <h4 class="modal-title">Chọn loại xuất</h4>
                            </div>
                            <div class="modal-body">
                                <form role="form" action="{{ route('exportcoupon.export') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="radio">
                                            <div class="col-xs-3">
                                                <label>
                                                    <input type="radio" name="optionsRadios" id="optionsRadios1"
                                                        value="1" checked="">
                                                    Xuất Bếp
                                                </label>
                                            </div>
                                            <div class="col-xs-3">
                                                <label>
                                                    <input type="radio" name="optionsRadios" id="optionsRadios2"
                                                        value="2" checked="">
                                                    Xuất Trả hàng
                                                </label>
                                            </div>
                                            <div class="col-xs-3">
                                                <label>
                                                    <input type="radio" name="optionsRadios" id="optionsRadios3"
                                                        value="3" checked="">
                                                    Xuất Hủy
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="space"></div>
                                        <div class="col-xs-12 position-center">
                                            <button type="submit" class="btn btn-default">Chọn</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="icon-box col-md-3 col-sm-4">
                <a class="agile-icon" href="{{ route('exportcoupon.index') }}">
                    <i class="fa fa-wpforms">
                    </i> Xem Phiếu Xuất
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <section class="panel">
            <div class="panel-body">
                <div class="space"></div>
                <form action="{{ route('reportwarehouse.p_report') }}" method="post"
                    onsubmit="return validateForm()">
                    @csrf
                    <div class="row">
                        <div class="col-xs-12 col-sm-4">
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-3">Báo cáo theo</label>
                                <div class="col-lg-9">
                                    <select class="form-control m-bot15" id="timeReport">
                                        <option value="1">Theo ngày</option>
                                        <option value="2">Theo tuần</option>
                                        <option value="3">Theo tháng</option>
                                        <option value="4">Theo năm</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-3">Từ ngày:</label>
                                <div class="col-lg-9">
                                    <input class="date form-control" name="dateStart" type="text" id="dateStart">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-3">Đến ngày:</label>
                                <div class="col-lg-9">
                                    <input class="date form-control" name="dateEnd" type="text" id="dateEnd">
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
                    </div>
                    <div class="space"></div>
                    <div class="space"></div>
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
    @foreach($types as $type)
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        {{ $type->name }}
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            {{-- <a class="fa fa-cog" href="javascript:;"></a> --}}
                            {{-- <a class="fa fa-times" href="javascript:;"></a> --}}
                        </span>
                    </header>
                    <div class="panel-body">
                        <div>
                            <table class="table" ui-jq="footable" ui-options="{
                                              &quot;paging&quot;: {
                                                &quot;enabled&quot;: true
                                              },
                                              &quot;filtering&quot;: {
                                                &quot;enabled&quot;: true
                                              },
                                              &quot;sorting&quot;: {
                                                &quot;enabled&quot;: true
                                              }}">
                                <thead>
                                    <tr>
                                        <th data-breakpoints="xs">STT</th>
                                        <th>Tên Nguyên Vật liệu</th>
                                        <th>Số lượng hiện có</th>
                                        <th data-breakpoints="xs">Đơn vị</th>
                                        <th data-breakpoints="xs sm md" data-title="DOB">Date of Birth</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($type->warehouse as $key => $detail)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $detail->detailMaterial->name }}</td>
                                            <td>{{ $detail->qty }}</td>
                                            @if($detail->unit == null)
                                                <td>--- Hàng mới --</td>
                                            @else
                                                <td>{{ $detail->unit->name }}</td>
                                            @endif

                                            <td></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </section>
            </div>
        </div>
    @endforeach

    <!-- page end-->
</div>
@endsection
