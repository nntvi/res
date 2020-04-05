@extends('layouts')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Nhập Kho
            </header>
            <div class="pannel-body">
                <div class="position-center">
                    <div class="form">
                        <form class="panel-body" role="form" onsubmit="return validateForm()"
                            action="{{ route('importcoupon.p_import') }}" method="POST">
                            @csrf
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label">Mã phiếu nhập<span style="color: #ff0000">
                                                *</span></label>
                                        <div class="space"></div>
                                        <input type="text" size="40" class="form-control" name="code" maxlength="200"
                                            id="codeImportCoupon">
                                        <span
                                            class="error-message">{{ $errors->first('name') }}</span>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label">Nhà cung cấp<span style="color: #ff0000">
                                                *</span></label>
                                        <div class="space"></div>
                                        <select class="form-control m-bot15" name="idSupplier" id="idSupplier">
                                            @foreach($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <label class="control-label">Ghi chú</label>
                                        <div class="space"></div>
                                        <textarea type="text" size="40" class="form-control" rows="3" name="note">
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="space"></div>
                                <div class="space"></div>
                                <div id="material">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width=25%>Tên mặt hàng</th>
                                                <th width=15%>Sl trong kho</th>
                                                <th width=22%>Sl cần nhập</th>
                                                <th width=17%>Đơn vị tính</th>
                                                <th width=20%>Tổng Giá</th>
                                                <th width=2%></th>
                                            </tr>
                                        </thead>
                                        <tbody class="list" id="myTable">

                                        </tbody>
                                        <script type="text/javascript">
                                            function clickToRemove($id) {
                                                var row = document.getElementById('row' + $id);
                                                row.remove();
                                            }
                                            function validateForm() {
                                                const code = document.getElementById('codeImportCoupon').value;
                                                var qty, price;
                                                const table = document.getElementById('myTable')
                                                const data = [];
                                                if(code == null || code == ""){
                                                    const codeError = "Không để trống mã phiếu nhập \n";
                                                    data.push(codeError);
                                                }
                                                for (var i = 0, row; row = table.rows[i]; i++) {
                                                    for (var j = 0, col; col = row.cells[j]; j++) {
                                                      if(j == 2){
                                                        $('input[type="number"].qty').each(function (index) {
                                                            if(index == i){
                                                                if ($(this).val() == null || $(this).val() == "") {
                                                                    var cot = i+1;
                                                                    var temp = "Hàng " + cot + " cột " + j + " trống sl nhập \n";
                                                                    data.push(temp);
                                                                }
                                                            }
                                                        });
                                                      }
                                                      if(j == 4){
                                                        $('input[type="number"].price').each(function (index) {
                                                            price = ($(this).val());
                                                            if(index == i){
                                                                if ($(this).val()  == null || $(this).val()  == "") {

                                                                    var cot = i+1;
                                                                    var temp = "Hàng " + cot + " cột " + j + " trống giá \n";
                                                                    data.push(temp);
                                                                }
                                                            }
                                                        });
                                                      }
                                                    }
                                                }
                                                if(data.length > 0){
                                                    alert(data);
                                                    return false;
                                                }else{
                                                    return true;
                                                }

                                            }
                                        </script>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 text-center">
                                    <button type="submit" class="btn green-meadow radius">Tạo phiếu</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
