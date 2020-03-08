@extends('layouts')
@section('content')
<div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Chi tiết quyền
            </div>
            <div class="row w3-res-tb">
            <div class="col-sm-3">
            </div>
            <div class="col-sm-6">
                <form class="panel-body"
                    id="createNews-form" action="{{ route('perdetail.p_store') }}" method="POST">
                    @csrf
                    <div class="input-group">
                    <input type="text" class="input-sm form-control" name="action_name">
                    <span class="input-group-btn">
                        <button class="btn btn-sm btn-default" type="submit">Thêm mới</button>
                    </span>
                    </div>
                    <span class="error-message">{{ $errors->first('action_name') }}</span></p>
                </form>
            </div>
            </div>
            <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                    <thead >
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">Action Name</th>
                                {{-- <th scope="col">Permission Name</th> --}}
                                <th scope="col">Action Code</th>
                                <th scope="col">Cập nhật</th>
                                <th scope="col">Xóa</th>
                                </tr>
                        </thead>
                <tbody>
                        <tbody>
                                @if($permissionDetails)
                                    @foreach($permissionDetails as $key => $item)
                                    <tr>
                                        <th scope="row">{{ $key + 1}}</th>
                                        <td>{{ $item->name}}</td>
                                        {{-- <td>{{ $item->permission->name}}</td> --}}
                                         <td>{{ $item->action_code}}</td>
                                        <td>
                                            <a href="#myModal{{$item->id}}" data-toggle="modal" class="btn btn-success">
                                                    Cập nhật
                                            </a>
                                            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal{{$item->id}}" class="modal fade" style="display: none;">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                                <h4 class="modal-title">Cập nhật chi tiết tên quyền</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form role="form" id="createNews-form" action="{{route('perdetail.p_update',['id' => $item->id])}}" method="POST">
                                                                    @csrf
                                                                    <div class="form-group">
                                                                        <label>Tên quyền cũ</label>
                                                                        <input type="text" class="form-control" value="{{$item->action_code}}" disabled>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Action Name <span style="color: #ff0000"> *</span></label>
                                                                        <input type="text" size="40" class="form-control"
                                                                            required="required" name="action_name"
                                                                            maxlength="255" value="{{ $item->action_code }}">
                                                                    </div>
                                                                    <button type="submit" class="btn btn-default">Submit</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{route('perdetail.delete',['id' => $item->id])}}"
                                                    onclick="return confirm('Bạn muốn xóa dữ liệu này?')"
                                                     class="btn default btn-xs red radius">
                                                <i class="fa fa-trash-o"> Xóa</i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                </tbody>
            </table>
            </div>
            <footer class="panel-footer">
            <div class="row">

                <div class="col-sm-5 text-center">
                <small class="text-muted inline m-t-sm m-b-sm">showing 1-5 items</small>
                </div>
                <div class="col-sm-7 text-right text-center-xs">
                        {{  $permissionDetails->links()  }}
                </div>
            </div>
            </footer>
        </div>
    </div>
@endsection
