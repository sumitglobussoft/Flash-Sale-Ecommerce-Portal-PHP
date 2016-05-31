<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="/assets/home/js/jquery-ui.1.11.3.min.js"></script>
<script src="/assets/home/js/jquery.min.js"></script>
<script src="/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
{{--<script type="text/javascript" src="/assets/home/js/main.js"></script>--}}
<script src="/assets/plugins/toastr/toastr.min.js"></script>
<script>
    $(document).ready(function(){
        $('#login-trigger').click(function(){
            $(this).next('#login-content').slideToggle();
            $(this).toggleClass('active');

            if ($(this).hasClass('active')) $(this).find('span').html('&#x25B2;')
            else $(this).find('span').html('&#x25BC;')
        })
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".dropdown").hover(
                function() {
                    $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true, true).slideDown("fast");
                    $(this).toggleClass('open');
                },
                function() {
                    $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true, true).slideUp("fast");
                    $(this).toggleClass('open');
                }
        );
    });
</script>


