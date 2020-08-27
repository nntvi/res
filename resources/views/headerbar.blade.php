<!--header start-->
<style>
    .badge {
        padding: 2px 6px;
    }
    @-webkit-keyframes my {
        0% { color: red; }
        50% { color: #450a0a;  }
        100% { color: red;  }
    }
    @-moz-keyframes my {
        0% { color: red; }
        50% { color: #450a0a;  }
        100% { color: red;  }
    }
    @-o-keyframes my {
        0% { color: red; }
        50% { color: #450a0a;  }
        100% { color: red;  }
    }
    @keyframes my {
        0% { color: red; }
        50% { color: #450a0a;  }
        100% { color: red;  }
    }
    .test {
        font-size:13px;
        font-weight:bold;
        -webkit-animation: my 700ms infinite;
        -moz-animation: my 700ms infinite;
        -o-animation: my 700ms infinite;
        animation: my 700ms infinite;
    }
    .test1 {
        font-size: 13px;
        font-weight: bold;
        -webkit-animation: my1 700ms infinite;
        -moz-animation: my1 700ms infinite;
        -o-animation: my1 700ms infinite;
        animation: my1 700ms infinite;
    }
    @-webkit-keyframes my1 {
        0% { color: black; }
        50% { text-decoration: underline;  }
        100% {  color: black; }
    }
    @-moz-keyframes my1 {
        0% { color: black; }
        50% { text-decoration: underline;  }
        100% {  color: black; }
    }
    @-o-keyframes my1 {
        0% { color: black; }
        50% { text-decoration: underline;  }
        100% {  color: black; }
    }
    @keyframes my1 {
        0% { color: black; }
        50% { text-decoration: underline;  }
        100% {  color: black; }
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
            <li id="header_inbox_bar" class="dropdown notificationFinishDish">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <i class="fa fa-coffee" data-count="0"></i>
                    <span class="badge bg-important notif-count-finish-dish">0</span>
                </a>
                <ul class="dropdown-menu extended finishDish inbox">
                    <div class="title-notify-finish-dish">
                        <li>
                            <p>Thông báo trạng thái các món</p>
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

                @foreach (json_decode(auth()->user()->checkCook()) as $item)
                    @if ($item == "XEM_BEP1")
                        <ul class="dropdown-menu extended notificationNewDish1">
                            <li>
                                <p>Thông báo có món mới cho bếp</p>
                            </li>

                        </ul>
                    @endif
                    @if ($item == "XEM_BEP2")
                        <ul class="dropdown-menu extended notificationNewDish2">
                            <li>
                                <p>Thông báo có món mới cho bếp</p>
                            </li>

                        </ul>
                    @endif
                    @if ($item == "XEM_BEP3")
                        <ul class="dropdown-menu extended notificationNewDish3">
                            <li>
                                <p>Thông báo có món mới cho bếp</p>
                            </li>

                        </ul>
                    @endif
                @endforeach
            </li>

            <!-- notification dropdown end -->
        </ul>
        <!--  notification end -->
    </div>
    <div class="top-nav clearfix">
        <!--search & user info start-->
        <ul class="nav pull-right top-menu">
            <li class="notificationWhCook">
                @if(auth()->user()->notifyQtyOfCook() != null)
                    <div class="alert alert-warning" role="alert" style="margin-bottom: 0px; padding: 5px 5px; margin-top: 2px">
                        <strong class="test"> Có {{ auth()->user()->notifyQtyOfCook() }} NVL bếp cần nhập gấp </strong>
                    </div>
                @else

                @endif
            </li>
            <li class="notificationWhCook">
                @if(auth()->user()->notifyQtyWarehouse() != null)
                    <a href="{{ route('warehouse.index') }}" class="alert alert-success" role="alert" style="background: orange; margin-bottom: 0px; padding: 5px 5px; margin-top: 2px">
                        <strong class="test1" style="color:white">Có {{ auth()->user()->notifyQtyWarehouse() }} NVL trong kho sắp hết
                        </strong>
                    </a>
                @else

                @endif
            </li>
            {{--  <script type="text/javascript">
                var notificationsWrapper   = $('.top-menu');
                var notifications          = notificationsWrapper.find('li.notificationWhCook');

                Pusher.logToConsole = true;
                var pusher = new Pusher('cc6422348edc9fbaff00', {
                    cluster: 'ap1'
                });

                let channel5 = pusher.subscribe('NotifyOutOfStock');
                channel5.bind('need-import-cook', function(data){
                        console.log(data.cook);
                        var newNotifications =
                                `<div class="alert alert-warning" role="alert" style="margin-bottom: 0px;">
                                    <strong class="test"> Có `+ data.cook +` NVL cần nhập gấp cho bếp </strong>
                                </div>`;
                        notifications.html(newNotifications);
                        notificationsWrapper.show();
                });
            </script>  --}}
            <!-- user login dropdown start-->
            @if (auth()->user()->checkAdmin(auth()->user()->id) == true)
                @if(auth()->user()->checkOpenDay() == false)
                    <li><a href="{{ route('day.open') }}"
                        style="background: yellow; padding: 7px 10px; color: black; font-size: 14px;"><i class="fa fa-lightbulb-o"></i> Khai ca</a>
                    </li>
                @endif
            @endif
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <img alt="" src="images/2.png">
                    <span class="username">{{ auth()->user()->name }}</span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">
                    @if (auth()->user()->checkAdmin(auth()->user()->id) == true)
                        @if (auth()->user()->checkOpenDay() == true)
                            @if(auth()->user()->checkCloseDay() == false)
                            <li><a href="{{ route('day.close') }}"
                                    style="background: #ffaf8c; font-weight: bold;"><i class="fa fa-lock"></i> Chốt
                                    ca</a></li>
                            @endif
                        @endif
                    @endif
                    <li>
                        <a href="{{ route('user.updatepassword',['id' => auth()->user()->id]) }}">
                            <i class="fa fa-key"></i> Đổi mật khẩu
                        </a>
                    </li>
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                  document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out"></i>{{ __('Đăng xuất') }}
                        </a>
                    </li>

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
