    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/jquery.dcjqaccordion.2.7.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('js/jquery.nicescroll.js') }}"></script>
    <!-- morris JavaScript -->
    <script>
        $(document).ready(function () {
            //BOX BUTTON SHOW AND CLOSE
            jQuery('.small-graph-box').hover(function () {
                jQuery(this).find('.box-button').fadeIn('fast');
            }, function () {
                jQuery(this).find('.box-button').fadeOut('fast');
            });
            jQuery('.small-graph-box .box-close').click(function () {
                jQuery(this).closest('.small-graph-box').fadeOut(200);
                return false;
            });

            //CHARTS
            function gd(year, day, month) {
                return new Date(year, month - 1, day).getTime();
            }
        });

    </script>
    <!-- calendar -->
    {{-- <script type="text/javascript" src="{{ asset('js/monthly.js') }}">
    </script> --}}
</body>

</html>
