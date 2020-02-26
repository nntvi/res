@include('staff.header')
<div class="container-fluid">
		<div class="row content">
			<div class="col-md-6" id="table-list">
				<div class="row list-filter">
					<div class="col-md list-filter-content">
                        <button class="btn btn-primary">Trệt</button>
                        <button class="btn btn-primary">Lầu 1</button>
                        <button class="btn btn-primary">Lầu 2</button>
					</div>
				</div>
				<div class="row table-list">
					<div class="col-md table-list-content">
						<ul>
                            <li id="">Bàn số 1</li>
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
						      <th scope="col">Tên sản phẩm</th>
						      <th scope="col">Số lượng</th>
						      <th scope="col">Gía bán</th>
						      <th scope="col">Thành Tiền</th>
						      <th scope="col"></th>
						    </tr>
						  </thead>
						  <tbody id="pro_search_append">

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
								<button type="button" class="btn-print" onclick="cms_save_table()"><i class="fa fa-credit-card" aria-hidden="true"></i> Thanh Toán (F9)</button>
							</div>
							<div class="col-md-6 col-xs-6 p-1">
								<button type="button" class="btn-pay" onclick="cms_save_oder()"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu (F10)</button>
							</div>
                        </div>
                        <div class="row">
							<div class="col-md-6 col-xs-6 p-1">
								<button type="button" class="btn-cancel" onclick="cms_save_table()"><i class="fa fa-window-close-o" aria-hidden="true"></i> Hủy hóa đơn</button>
							</div>
							<div class="col-md-6 col-xs-6 p-1">
								<button type="button" class="btn-print-cook" onclick="cms_save_oder()"><i class="fa fa-floppy-o" aria-hidden="true"></i> In bếp</button>
							</div>
						</div>
 					</div>
 					<div class="col-md-6">
 						<div class="row form-group">
							<label class="col-form-label col-md-4"><b>Tổng cộng</b></label>
							<div class="col-md-8">
								<input type="text" value="0" class="form-control total-pay" disabled="disabled">
							</div>
						</div>
						<div class="row form-group">
							<label class="col-form-label col-md-4"><b>Khách Đưa</b></label>
							<div class="col-md-8">
								<input type="text" class="form-control customer-pay" value="0" placeholder="Nhập số điền khách đưa">
							</div>
						</div>
						<div class="row form-group">
							<label class="col-form-label col-md-4"><b>Tiền thừa</b></label>
							<div class="col-md-8 excess-cash">
								0
							</div>
                        </div>
                        <div class="row">
							<div class="col-md-6 col-xs-6 p-1">
								<button type="button" class="btn-move" onclick="cms_save_table()"><i class="fa fa-arrows-alt" aria-hidden="true"></i> Chuyển bàn</button>
							</div>
							<div class="col-md-6 col-xs-6 p-1">
								<button type="button" class="btn-combine" onclick="cms_save_oder()"><i class="fa fa-compress" aria-hidden="true"></i> Gộp bàn</button>
							</div>
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
