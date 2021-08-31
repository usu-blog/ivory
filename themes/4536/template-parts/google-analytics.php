<?php
$tracking_id = (function_exists('google_analytics')) ? google_analytics() : '';
if((is_preview()||is_customize_preview()) && !google_analytics_preview_count()) $tracking_id = null;
if(is_user_logged_in() && !google_analytics_logged_in_user_count()) $tracking_id = null;
if($tracking_id) {
    if(is_amp()) { ?>
        <amp-analytics type="googleanalytics" id="analytics-amp">
        <script type="application/json">
        {
          "vars": {
            "account": "<?php echo $tracking_id; ?>"
          },
          "triggers": {
            "trackPageview": {
              "on": "visible",
              "request": "pageview"
            }
          }
        }
        </script>
        </amp-analytics>        
<?php } else { ?>
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', '<?php echo $tracking_id; ?>', 'auto');
            ga('send', 'pageview');
        </script>
<?php }
}