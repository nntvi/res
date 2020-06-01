<!--header start-->
<style>
    .badge {
        padding: 2px 6px;
    }

    @-webkit-keyframes my {
        0% {
            color: red;
        }

        50% {
            color: #450a0a;
        }

        100% {
            color: red;
        }
    }

    @-moz-keyframes my {
        0% {
            color: red;
        }

        50% {
            color: #450a0a;
        }

        100% {
            color: red;
        }
    }

    @-o-keyframes my {
        0% {
            color: red;
        }

        50% {
            color: #450a0a;
        }

        100% {
            color: red;
        }
    }

    <blade keyframes|%20my%20%7B>0% {
        color: red;
    }

    50% {
        color: #450a0a;
    }

    100% {
        color: red;
    }
    }

    .test {
        font-size: 13.5px;
        font-weight: bold;
        -webkit-animation: my 700ms infinite;
        -moz-animation: my 700ms infinite;
        -o-animation: my 700ms infinite;
        animation: my 700ms infinite;
    }

    .test1 {
        font-size: 13.5px;
        font-weight: bold;
        -webkit-animation: my1 700ms infinite;
        -moz-animation: my1 700ms infinite;
        -o-animation: my1 700ms infinite;
        animation: my1 700ms infinite;
    }

    @-webkit-keyframes my1 {
        0% {
            color: black;
        }

        50% {
            text-decoration: underline;
        }

        100% {
            color: black;
        }
    }

    @-moz-keyframes my1 {
        0% {
            color: black;
        }

        50% {
            text-decoration: underline;
        }

        100% {
            color: black;
        }
    }

    @-o-keyframes my1 {
        0% {
            color: black;
        }

        50% {
            text-decoration: underline;
        }

        100% {
            color: black;
        }
    }

    <blade keyframes|%20my1%20%7B>0% {
        color: black;
    }

    50% {
        text-decoration: underline;
    }

    100% {
        color: black;
    }
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
            <li class="notificationWhCook">
                @if(auth()->user()->notifyQtyWarehouse() != null)
                    <div class="alert alert-success" role="alert" style="margin-bottom: 0px; padding: 5px 5px">
                        <strong class="test1">Có {{ auth()->user()->notifyQtyWarehouse() }} NVL trong kho sắp hết
                        </strong>
                    </div>
                @else

                @endif
            </li>
            <li class="notificationWhCook">
                @if(auth()->user()->notifyQtyOfCook() != null)
                    <div class="alert alert-warning" role="alert" style="margin-bottom: 0px; padding: 5px 5px">
                        <strong class="test"> Có {{ auth()->user()->notifyQtyOfCook() }} NVL cần nhập gấp cho bếp
                        </strong>
                    </div>
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
            @if(auth()->user()->checkOpenDay() == false)
                <li><a href="{{ route('day.open') }}"
                        style="background: yellow; padding: 7px 10px; color: black; font-size: 14px;"><i class="fa fa-lightbulb-o"></i> Khai ca</a>
                </li>
            @endif
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <img alt="" src="images/2.png">
                    <span class="username">{{ auth()->user()->name }}</span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">
                    @if (auth()->user()->checkOpenDay() == true)
                        @if(auth()->user()->checkCloseDay() == false)
                        <li><a href="{{ route('day.close') }}"
                                style="background: #ffaf8c; font-weight: bold;"><i class="fa fa-lock"></i> Chốt
                                ca</a></li>
                        @else

                        @endif
                    @else

                    @endif

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
