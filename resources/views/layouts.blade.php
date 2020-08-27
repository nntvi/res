@include('header')
<body>
    <input type="text" id="roleCook" value="{{ auth()->user()->checkCook() }}" hidden>
    <input type="text" id="viewWarehouseCook" value="{{ auth()->user()->viewWarehouseCook() }}" hidden>
    <input type="text" id="finishDish" value="{{ auth()->user()->fisnishDish() }}" hidden>
    <section id="container">
        @include('headerbar')
        @include('sidebar')
        <!--main content start-->
            <section id="main-content">
                <section class="wrapper">
                    @yield('content')
                </section>
                <!-- footer -->

                <!-- / footer -->
            </section>
        <!--main content end-->
    </section>
    <script>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}');
            @endforeach
        @endif
    </script>
    <script>
        const roleViewWarehouseCook = JSON.parse(document.getElementById('viewWarehouseCook').value);
        var notificationsWrapper   = $('.notificationOutOfStockCook');
        var notificationsToggle    = notificationsWrapper.find('a[data-toggle]');
        var notificationsCountElem = notificationsToggle.find('i[data-count]');
        var notificationsCount     = parseInt(notificationsCountElem.data('count'));
        var notifications          = notificationsWrapper.find('ul.dropdown-menu.tasks-bar');

        Pusher.logToConsole = true;
        var pusher = new Pusher('cc6422348edc9fbaff00', {
            cluster: 'ap1'
        });

        let channel2 = pusher.subscribe('NotifyOutOfStock');
        channel2.bind('need-import-cook', function(data){
            var existingNotifications = notifications.html();
                if(roleViewWarehouseCook.length > 0){
                    //alert(JSON.stringify(data));
                    var newNotifications =
                    `<li>
                        <a href="{{ route('warehousecook.index') }}">
                            <audio autoplay >
                                <source src="{{ asset('audio/bip.mp3') }}">
                            </audio>
                            <div class="task-info clearfix">
                                <div class="desc pull-left">
                                    <h5>Bếp ` + data.idCook + `</h5>
                                    <p>Cần nhập thêm ` + data.material +`</p>
                                </div>
                            </div>
                        </a>
                    </li>`;
                    notifications.html(newNotifications);
                    notifications.html(existingNotifications + newNotifications);
                    notificationsCount += 1;
                    notificationsCountElem.attr('data-count', notificationsCount);
                    notificationsWrapper.find('.notif-count').text(notificationsCount);
                    notificationsWrapper.show();
            }
        });
    </script>
    <script>
        const roleCook = JSON.parse(document.getElementById('roleCook').value);
        var c1 = 0, c2 = 0, c3 = 0;
        var i;
        var notifyWrapper = $('.notificationNewDishForCook');
        var notifyToggle = notifyWrapper.find('a[data-toggle]');
        var notifyCountElem = notifyToggle.find('i[data-count]');
        var notifyCount = parseInt(notifyCountElem.data('count'));
        async function RenderInbox(){

        }
        for (i = 0; i < roleCook.length; i++) {
            if(roleCook[i] == "XEM_BEP1"){
                c1 = 1;
                var listNotificationsNewDish = notifyWrapper.find('ul.dropdown-menu.notificationNewDish1');
            }else if(roleCook[i] == "XEM_BEP2"){
                c2 = 2;
                var listNotificationsNewDish = notifyWrapper.find('ul.dropdown-menu.notificationNewDish2');
            }else if(roleCook[i] == "XEM_BEP3"){
                c3 = 3;
                var listNotificationsNewDish = notifyWrapper.find('ul.dropdown-menu.notificationNewDish3');
            }
        }

        Pusher.logToConsole = true;
        var pusher = new Pusher('cc6422348edc9fbaff00', {
            cluster: 'ap1'
        });

        var countC1 = 0, countC2 = 0, countC3 = 0;
        let channel = pusher.subscribe('NotifyCook');
        channel.bind('notify-cook', function(data){
            if(data.type == '1'){
                if(data.idCook == c1){
                    var existingNotifications = listNotificationsNewDish.html();
                    countC1 = countC1 + 1;
                    var newNotifications1 =
                    `<li>
                        <audio autoplay> <source src="{{ asset('audio/ting.mp3') }}"></audio>
                        <div class="alert alert-danger clearfix">
                            <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                                <div class="noti-info">
                                    <a href="{{ route('cook_screen.detail',['id' => 1]) }}" style="color:red;"> Bếp `+ data.idCook +` : `+ data.nameDish +`</a>
                                </div>
                        </div>
                    </li>`;
                    listNotificationsNewDish.html(newNotifications1);
                    listNotificationsNewDish.html(existingNotifications + newNotifications1);
                    notifyCountElem.attr('data-count',countC1);
                    notifyWrapper.find('.notify-count-new-dish').text(countC1);
                    notifyWrapper.show();
                }else if(data.idCook == c2){
                    countC2 = countC2 + 1;
                    var existingNotifications = listNotificationsNewDish.html();
                    var newNotifications2 =
                    `<li>
                        <audio autoplay> <source src="{{ asset('audio/ting.mp3') }}"></audio>
                        <div class="alert alert-success clearfix">
                            <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                                <div class="noti-info">
                                    <a href="{{ route('cook_screen.detail',['id' => 2]) }}" style="color:red;"> Bếp `+ data.idCook +` : `+ data.nameDish +`</a>
                                </div>
                        </div>
                    </li>`;
                    listNotificationsNewDish.html(newNotifications2);
                    listNotificationsNewDish.html(existingNotifications + newNotifications2);
                    notifyCountElem.attr('data-count',countC2);
                    notifyWrapper.find('.notify-count-new-dish').text(countC2);
                    notifyWrapper.show();
                }
                else if(data.idCook == c3){
                    countC3 = countC3 + 1;
                    var existingNotifications = listNotificationsNewDish.html();
                    var newNotifications3 =
                    `<li>
                        <audio autoplay> <source src="{{ asset('audio/ting.mp3') }}"></audio>
                        <div class="alert alert-info clearfix">
                            <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                                <div class="noti-info">
                                    <a href="{{ route('cook_screen.detail',['id' => 3]) }}" style="color:red;"> Bếp `+ data.idCook +` : `+ data.nameDish +`</a>
                                </div>
                        </div>
                    </li>`;
                    listNotificationsNewDish.html(newNotifications3);
                    listNotificationsNewDish.html(existingNotifications + newNotifications3);
                    notifyCountElem.attr('data-count',countC3);
                    notifyWrapper.find('.notify-count-new-dish').text(countC3);
                    notifyWrapper.show();
                }
            }
            else if(data.type == '0'){
                if(data.idCook == c1){
                    countC1 = countC1 + 1;
                    var existingNotifications = listNotificationsNewDish.html();
                    var newNotifications1 =
                    `<li>
                            <audio autoplay> <source src="{{ asset('audio/ting.mp3') }}"></audio>
                                <div class="alert alert-danger clearfix">
                                    <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                                        <div class="noti-info">
                                            <a href="{{ route('cook_screen.detail',['id' => 1]) }}" style="color:red;"> Bếp `+ data.idCook +` : `+ data.nameDish +`</a>
                                        </div>
                                </div>
                    </li>`;
                    listNotificationsNewDish.html(newNotifications1);
                    listNotificationsNewDish.html(existingNotifications + newNotifications1);
                    notifyCountElem.attr('data-count',countC1);
                    notifyWrapper.find('.notify-count-new-dish').text(countC1);
                    notifyWrapper.show();
                }else if(data.idCook == c2){
                    countC2 = countC2 + 1;
                    var existingNotifications = listNotificationsNewDish.html();
                    var newNotifications2 =
                    `<li>
                            <audio autoplay> <source src="{{ asset('audio/ting.mp3') }}"></audio>
                                <div class="alert alert-danger clearfix">
                                    <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                                        <div class="noti-info">
                                            <a href="{{ route('cook_screen.detail',['id' => 2]) }}" style="color:red;"> Bếp `+ data.idCook +` hủy: `+ data.nameDish +`</a>
                                        </div>
                                </div>
                    </li>`;
                    listNotificationsNewDish.html(newNotifications2);
                    listNotificationsNewDish.html(existingNotifications + newNotifications2);
                    notifyCountElem.attr('data-count',countC2);
                    notifyWrapper.find('.notify-count-new-dish').text(countC2);
                    notifyWrapper.show();
                }else if(data.idCook == c3){
                    countC3 = countC3 + 1;
                    var existingNotifications = listNotificationsNewDish.html();
                    var newNotifications3 =
                    `<li>
                            <audio autoplay> <source src="{{ asset('audio/ting.mp3') }}"></audio>
                                <div class="alert alert-danger clearfix">
                                    <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                                        <div class="noti-info">
                                            <a href="{{ route('cook_screen.detail',['id' => 3]) }}" style="color:red;"> Bếp `+ data.idCook +` hủy: `+ data.nameDish +`</a>
                                        </div>
                                </div>
                    </li>`;
                    listNotificationsNewDish.html(newNotifications3);
                    listNotificationsNewDish.html(existingNotifications + newNotifications3);
                    notifyCountElem.attr('data-count',countC3);
                    notifyWrapper.find('.notify-count-new-dish').text(countC3);
                    notifyWrapper.show();
                }
            }
        });
    </script>
    <script type="text/javascript">
        const roleOrder = JSON.parse(document.getElementById('finishDish').value);
        var notificationWrapperFinishDish = $('.notificationFinishDish');
        var notificationToggleFinishDish = notificationWrapperFinishDish.find('a[data-toggle]');
        var notificationCountElemFinishDish = notificationToggleFinishDish.find('i[data-count]');
        var notificationCountFinishDish = parseInt(notificationCountElemFinishDish.data('count'));
        var notificationsFinishDish = notificationWrapperFinishDish.find('ul.dropdown-menu.finishDish');

        Pusher.logToConsole = true;
        var pusher = new Pusher('cc6422348edc9fbaff00', {
            cluster: 'ap1'
        });
        let channel3 = pusher.subscribe('FinishDish');

        channel3.bind('finish-dish', function(data){
            if(roleOrder.length > 0){
                var titleNotificationFinishDish = notificationsFinishDish.html();
                var newNotifications =
                    `<li>
                        <audio autoplay><source src="{{ asset('audio/tingting.mp3') }}"></audio>
                        <a href="{{ route('order.index') }}">
                            <span class="photo"><img alt="avatar" src="img/`+ data.imgDish +`"></span>
                            <span class="subject">
                            <span class="from">`+ data.nameDish +`</span>
                                <span class="time">`+ data.nameTable +`</span>
                            </span>`;
                                if(data.stt == '-1'){
                                    newNotifications += `<span class="message" style="color: red;">Số lượng ` + data.qty + ` - Bếp `+ data.idCook +` không đủ NVL thực hiện </span>`;
                                }else if(data.stt == '-3'){
                                    newNotifications += `<span class="message" style="color: red;">Số lượng ` + data.qty + ` - Kho không đủ NVL thực hiện </span>`;
                                }else if(data.stt == '2'){
                                    newNotifications += `<span class="message">Số lượng: ` + data.qty + ` - Bếp `+ data.idCook +` đã hoàn thành </span>`;
                                }
    newNotifications += `</a>
                    </li>`;
                    notificationsFinishDish.html(newNotifications);
                    notificationsFinishDish.html(titleNotificationFinishDish + newNotifications);
                    notificationCountFinishDish += 1;
                    notificationCountElemFinishDish.attr('data-count',parseInt(notificationCountFinishDish));
                    notificationWrapperFinishDish.find('span.notif-count-finish-dish').text(notificationCountFinishDish);
                    notificationWrapperFinishDish.show();
            }
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#header_inbox_bar').click(function() {
                $('span.notif-count-finish-dish').text(0);
            });
        })
    </script>
@include('footer')
