<body class="wrap content">
    <% include SearchNavWrapperSml %>
<!-- Add your site or application content here -->
<div class="container">
    <% include Bcrumb %>
    <div class="content-wrapper lrg-col-8 md-col-9">
        <h1>$Title</h1>
        <!-- OPTIONAL CONTENT IMAGE HERE -->
        <% if $HeroImage %>
            <div class="content-image">
                <% include BannerImage %>
                <%--<img class="sml-col-12" src="img/main/main-content-image.jpg"/>--%>
            </div>
        <% end_if %>
<%--             <div class="intro-content">
                <p style="float:right"><a href="pdf/index/$ID" target="_blank">Download PDF version</a></p>
            </div> --%>

        <div class="user-content document">
            $Content
        </div>
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


