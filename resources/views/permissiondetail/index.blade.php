@extends('layouts')
@section('content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Phân quyền
            </div>
            <div class="portlet box green-meadow" style="margin-top: 20px;">
                    <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i>
                                Thêm mới quyền </div>
                        </div>
                        <div class="portlet-body">
                            <div class="form">
                                <form class="panel-body"
                                    id="createNews-form" action="{{ route('perdetail.p_store') }}" method="POST">
                                    @csrf
                                    <div class="row margin-top">
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">
                                                Action Name <span style="color: #ff0000"> *</span>
                                            </label>
                                            <div class="col-md-7">
                                                <input type="text" size="40" class="form-control"
                                                    required="required" name="action_name"
                                                    maxlength="255">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="submit" style="margin-top:0" class="btn green-meadow radius" name="yt0"
                                                value="Tạo mới">
                                            </div>
                                            <div class="errorMessage" id="ShopCustomer_name_em_"
                                                style="display:none">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-coffee"></i>
                        Danh sách chi tiết quyền</div>
                </div>
                <div class="portlet-body">
                        <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">STT</th>
                                            <th scope="col">Action Name</th>
                                            {{-- <th scope="col">Permission Name</th> --}}
                                            <th scope="col">Action Code</th>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                            </tr>
                                    </thead>
                                    <tbody>
                                        @if($permissionDetails)
                                            @foreach($permissionDetails as $key => $item)
                                            <tr>
                                                <th scope="row">{{ $key + 1}}</th>
                                                <td>{{ $item->name}}</td>
                                                {{-- <td>{{ $item->permission->name}}</td> --}}
                                                 <td>{{ $item->action_code}}</td>
                                                <td>
                                                    <a href="{{ route('perdetail.update',['id'=>$item->id]) }}" class="btn default btn-xs yellow-crusta radius"><i
                                                        class="fa fa-edit"> Cập nhật</i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{route('perdetail.delete',['id' => $item->id])}}" class="btn default btn-xs red radius">
                                                        <i class="fa fa-trash-o"> Xóa</i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                        </div>
                        <footer class="panel-footer">
                                <div class="row">
                                  <div class="col-sm-5 text-center">
                                    <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
                                  </div>
                                  <div class="col-sm-7 text-right text-center-xs">
                                      {{  $permissionDetails->links()  }}
                                  </div>
                                </div>
                        </footer>
                </div>
             </div>
            </div>
        </div>
    </div>
@endsection
