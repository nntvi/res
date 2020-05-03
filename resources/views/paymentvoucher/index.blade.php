@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Responsive Table
        </div>
        <div class="row w3-res-tb">
            <div class="col-sm-5 m-b-xs">
                <a href="#myModal" data-toggle="modal" class="btn btn-success">
                    Tạo mới
                </a>
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal"
                    class="modal fade" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                <h4 class="modal-title">Chọn đối tượng chi</h4>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('paymentvoucher.p_object') }}" method="GET">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-xs-6">
                                            <div class="col-xs-1">
                                                <input type="radio" name="object" value="1">
                                            </div>
                                            <div class="col-xs-9">
                                                <label for="">Trả nợ nhà cung cấp</label>
                                            </div>
                                        </div>
                                        <div class="col-xs-4">
                                            <div class="col-xs-1">
                                                <input type="radio" name="object" value="2">
                                            </div>
                                            <div class="col-xs-9">
                                                <label for="">Khác</label>
                                            </div>
                                        </div>
                                        <div class="col-xs-2">
                                            <button type="submit" class="btn btn-danger">Chọn</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
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
                        <th style="width:20px;">
                            <label class="i-checks m-b-none">
                                <input type="checkbox"><i></i>
                            </label>
                        </th>
                        <th>Project</th>
                        <th>Task</th>
                        <th>Date</th>
                        <th style="width:30px;"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                        <td>Idrawfast prototype design prototype design prototype design prototype design prototype
                            design</td>
                        <td><span class="text-ellipsis">{item.PrHelpText1}</span></td>
                        <td><span class="text-ellipsis">{item.PrHelpText1}</span></td>
                        <td>
                            <a href="" class="active" ui-toggle-class=""><i
                                    class="fa fa-check text-success text-active"></i><i
                                    class="fa fa-times text-danger text"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                        <td>Formasa</td>
                        <td>8c</td>
                        <td>Jul 22, 2013</td>
                        <td>
                            <a href="" ui-toggle-class=""><i class="fa fa-check text-success text-active"></i><i
                                    class="fa fa-times text-danger text"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                        <td>Avatar system</td>
                        <td>15c</td>
                        <td>Jul 15, 2013</td>
                        <td>
                            <a href="" class="active" ui-toggle-class=""><i
                                    class="fa fa-check text-success text-active"></i><i
                                    class="fa fa-times text-danger text"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                        <td>Throwdown</td>
                        <td>4c</td>
                        <td>Jul 11, 2013</td>
                        <td>
                            <a href="" class="active" ui-toggle-class=""><i
                                    class="fa fa-check text-success text-active"></i><i
                                    class="fa fa-times text-danger text"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                        <td>Idrawfast</td>
                        <td>4c</td>
                        <td>Jul 7, 2013</td>
                        <td>
                            <a href="" class="active" ui-toggle-class=""><i
                                    class="fa fa-check text-success text-active"></i><i
                                    class="fa fa-times text-danger text"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                        <td>Formasa</td>
                        <td>8c</td>
                        <td>Jul 3, 2013</td>
                        <td>
                            <a href="" class="active" ui-toggle-class=""><i
                                    class="fa fa-check text-success text-active"></i><i
                                    class="fa fa-times text-danger text"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                        <td>Avatar system</td>
                        <td>15c</td>
                        <td>Jul 2, 2013</td>
                        <td>
                            <a href="" class="active" ui-toggle-class=""><i
                                    class="fa fa-check text-success text-active"></i><i
                                    class="fa fa-times text-danger text"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                        <td>Videodown</td>
                        <td>4c</td>
                        <td>Jul 1, 2013</td>
                        <td>
                            <a href="" class="active" ui-toggle-class=""><i
                                    class="fa fa-check text-success text-active"></i><i
                                    class="fa fa-times text-danger text"></i></a>
                        </td>
                    </tr>
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
@endsection
