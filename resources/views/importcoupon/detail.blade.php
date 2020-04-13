@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        @foreach ($importCoupon as $item)
            <div class="panel-heading">
                Chi tiết Phiếu Nhập {{ $item->code }}
            </div>
            <div class="bs-example">
					<table class="table">
						<tbody>
							<tr>
								<td><h6>Ngày Nhập: {{$item->created_at}}</h6></td>
								<td class="type-info text-right">
                                    <div class="icon-box">
                                        <a class="agile-icon" href="{{route('importcoupon.print_detail',['id' => $item->id])}}">
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
                        <th>Số lượng nhập</th>
                        <th>Đơn vị tính</th>
                        <th>Giá nhập</th>
                        <th style="width:30px;"></th>
                    </tr>
                </thead>
                <tbody>
                        @foreach ($item->detailImportCoupon as $key => $detail)
                        <tr data-expanded="true">
                            <td>{{$key+1}}</td>
                            <td>{{ $detail->materialDetail->name }}</td>
                            <td>{{ $detail->qty }}</td>
                            <td>{{ $detail->unit->name}}</td>
                            <td>{{ number_format($detail->price) . ' đ'}}</td>
                            <td>
                                <a href="#myModal{{$detail->id}}" data-toggle="modal" class="active" ui-toggle-class="">
                                    <i class="fa fa-pencil-square-o text-success text-active"></i>
                                </a>
                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal{{$detail->id}}" class="modal fade">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                    <h4 class="modal-title">Cập nhật chi tiết mặt hàng</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form role="form" action="{{route('importcoupon.p_detail',['id' => $detail->id])}}" method="POST">
                                                        @csrf
                                                        <div class="form-group">
                                                            <div class="col-xs-12">
                                                                <label>Tên mặt hàng</label>
                                                                <input type="text" class="form-control" value="{{ $detail->materialDetail->name }}" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-xs-6">
                                                                <div class="space"></div>
                                                                <label >Số lượng nhập</label>
                                                                <input type="number" class="form-control" value="{{ $detail->qty }}" name="qty" disabled>
                                                            </div>
                                                            <div class="col-xs-6">
                                                                <div class="space"></div>
                                                                <label >Đơn vị tính</label>
                                                                <input class="form-control" value="{{ $detail->unit->name }}" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-xs-12">
                                                                <label>Giá nhập</label>
                                                                <input type="number" class="form-control" value="{{ $detail->price }}" name="price">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xs-12 text-center">
                                                                    <div class="space"></div>
                                                                    <button type="submit" class="btn btn-default">Submit</button>
                                                            </div>

                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        @endforeach
    </div>
</div>
@endsection
