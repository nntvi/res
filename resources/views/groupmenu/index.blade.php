@extends('layouts')
@section('content')
<div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
            Responsive Table
            </div>
            <div class="row w3-res-tb">
            <div class="col-sm-5 m-b-xs">
                <div class="form-group">
                    <form action="" method="post">
                        <div class="input-group m-bot15">
                            <input type="text" class="form-control">
                            <span class="input-group-btn">
                                <button class="btn btn-success" type="button">Tìm kiếm</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-4">
                <span class="error-message">{{ $errors->first('name') }}</span></p>
                <span class="error-message">{{ $errors->first('idCook') }}</span></p>
                <span class="error-message">{{ $errors->first('nameGroupArea') }}</span></p>
            </div>
            <div class="col-sm-3 ">
                <div class="row text-right">
                    <a href="#myModal-1" data-toggle="modal" class="btn btn-info text-right" style="margin-right: 10px">
                        Thêm mới
                    </a>
                </div>
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal-1" class="modal fade" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                    <h4 class="modal-title">Thêm mới Nhóm thực đơn</h4>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal" role="form"  action="{{route('groupmenu.store')}}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">
                                                Tên
                                            </label>
                                            <div class="col-lg-10">
                                                <input type="text" class="form-control" name="name">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                                <label class="col-lg-2 col-sm-2 control-label">Chọn bếp</label>
                                                <div class="col-lg-10">
                                                    @foreach ($cook_active as $item)
                                                        <label class="checkbox-inline">
                                                            <input type="radio" id="cook{{$item->id}}" value="{{$item->id}}"  name="idCook"> {{$item->name}}
                                                        </label>

                                                    @endforeach
                                                </div>
                                            </div>
                                        <div class="form-group">
                                            <div class="col-lg-offset-2 col-lg-10 text-right">
                                                <button type="submit" class="btn btn-default">Thêm mới</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>
            </div>
            </div>
            <div class="table-responsive">
                    <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead style="background: lightyellow;">
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên nhóm thực đơn</th>
                                        <th class="text-center">Thuộc bếp</th>
                                        <th>Cập nhật</th>
                                        <th>Xóa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($groupmenus as $key => $groupmenu)
                                    <tr>
                                            <td width="5%">{{$key+1}}</td>
                                            <form method="post" action="{{route('groupmenu.update',['id' => $groupmenu->id])}}">
                                                @csrf
                                                <td width="20%">
                                                    <input width="18%" class="form-control" type="text"
                                                        name="nameGroupArea" value="{{$groupmenu->name}}">
                                                </td>
                                                <td width="20%" class="text-center">
                                                    @foreach ($cook_active as $item)
                                                        <label style="display:inline">{{$item->name}}</label>
                                                        @if ($groupmenu->id_cook == $item->id)
                                                            <input value="{{$item->id}}" id="cook{{$item->id}}" type="radio" name="idCook" style="margin-right: 20px" checked>
                                                        @else
                                                            <input value="{{$item->id}}" id="cook{{$item->id}}" type="radio" name="idCook" style="margin-right: 20px">
                                                        @endif
                                                    @endforeach
                                                </td>
                                            <td width="10%">
                                                <button type="submit"
                                                    class="btn default btn-xs yellow-crusta radius"><i
                                                        class="fa fa-edit"> Cập nhật</i></button>
                                            </td>
                                            </form>
                                            <td width="10%">
                                                <a href="{{route('groupmenu.delete',['id' => $groupmenu->id])}}"
                                                    class="btn default btn-xs red radius" onclick="return confirm('Bạn muốn xóa dữ liệu này?')">
                                                        <i class="fa fa-trash-o"> Xóa</i>
                                                </a>
                                            </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    </div>
            </div>
            <footer class="panel-footer">
            <div class="row">

                <div class="col-sm-5 text-center">
                <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
                </div>
                <div class="col-sm-7 text-right text-center-xs">
                <ul class="pagination pagination-sm m-t-none m-b-none">
                        {{ $groupmenus->links() }}
                </ul>
                </div>
            </div>
            </footer>
        </div>
    </div>
@endsection
