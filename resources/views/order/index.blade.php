@include('staff.header')
<div class="header-cashier">
		<div class="container-fluid">
			<div class="row ft-tabs">
				<div class="col-md-3">
					<ul class="tabs-list">
						<li><a href="#" class="active" data="listtable" onclick="event.preventDefault()">Phòng Bàn</a></li>
						<li><a href="#" data="pos" onclick="event.preventDefault()">Thực đơn</a></li>
					</ul>
				</div>
				<div class="col-md-4 cashier-search">
					<input type="text" name="txtnamemenu" id="search-menu" placeholder="Nhập tên món ăn cần tìm" class="form-control">
					<div id="result-menu-post">

					</div>
                </div>

			</div>
		</div>
	</div>
<div class="container-fluid">
    <div class="row content">
        <div class="col-md-6" id="table-list">
            <div class="row list-filter">
                <div class="col-md list-filter-content">
                    @foreach ($areas as $area)
                        <button value="{{$area->id}}"
                        class="btn btn-primary idArea">{{$area->name}}</button>
                    @endforeach
                </div>
            </div>
            <div class="row table-list">
                <div class="col-md table-list-content" >
                    <ul id="table"
                    >
                        {{-- @foreach ($tables as $table)
                            <li>
                                <a href="{{$table->id}}">{{$table->name}}</a>
                            </li>
                        @endforeach --}}
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6" id="pos" hidden="true">
            <div class="row list-filter">
                <div class="col-md list-filter-content">
                    <button class="btn btn-primary active" onclick="">Tất Cả</button>
                            <button class="btn btn-primary active" onclick="">
                                CateName
                            </button>
                </div>
            </div>
            <div class="row product-list">
                <div class="col-md product-list-content">
                    <ul>
                                <li><a href="#" title="NameMenu">
                                <div class="img-product">
                                    <img src="">
                                </div>
                                <div class="product-info">
                                    <span class="product-name">NameMenu</span><br>
                                    <strong>Price></strong>
                                </div>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 content-listmenu" id="content-listmenu">
            <div class="row" id="bill-info">
                <div class="col-md-2 table-infor">
                    <a name="" id="" class="btn btn-primary" href="#" role="button">Bàn 01</a>
                </div>
                <div class="col-md-5">
                    <div class="col-md-12 p-0 input-group">
                        <input type="text" id="customer-infor" placeholder="Tìm khách hàng" class="form-control">
                        <div class="input-group-append">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#ModelAddcustomer"><i class="fa fa-plus" aria-hidden="true"></i></button>
                          </div>
                        <div id="result-customer"></div>
                        <span class="del-customer"></span>
                    </div>
                </div>
                <div class="col-md-5">
                    <select class="form-control">
                        <option value="1">Bảng giá chung</option>
                    </select>
                </div>
            </div>
            <div class="row bill-detail">
                <div class="col-md-12 bill-detail-content">
                    <table class="table table-bordered">
                      <thead class="thead-light">
                        <tr>
                          <th scope="col">STT</th>
                          <th scope="col">Tên món</th>
                          <th scope="col">Số lượng</th>
                          <th scope="col">Gía bán</th>
                          <th scope="col">Ghi chú</th>
                        </tr>
                      </thead>
                      <tbody id="pro_search_append">
                        <tr>
                            <td scope="col">1</td>
                            <td scope="col">Súp bí</td>
                            <td class="text-center sellinput" width="150">
                                <div class="input-group"><span class="input-group-addon themecolor"
                                    ng-click="reduceQItem(dataItem)">&nbsp;<i class="fa fa-minus">
                                        </i>&nbsp;</span><input type="text" class="text-right form-control txtQuantity ng-pristine ng-untouched ng-valid ng-not-empty"
                                         ng-model="dataItem.Quantity" select-on-focus=""
                                          ui-numeric=""><span class="input-group-addon themecolor"
                                          ng-click="increasingQItem(dataItem)">&nbsp;<i class="fa fa-plus"></i>&nbsp;&nbsp;
                                        </div>
                            </td>
                            <td scope="col">20.000đ</td>
                            <td scope="col">Ít đường</td>
                          </tr>
                      </tbody>
                    </table>
                </div>
            </div>
            <div class="row bill-action">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12 p-1">
                            <textarea class="form-control" id="note-order" placeholder="Nhập ghi chú hóa đơn" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-xs-6 p-1">
                            <button type="button" class="btn-print" onclick="cms_save_table()"><i class="fa fa-credit-card" aria-hidden="true"></i>  Yêu cầu thanh toán </button>
                        </div>
                        <div class="col-md-6 col-xs-6 p-1">
                            <button type="button" class="btn-pay" onclick="cms_save_oder()"><i class="fa fa-arrows-alt" aria-hidden="true"></i>  Chuyển bàn </button>
                        </div>
                    </div>
                 </div>
                 <div class="col-md-6">
                    <div class="row">
                        <button type="button" class="btn-send-cashier" style="height: 85px;
                        margin-top: 4px;" onclick="cms_save_table()"><i class="fa fa-credit-card" aria-hidden="true"></i> Gửi Thực Đơn (F9)</button>

                    </div>
                 </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="alert-login">
</div>
<div class="modal fade" id="ModelAddcustomer" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">
  <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">
    ...
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary">Save changes</button>
  </div>
</div>
</div>
</div>
</body>
</html>
