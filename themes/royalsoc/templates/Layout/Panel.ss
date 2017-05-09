<body class="wrap panel-project tiles large-banner $ClassName <%-- if $ClassName == "EventPanel" %>event-holder<% end_if --%>">
    <% include SearchNavWrapperLrg %>
<!-- Add your site or application content here -->
<div class="container">
    <% include Bcrumb %>

    <% if $ClassName == 'NewsPanel' %>
        <div class="button-outer add-news-btn">
            <div class="button add-news">
                <a href="#" class="foot-link" data-toggle="modal" data-target="#CreateNewsModal">Create News</a>
            </div>
            <% include CreateNewsModal %>
        </div>

    <% end_if %>
    
    <div class="content-wrapper">
        <% if $PromoteContent %>
            <% with $PromoteContent %>
                <div class="important-image-container md-col-6 lrg-col-4">
                    <a href="$Link" class="important-image" $OffSite
                       style="background-image:url($Image.FocusFill(540,430).Link)">
                       <%-- 540,430 --%>
                        <div class="important-image-text-container">
                            <div class="text-wrapper">
                                <h2 class="title">$Title</h2>
                                <p class="text">$Text</p>
                                <div class="arrow-container">
                                    <span class="arrow-head"></span>
                                    <span class="arrow-line"></span>
                                </div>
                            </div>

                        </div>
                    </a>
                </div>
            <% end_with %>
        <% end_if %>

        <% loop $AssociatedContent %>
            <div class="content-event-box-container md-col-6 lrg-col-4">
                <div class="content-box">
                    <a class="content-link" $OffSite href="$Link">
                        <div style="background-image:url($Image.FocusFill(250, 250).Link)"
                             class="content-image sml-col-4 md-col-6">
                        </div>
                        <div class="content-text sml-col-8 md-col-6">
                            <div class="text-margin">
                                <h2>$Title</h2>
                                <p>$Text</p>
                                <div class="arrow-break">
                                    <div class="arrow-container">
                                        <span class="arrow-head"></span>
                                        <span class="arrow-line"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="clear-border"></div>
            </div>
        <% end_loop %>
    </div>

    <div class="clear"></div>

    <% include BottomShare %>

</div>
