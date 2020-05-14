<!--header start-->
<style>

@-webkit-keyframes my {
    0% { color: red; }
    50% { color: #450a0a;  }
    100% { color: red;  }
}
@-moz-keyframes my {
    0% { color: red;  }
    50% { color: #450a0a;  }
    100% { color: red;  }
}
@-o-keyframes my {
    0% { color: red; }
    50% { color: #450a0a; }
    100% { color: red;  }
}
@keyframes my {
    0% { color: red;  }
    50% { color: #450a0a;  }
    100% { color: red;  }
}
.test {
    font-size:14px;
    font-weight:bold;
    -webkit-animation: my 700ms infinite;
    -moz-animation: my 700ms infinite;
    -o-animation: my 700ms infinite;
    animation: my 700ms infinite;
}

</style>
<header class="header fixed-top clearfix">
    <!--logo start-->
    <div class="brand">
        <a href="index.html" class="logo">
            RESTAUR_T
        </a>
        <div class="sidebar-toggle-box">
            <div class="fa fa-bars"></div>
        </div>
    </div>
    <!--logo end-->
    <div class="nav notify-row" id="top_menu">
        <!--  notification start -->
        <ul class="nav top-menu">
            <!-- settings start -->
            <li class="dropdown notificationOutOfStockCook">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#notifications-panel">
                    <i class="fa fa-tasks" data-count="0"></i>
                    <span class="badge bg-success notif-count">0</span>
                </a>
                <ul class="dropdown-menu extended tasks-bar ">
                    <li>
                        <p class="">Bạn vừa nhận <span class="notif-count">0</span> thông báo từ bếp</p>
                    </li>
                </ul>
            </li>
            <!-- settings end -->
            <!-- inbox dropdown start-->
            <li id="header_inbox_bar" class="dropdown notificationBooking">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <i class="fa fa-envelope-o" data-count="0"></i>
                    <span class="badge bg-important notif-count-booking">0</span>
                </a>
                <ul class="dropdown-menu extended inbox">
                    <div class="title-notify-booking">
                        <li>
                            <p class="red">Bạn có <span class="notif-count-booking">0</span> thông báo đặt bàn</p>
                        </li>
                    </div>
                    <div class="see-all-booking">
                        <li>
                            <a href="{{ route('booking.index') }}">Xem tất cả tin đặt bàn</a>
                        </li>
                    </div>
                </ul>
            </li>
            <!-- inbox dropdown end -->
            <!-- notification dropdown start-->
            <li id="header_notification_bar" class="dropdown notificationNewDishForCook">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#" id="notification_cook">
                    <i class="fa fa-bell-o" data-count="0"></i>
                    <span class="badge bg-warning notify-count-new-dish">0</span>
                </a>
                <ul class="dropdown-menu extended notificationNewDish">
                    <li>
                        <p>Thông báo có món mới cho bếp</p>
                    </li>

                </ul>
            </li>
            <!-- notification dropdown end -->
        </ul>
        <!--  notification end -->
    </div>
    <div class="top-nav clearfix">
        <!--search & user info start-->
        <ul class="nav pull-right top-menu">
            <li>
                {{-- <input type="text" class="form-control search" placeholder=" Search"> --}}
                @if (auth()->user()->notifyQtyOfCook() != null)
                    <div class="alert alert-warning" role="alert" style="margin-bottom: 0px">
                        <strong class="test"> Có {{ auth()->user()->notifyQtyOfCook() }} NVL cần nhập gấp cho bếp </strong>
                    </div>
                @else

                @endif

            </li>
            <!-- user login dropdown start-->
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <img alt="" src="images/2.png">
                    <span class="username">{{ auth()->user()->name }}</span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">
                    <li><a href="#"><i class=" fa fa-suitcase"></i>Profile</a></li>
                    <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                  document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                            <i class="fa fa-key"></i></a></li>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                        style="display: none;">
                        @csrf
                    </form>
                </ul>
            </li>
            <!-- user login dropdown end -->

        </ul>
        <!--search & user info end-->
    </div>
</header>
<!--header end-->
