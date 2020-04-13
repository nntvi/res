@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        @foreach ($detailExportCoupon as $item)
            <div class="panel-heading">
                Chi tiết Phiếu Xuất {{ $item->code }}
            </div>
            <div class="bs-example">
					<table class="table">
						<tbody>
							<tr>
								<td><h6>Ngày Xuất: {{$item->created_at}}</h6></td>
								<td class="type-info text-right">
                                    <div class="icon-box">
                                        <a class="agile-icon" href="{{route('exportcoupon.print_detail',['id' => $item->id])}}">
                                            <i class="fa fa-print"></i>In phiếu
                                        </a>
                                    </div>
                                </td>
							</tr>
						</tbody>
					</table>
				</div>
            <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên mặt hàng</th>
                        <th>Số lượng xuất</th>
                        <th>Đơn vị tính</th>
                        <th class="text-right">Ngày xuất</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach ($item->detailExportCoupon as $key => $detail)
                        <tr data-expanded="true">
                            <td>{{$key+1}}</td>
                            <td>{{ $detail->materialDetail->name }}</td>
                            <td>{{ $detail->qty }}</td>
                            <td>{{ $detail->unit->name}}</td>
                            <td class="text-right">{{ $detail->created_at}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        @endforeach
    </div>
</div>
@endsection
