<!--sidebar start-->
<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a href="{{ route('customer.index') }}">
                        <i class="fa fa-home"></i>
                        <span>GIao diện khách hàng</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('overview.index') }}">
                        <i class="fa fa-cubes"></i>
                        <span>Tổng quan</span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-cube"></i>
                        <span>Hàng hóa</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ route('groupmenu.index') }}">Nhóm thực đơn</a></li>
                        <li><a href="{{ route('material.index') }}">Tên món và công thức</a></li>
                        <li><a href="{{ route('material_detail.index') }}">Nguyên vật liệu</a></li>
                        <li><a href="{{ route('dishes.index') }}">Đồ uống - Món ăn</a></li>
                        {{-- <li><a href="{{route('topping.index') }}">Topping,
                            ghi chú món</a>
                        </li> --}}
                        {{-- <li><a href="{{ route('material_action.index') }}">Chi tiết NVL từng món</a>
                        </li> --}}
            </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="fa fa-users"></i>
                    <span>Phân quyền</span>
                </a>
                <ul class="sub">
                    <li><a href="{{ route('permission.index') }}">Nhóm quyền</a></li>
                    <li><a href="{{ route('perdetail.index') }}">Quyền hoạt động</a></li>
                    <li><a href="{{ route('user.index') }}">Nhân viên</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="fa fa-building-o"></i>
                    <span>Nhà hàng</span>
                </a>
                <ul class="sub">
                    <li><a href="{{ route('order.index') }}">Màn hình order</a></li>
                    <li><a href="{{ route('cook_screen.index') }}">Màn hình khu vực bếp</a></li>
                    <li><a href="{{ route('area.index') }}">Khu vực</a></li>
                    <li><a href="{{ route('table.index') }}">Phòng bàn</a></li>
                    <li><a href="{{ route('cook.index') }}">Bếp</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="fa fa-user"></i>
                    <span>Đối tác</span>
                </a>
                <ul class="sub">
                    <li><a href="{{ route('booking.index') }}">Khách hàng đặt bàn</a></li>
                    <li><a href="{{ route('supplier.index') }}">Nhà cung cấp</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="fa fa-database"></i>
                    <span>Kho</span>
                </a>
                <ul class="sub">
                    <li><a href="{{ route('warehouse.index') }}">Kho chính</a></li>
                    <li><a href="{{ route('warehousecook.index') }}">Kho bếp</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="fa fa-usd"></i>
                    <span>Sổ quỹ</span>
                </a>
                <ul class="sub">
                    <li><a href="{{ route('bill.index') }}">Danh sách hóa đơn</a></li>
                    <li><a href="{{ route('voucher.index') }}">Phiếu Thu/Chi</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="fa fa-book"></i>
                    <span>Báo cáo</span>
                </a>
                <ul class="sub">
                    <li><a href="{{ route('report.order') }}">Theo đơn hàng</a></li>
                    <li><a href="{{ route('report.table') }}">Theo bàn</a></li>
                    <li><a href="{{ route('report.dish') }}">Theo món</a></li>
                    <li><a href="thuchi.html">Thu chi</li></a>
                    <li><a href="loinhuan.html">Lợi nhuận</a></li>
                    <li><a href="congnoncc.html">Công nợ nhà cung cấp</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="fa fa-cogs"></i>
                    <span>Thiết lập</span>
                </a>
                <ul class="sub">
                    <li><a href="{{ route('shift.index') }}">Ca làm việc</a></li>
                    <li><a href="{{ route('position.index') }}">Chức vụ và tiền lương</a></li>
                    <li><a href="{{ route('method.index') }}">Hệ số giá bán</a></li>
                </ul>
            </li>
            </ul>
        </div>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
