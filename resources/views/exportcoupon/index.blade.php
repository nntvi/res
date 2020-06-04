@extends('layouts')
@section('content')
<div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Các Phiếu Xuất Kho
            </div>
            <div class="row w3-res-tb">
            <div class="col-sm-4 m-b-xs">
                <a class="agile-icon icon-box " href="{{route('warehouse.index')}}">
                    <i class="fa fa-mail-reply"></i>
                    Trở về
                    <span class="text-muted">
                    (Trang kho)
                    </span>
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
                            @if ($exportCoupon->typeExport->id == 1)
                                @foreach ($exportCoupon->detailExportCoupon as $item)
                                    {{ $item->cook->name }}
                                    @break;
                                @endforeach
                            @endif
                            @if ($exportCoupon->typeExport->id == 2)
                                @foreach ($exportCoupon->detailExportCoupon as $item)
                                    {{ $item->supplier->name }}
                                    @break;
                                @endforeach
                            @endif
                        </td>
                        <td>{{$exportCoupon->note}}</td>
                        <td>{{$exportCoupon->created_at}}</td>
                        <td>{{$exportCoupon->created_by}}</td>
                        <td><a href="{{route('exportcoupon.detail',['id' => $exportCoupon->id])}}">Xem chi tiết</a></td>
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
@endsection
