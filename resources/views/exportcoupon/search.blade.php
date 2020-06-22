@extends('layouts')
@section('content')
<div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Các Phiếu Xuất Kho
            </div>
            <div class="row w3-res-tb">
                    <div class="col-sm-5 m-b-xs">
                        <a href="{{ route('importcoupon.index') }}" class="btn btn-sm btn-default">Trở về</a>
                    </div>
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-3">
                        <form action="{{ route('exportcoupon.search') }}" method="get">
                            @csrf
                            <div class="input-group">
                                <input type="text" class="input-sm form-control" name="searchExC" required>
                                <span class="input-group-btn">
                                    <button class="btn btn-sm btn-default" type="submit">Tìm kiếm</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã phiếu</th>
                    <th>Loại xuất</th>
                    <th>Đối tượng xuất</th>
                    <th>Ghi chú</th>
                    <th>Ngày tạo</th>
                    <th>Người tạo</th>
                    <th>Chi tiết</th>
                </tr>
                </thead>
                <tbody>
                   @foreach ($exportCoupons as $key => $exportCoupon)
                   <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$exportCoupon->code}}</td>
                        <td>{{$exportCoupon->typeExport->name}}</td>
                        <td>
                            @foreach ($exportCoupon->detailExportCoupon as $item)
                                {{ $item->name_object }}
                                @break
                            @endforeach
                        </td>
                        <td>{{$exportCoupon->note}}</td>
                        <td>{{$exportCoupon->created_at}}</td>
                        <td>{{$exportCoupon->created_by}}</td>
                        <td>
                            <a href="#export{{ $exportCoupon->id }}" data-toggle="modal">Xem chi tiết</a>
                            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"
                                    id="export{{ $exportCoupon->id }}" class="modal fade" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close"
                                                    type="button">×</button>
                                                <h4 class="modal-title">Chi tiết phiếu xuất {{ $exportCoupon->code }} <button style="background: white;
                                                    border: none;" onclick="printJS({ printable: 'printExportCoupon{{ $exportCoupon->id }}', type: 'html', header: 'Restaurant' })">
                                                        <i class="fa fa-print text-danger" aria-hidden="true"></i>
                                                    </button> </h4>
                                            </div>
                                            <div class="modal-body" id="printExportCoupon{{ $exportCoupon->id }}">
                                                <div class="titleImportCoupon">
                                                    <div class="leftTitle">
                                                        Đối tượng: <span class="bold">@foreach ($exportCoupon->detailExportCoupon as $item)
                                                                {{ $item->name_object }}
                                                                @break
                                                            @endforeach</span>
                                                        - Ghi chú: <span class="bold">{{ $exportCoupon->note }}</span>
                                                    </div>
                                                    <br>
                                                    <div class="rightTittle">
                                                        Người tạo: {{ $exportCoupon->created_by }} - Ngày tạo: <span class="bold">{{ $exportCoupon->created_at }}</span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="bs-docs-example">
                                                            <table class="table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>STT</th>
                                                                        <th>Tên mặt hàng</th>
                                                                        <th>Số lượng xuất</th>
                                                                        <th>Đơn vị tính</th>
                                                                        {{--  <th style="width:30px;"></th>  --}}
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($exportCoupon->detailExportCoupon as $key => $detail)
                                                                        {{--  <form role="form" action="{{route('importcoupon.p_detail',['id' => $detail->id])}}" method="POST">
                                                                            @csrf  --}}
                                                                            <tr>
                                                                                <td>{{$key+1}}</td>
                                                                                <td>{{ $detail->materialDetail->name }}</td>
                                                                                <td>{{ $detail->qty }}</td>
                                                                                <td>{{ $detail->unit->name}}</td>
                                                                                {{--  <td><input type="number" min="0" value="{{ $detail->price }}" name="price"></td>
                                                                                <td>
                                                                                    <button type="submit"><i class="fa fa-pencil text-success"></i></button>
                                                                                </td>  --}}
                                                                            </tr>

                                                                        {{--  </form>  --}}
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
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
            <footer class="panel-footer">
            <div class="row">

                <div class="col-sm-5 text-center">
                <small class="text-muted inline m-t-sm m-b-sm">{{ $count }} kết quả được tìm thấy</small>
                </div>
                <div class="col-sm-7 text-right text-center-xs">
                <ul class="pagination pagination-sm m-t-none m-b-none">
                    {{--  {{ $exportCoupons->links() }}  --}}
                </ul>
                </div>
            </div>
            </footer>
        </div>
    </div>
<script>
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
</script>
<div class="clearfix"></div>
@endsection
