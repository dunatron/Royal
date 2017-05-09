
    <body class="wrap homepage large-banner">
        $AudienceType
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <!-- DIFF BANNER FOR LANDING -->
        <div class="banner" style="background-image:url('$ThemeDir/img/assets/star_gazing_gold_mh.jpg')">
            <a href="/" class="logo">
            </a>
            <div class="banner-content">
                <div class="hamburger">
                    <span class="filling"></span>
                </div>
                <div class="search">
                    <span class="magnif"></span>
                </div>
                <div class="donate">
                    <a href="#donate" data-toggle="modal" data-target="#donateModal">
                        Donate
                    </a>
                </div>
            </div>
            <div class="banner-text-container">
                <h1 class="banner-title lrg-col-8">
                $SiteConfig.Tagline
                </h1>
            </div>


            <% if $OurCommunities %>
                <div class="communities-trigger desktop-land-trigger">
                    <span>OUR COMMUNITIES</span>
                    <img src="$ThemeDir/img/controls/homepage/communities-tab-arrow.svg"/>
                </div>
                <div class="expand-communities-container">
                    <div class="communities-background desktop-land-expand">
                        <div class="expand-communities-links-container">
                            <% loop $OurCommunities %>
                                <a href="$Link">$MenuTitle<span class="community-arrow"></span></a>
                            <% end_loop %>
                            <!-- empty THIS MUST EXIST -->
                            <% if $OurCommunities.Count > 5 %>
                                <a href=""></a>
                            <% end_if %>
                        </div>
                        <div class="black-overlay"></div>
                    </div>
                </div>   
            <% end_if %>

           
        </div>

        <% include Search %>

        <% include Menu %>

         <div class="explore-filter-container">
            <div class="donate">
                <a href="#donate" data-toggle="modal" data-target="#donateModal">
                    Donate
                </a>
            </div>
            <div class="clear"></div>
            <div class="filter-center-text">
                <h3>EXPLORE: I'M</h3>
                <div class="filter-buttons">
                    <a class="filter-research filter" href="">A Researcher
                        <img src="$ThemeDir/img/controls/homepage/explore-arrow.svg"/>
                    </a>
                    <a class="filter-stuteach filter" href="">A Student or Teacher
                        <img src="$ThemeDir/img/controls/homepage/explore-arrow.svg"/>
                    </a>
                    <a class="filter-curious filter" href="">Curious
                        <img src="$ThemeDir/img/controls/homepage/explore-arrow.svg"/>
                    </a>
                    <div class="clear"></div>
                </div>
            </div>
        </div>

        <!-- Add your site or application content here -->
        <div class="container">
            <div class="panel-container curious lrg-col-6">$Boxes(all)</div>
            <div class="panel-container stuteach lrg-col-6">$Boxes(teachersandstudents)</div>               
            <div class="panel-container research lrg-col-6">$Boxes(researchers)</div>

            <div class="cleartab"></div>

            <div class="view-slide-position lrg-col-6">

                 <div class="custom-slide-viewport">
                    <div class="custom-slide-container" id="custom-slide-id">
                        <img src="/mysite/icons/royalloader.gif" class="sliderloader" />
                    <!-- top slide -->
                        <div class="mobile-slide">


                        </div>
                        <div class="top-slide tablet-slide"></div>
                        <div class="bottom-slide tablet-slide"></div>
                        <!-- bottom slide -->
                       


                    </div>
                    <span class="button-prev"></span>
                    <span class="button-next"></span>

                    
                </div>
            </div>
            <div class="hidden-slide-sort hide"></div>

        </div>

        