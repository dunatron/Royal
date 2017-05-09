<!doctype html>
<html class="no-js" lang="">
    <head>
        <% base_tag %>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>$SiteConfig.Title - $Title</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <script src="https://use.typekit.net/euo0upv.js"></script>
        <script>try{Typekit.load({ async: true });}catch(e){}</script>

        <!-- Place favicon.ico in the root directory -->
        <link rel="shortcut icon" href="/favicon.ico" />

        <link rel="stylesheet" href="$BaseHref$ThemeDir/css/vendor/bootstrap-modal.min.css">
        <link rel="stylesheet" href="$BaseHref$ThemeDir/css/main.css">
        <link rel="stylesheet" href="$BaseHref$ThemeDir/css/visibility.css">


        <!--[if lt IE 9]>
            <script type="text/javascript" src="$BaseHref$ThemeDir/js/vendor/min/respond.min.js"></script>
            <link rel="stylesheet" href="$BaseHref$ThemeDir/css/ie8.css">
            <script type="text/javascript" src="$BaseHref$ThemeDir/js/vendor/min/jquery-1.12.4.min.js"></script>  

            <script type="text/javascript">
                var jQuery_1_12_4 = $.noConflict(true);
            </script> 

            <script type="text/javascript" src="$BaseHref$ThemeDir/js/ie8.js"></script> 
        <![endif]-->


    </head>
    <style>
        .site-color{
            color: $TextColour !important;
        }
        .content-container a{
            color: $TextColour !important;
        }
        .content-container h1, .content-container h2, .content-container h3, .content-container h4, .content-container h5{
            color: $TextColour !important;
        }

    </style>

    <body class="wrap large-banner microsite">
        $InsertTag
        <div class="micro-banner-container">
            <div class="micro-top-banner">
                <div class="microbanner-contain">
                    <div class="arrow-container">
                        <span class="arrow-head"></span>
                        <span class="arrow-line"></span>
                    </div>
                    <a href="/">Back to the main site</a>
                </div>
                <img class="micrologo" src="$MicroSiteLogo.Fill(185,125).Link"/>
                <div class="clear"></div>
            </div>


            <!--[if lt IE 8]>
                <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
            <![endif]-->
            <!-- DIFF BANNER FOR LANDING -->
            <div class="banner" style="background-image:url($FindHeroImage.Fill(1170,420).Link)">
                <div class="banner-text-container">
                    <h1 class="banner-title site-color lrg-col-4">Celebrating 150 years of discovery</h1>
                    <div class="clear"></div>
                    <% if $VideoURL %>
                        <div class="button-outer">
                            <div class="button">
                                <a href="$VideoURL" target="_blank">Watch video</a>
                            </div>
                        </div>
                    <% end_if %>
                </div>

            </div>
        </div>

        <!-- Add your site or application content here -->
        <div class="container">


           <!--  $Layout -->
            <div class="widget-column">
                $RenderMicroSite
            </div>
            <!-- user can turn on related child pages -->
            <div class="related-content">
                  
            </div>
            <div class="clear"></div>
            <!-- user can enter turn on related link blocks -->
            <% if $RelatedPageData %>
            <div class="activity-blocks">
                <h2>$RelatedContentLabel</h2>   
                <% loop $RelatedPageData %>
                    <div class="activity-block lrg-col-4 md-col-6">
                        <div class="block-color-fill">
                            <a href="$Link" $OffSite class="block-link">
                                <h3>$Title</h3>
                                <div class="arrow-container">
                                    <span class="arrow-head"></span>
                                    <span class="arrow-line"></span>
                                </div>
                            </a>
                        </div>
                    </div>
                <% end_loop %>
                <div class="clear"></div>
            </div>
            <% end_if %>



        <div class="clear"></div>
        <!-- $SiteConfig.BookPhoto -->
        $BookForm
        <div class="footer">
            <div class="footer-content">
                <div class="bottom-foot-container">
                    <div class="foot-eds"></div>
                    <div class="copyright"><p>&copy; Royal Society of New Zealand 2017</p></div>
                </div>
            </div>
            <div class="hidden-slide-sort hide"></div>
                
        </div>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='https://www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X','auto');ga('send','pageview');
        </script>
    </body>
</html>
