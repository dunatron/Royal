        <div class="clear"></div>
        <div class="footer">
            <div class="footer-content">
                <div class="social-icons md-col-2 lrg-col-2">
                    <a class="fb-icon" href="$SiteConfig.RoyalFacebookURL"></a>
                    <a class="twitter-icon" href="$SiteConfig.RoyalTwitterURL"></a>
                    <!-- <a class="vimeo-icon" href="http://www.vimeo.com"><img src="img/foot/vimeo-icon.svg" /></a> -->
                </div>
                
                <div class="md-col-3 lrg-col-2 facilities-outer button-outer">
                    <% if $FacilitiesPageURL %>
                    <div class="facilities button">
                        <a href="$FacilitiesPageURL">Facilities</a>
                    </div>
                    <% end_if %>
                </div>

                <div class="md-col-3 lrg-col-2 join-us-outer button-outer">
                    <% if $JoinUsPageURL %>
                    <div class="join-us button">
                        <a href="$JoinUsPageURL">Join Us</a>
                    </div>
                    <% end_if %>
                </div>
               
                <div class="lrg-col-3 md-col-4 sign-up-newletters-outer button-outer">
                    <% if $NewslettersSignUpURL %>        
                    <div class="join-us button">
                        <a href="$NewslettersSignUpURL" target="_blank">Sign up to Newsletters</a>
                    </div> 
                    <% end_if %>            
                </div>
                <%--                   
                <div class="selectbox lrg-col-4">
                    <select id="newsletter" class="selectbox-select">
                        <option value="" disabled selected>Sign up to Newsletters</option>
                        <option value="nl1">Mailchimp newsletter one</option>
                        <option value="nl2">Mailchimp newsletter two</option>
                        <option value="nl3">Mailchimp newsletter three</option>
                        <option value="nl4">Mailchimp newsletter four</option>
                        <option value="nl5">Mailchimp newsletter five s</option>
                    </select>
                </div> 
                --%>
                <div class="foot-logos">
                    <%-- <a href="#" class="footlogoorcid"></a> --%>
                    <% if $AnniversaryPageURL %>
                        <a href="$AnniversaryPageURL" class="footlogo150"></a>
                    <% end_if %>
                                
                </div>

                <div class="bottom-foot-container">
                    <div class="foot-eds">
                        
                    </div>




                    <div class="copyright"><p>&copy; Royal Society of New Zealand 2017</p></div>
                    <div class="foot-links">
                        <a href="/sitemap" class="foot-link">Sitemap</a><!-- <span class="pipe-divide"></span> -->
                        <% if $VacanciesPageURL %>
                            <a href="$VacanciesPageURL" class="foot-link">Vacancies</a><!-- <span class="pipe-divide"></span> -->
                        <% end_if %>
                        <% if $AboutUsPageURL %>
                            <a href="$AboutUsPageURL" class="foot-link">About Us</a><!-- <span class="pipe-divide"></span> -->
                        <% end_if %>
                        <a href="#" class="foot-link" data-toggle="modal" data-target="#contactModal">Contact Us</a>
                    </div>
                </div>
            </div>
                
        </div>
        $ContactForm
        $DonateForm

        <% if $SiteConfig.GoogleAnalyticsCode %>
        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='https://www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','$SiteConfig.GoogleAnalyticsCode','auto');ga('send','pageview');
        </script>

        <% end_if %>
    </body>
</html>



