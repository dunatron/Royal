
    <body class="wrap content event">
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <div class="banner">
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
                    <a href="#donate" >
                        Donate
                    </a>
                </div>
            </div>
        </div>

        <div class="search-wrapper">
            <div class="search-container">
                <div class="close-button"></div>
                $RoyalSearchForm
            </div>
           
        </div>

        <% include Menu %>
        
        <!-- Add your site or application content here -->
        <div class="container">

           <% include Bcrumb %>
            
            <div class="content-wrapper">
            <h1>$Title</h1>
                <div class="event-content lrg-col-8">
                    <% if $Intro %>
                        <div class="intro-content">
                            <p>$Intro</p>
                        </div>
                    <% end_if %>
                    <% if $HeroImage %>
                        <!-- OPTIONAL CONTENT IMAGE HERE -->
                        <div class="content-image">
                            <img class="sml-col-12" src="$HeroImage.Link"/>
                        </div>
                        <!-- OPTIONAL CONTENT IMAGE HERE (USERS CHOICE) -->
                    <% end_if %>

                    <div class="user-content">
                        $FormattedContent
                    </div>
                </div>
                <div class="event-detail-container md-col-6 lrg-col-4">
                    <% if $SpeakerImage %>
                        <img class="member-picture" src="$SpeakerImage.FitMax(130,158).Link" />
                    <% end_if %>
                    <% if $SpeakerName || $SpeakerTitle %>
                        <div class="speaker">
                            <h3 class="detail-title">SPEAKER</h3>
                            <% if $SpeakerName %>
                            <p class="speak-large">$SpeakerName</p>
                            <% end_if %>
                            <% if $SpeakerTitle %>
                            <p class="speak-small">$SpeakerTitle</p>
                            <% end_if %>
                        </div>
                    <% end_if %>

                    <% if $Organisation %>
                    <div class="org">
                        <h3 class="detail-title">ORGANISATION</h3>
                        <p class="speak-large">$Organisation</p>
                    </div>
                    <% end_if %>

                    <div class="venue">
                        <h3 class="detail-title">VENUE/DATE</h3>
                        <%--<% loop $LocationsInOrder %>--%>
                            <%--<p class="speak-large">$Location</p>--%>
                            <%--<p class="speak-med">$Start.Format("l j F, Y")</p>--%>
                        <%--<% end_loop %>--%>
                        <p class="speak-large">$Location</p>
                        <p class="speak-large">
                            <% if $Start.Time == '12:00am' %>
                                $Start.Format("D j F, Y") 
                            <% else %>
                                $Start.Format("g:ia D j F, Y")
                            <% end_if %> 
                            <% if $End %>
                                 <% if $End.Time ==  '11:59pm' %>
                                    - $End.Format("D j F, Y")
                                 <% else %>
                                    - $End.Format("g:ia D j F, Y")
                                 <% end_if %>
                            
                            <% end_if %>
                        </p>
                    </div>
                    <% if $BookingURL %>
                    <div class="book-now-container">
                        <div class="button-outer">
                            <div class="button book-now">
                                <a $BookingURL target="_blank">Book now</a>
                            </div>
                        </div>
                    </div>
                    <% end_if %>
                    <% if $InfoURL %>
                    <div class="book-now-container">
                        <a href="$InfoURL" target="_blank">More Information about Event</a>
                    </div>
                    <% end_if %>
                </div>
                
            </div>

            <div class="clear"></div>

            <% include BottomShare %>
            
            

        </div>
        <div class="clear"></div>
        