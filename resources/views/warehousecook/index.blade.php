@extends('layouts')

@section('content')
<div class="form-w3layouts">
    <div class="box_content">
        <div class="icon-box col-md-3 col-sm-4">
            <a class="agile-icon" href="{{route('warehousecook.reset')}}"
            onclick="return confirm('Bạn có thật sự muốn reset kho bếp?')">
                <i class="fa fa-undo"></i> Reset Kho Bếp
            </a>
        </div>
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

        <!-- page end-->
    </div>
@endsection
