@include('header')
<body>
    <input type="text" id="roleCook" value="{{ auth()->user()->checkCook() }}" hidden>
    <input type="text" id="viewWarehouseCook" value="{{ auth()->user()->viewWarehouseCook() }}" hidden>
    <input type="text" id="viewBooking" value="{{ auth()->user()->viewBooking() }}" hidden>
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
    <script type="text/javascript">
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
    <script type="text/javascript">
        const roleCook = JSON.parse(document.getElementById('roleCook').value);
        var notifyWrapper = $('.notificationNewDishForCook');
        var notifyToggle = notifyWrapper.find('a[data-toggle]');
        var notifyCountElem = notifyToggle.find('i[data-count]');
        var notifyCount = parseInt(notifyCountElem.data('count'));
        var listNotificationsNewDish = notifyWrapper.find('ul.dropdown-menu.notificationNewDish');

        Pusher.logToConsole = true;
        var pusher = new Pusher('cc6422348edc9fbaff00', {
            cluster: 'ap1'
        });

        let channel = pusher.subscribe('NotifyCook');
        channel.bind('notify-cook', function(data){
            var existingNotifications = listNotificationsNewDish.html();
            if(roleCook.length > 0){
                let color = "";
                if(data.idCook == 1){
                    color = "alert-danger";
                }else if(data.idCook == 2){
                    color = "alert-success";
                }else{
                    color = "alert-info";
                }
                var newNotifications =
                `<li>
                    <audio autoplay> <source src="{{ asset('audio/tingting.mp3') }}"></audio>
                    <div class="alert `+ color +` clearfix">
                        <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                            <div class="noti-info">`;
                                if(data.idCook == 1){
                                    newNotifications += `<a href="{{ route('cook_screen.detail',['id' => 1]) }}"> Bếp `+ data.idCook +` có món mới: `+ data.nameDish +`</a>`;
                                }else if(data.idCook == 2){
                                    newNotifications += `<a href="{{ route('cook_screen.detail',['id' => 2]) }}"> Bếp `+ data.idCook +` có món mới: `+ data.nameDish +`</a>`;
                                }else{
                                    newNotifications += `<a href="{{ route('cook_screen.detail',['id' => 3]) }}"> Bếp `+ data.idCook +` có món mới: `+ data.nameDish +`</a>`;
                                }
                        newNotifications +=`</div>
                    </div>
                </li>`;
                listNotificationsNewDish.html(newNotifications);
                listNotificationsNewDish.html(existingNotifications + newNotifications);
                notifyCount += 1;
                notifyCountElem.attr('data-count',notifyCount);
                notifyWrapper.find('.notify-count-new-dish').text(notifyCount);
                notifyWrapper.show();
            }
        });
    </script>
    <script type="text/javascript">
        const roleViewBooking = JSON.parse(document.getElementById('viewBooking').value);
        var notificationWrapperBooking = $('.notificationBooking');
        var notificationToggleBooking = notificationWrapperBooking.find('a[data-toggle]');
        var notificationCountElemBooking = notificationToggleBooking.find('i[data-count]');
        var notificationCountBooking = parseInt(notificationCountElemBooking.data('count'));
        var notificationsBooking = notificationWrapperBooking.find('ul.dropdown-menu.inbox');

        Pusher.logToConsole = true;
        var pusher = new Pusher('cc6422348edc9fbaff00', {
            cluster: 'ap1'
        });
        let channel3 = pusher.subscribe('Booking');

        channel3.bind('book-table', function(data){
            if(roleViewBooking.length > 0){
                var titleNotificationBooking = notificationsBooking.find('.title-notify-booking').html();
                var seeAllNotificationBooking = notificationsBooking.find('.see-all-booking').html();

                var avatar = Math.floor(Math.random() * (71 - 20 + 1)) + 20;
                var newNotifications =
                    `<li>
                        <audio autoplay><source src="{{ asset('audio/ting.mp3') }}"></audio>
                        <a href="{{ route('booking.index') }}">
                            <span class="photo"><img alt="avatar" src="https://api.adorable.io/avatars/71/`+avatar+`.png"></span>
                            <span class="subject">
                                <span class="from">` + data.email + `</span>
                                <span class="time">` + data.time +`</span>
                            </span>
                            <span class="message">
                                Đặt bàn vào ngày `+ data.dateBooking +`
                            </span>
                        </a>
                    </li>`;
                notificationsBooking.html(newNotifications);
                notificationsBooking.html(titleNotificationBooking + newNotifications + seeAllNotificationBooking);
                notificationCountBooking += 1;
                notificationCountElemBooking.attr('data-count',notificationCountBooking);
                notificationWrapperBooking.find('.notif-count-booking').text(notificationCountBooking);
                notificationWrapperBooking.show();
            }
        });
    </script>
@include('footer')
