<body class="wrap content">
    <% include SearchNavWrapperSml %>
<!-- Add your site or application content here -->
<div class="container">
    <% include Bcrumb %>
    <div class="content-wrapper lrg-col-8 md-col-9">
        <% if $ClassName == 'News' %> 
            <h3>$ClassName</h3>
            <% if $PublishedDate %>
                <small>Published $PublishedDate.Format("j F Y")</small>
            <% end_if %>
        <% end_if %>
        <h1>$Title</h1>
        <!-- OPTIONAL CONTENT IMAGE HERE -->
        <% if $HeroImage %>
            <div class="content-image">
                <% include BannerImage %>
                <%--<img class="sml-col-12" src="img/main/main-content-image.jpg"/>--%>
            </div>
        <% end_if %>
        <!-- OPTIONAL INTRO TEXT HERE (IF INTRO TEXT EXISTS) -->
        <% if $Intro %>
            <div class="intro-content">
                <p>$Intro</p>
            </div>
        <% end_if %>
        <!-- OPTIONAL INTRO TEXT HERE (IF INTRO TEXT EXISTS) -->
        <% if $ContentBeforeForm %>
            <div class="user-content">
                $ContentBeforeForm
            </div>
        <% end_if %>

        <!-- Display success/fail message -->
        $Content
        
        <% if $SelectedForm %>
            <div class="user-content">
                $FormPageForm
            </div>
        <% end_if %>
        <% if $ContentAfterForm %>
            <div class="user-content">
                $ContentAfterForm
            </div>
        <% end_if %>
        <% if $ChildPages %>
            <div>
            <% loop $ChildPages %>
                <div class="child-links">
                    <h2><a href="$Link">$Title</a></h3>
                    <p>$Intro</p>
                </div>
            <% end_loop %>
            </div>
        <% end_if %>
    </div>
    <!-- RANDOMIZED QUOTE HERE (IF USER WANTS TO DISPLAY) -->
    <% include Quotes %>
    <!-- RANDOMIZED QUOTE HERE (IF USER WANTS TO DISPLAY) -->
    <div class="clear"></div>
    <!-- IF BLOCKS ARE SELECTED DISPLAY THESE ON TEMPLATE -->
    <% include Related %>
    <!-- IF BLOCKS ARE SELECTED DISPLAY THESE ON TEMPLATE -->
    <div class="clear"></div>
    <% include BottomShare %>
</div>