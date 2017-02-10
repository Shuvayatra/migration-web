<!-- footer content -->
<footer class="clearfix">
    <div class="pull-right">
       Shuvayatra {{date('Y')}}
    </div>
</footer>
<!-- /footer content -->

<script type="text/javascript">
    var app_url = "{{url("/")}}";
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', {{env('GOOGLE_ANALYTICS_KEY','')}}]);
    _gaq.push(['_trackPageview']);
    (function () {
        var ga = document.createElement('script');
        ga.type = 'text/javascript';
        ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';

        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(ga, s);
    })();
</script>
