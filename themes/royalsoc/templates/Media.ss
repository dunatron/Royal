<% include head %>
<body class="wrap content">
    <% include SearchNavWrapperSml %>
<!-- Add your site or application content here -->
<div class="container">
    <div class="breadcrumbs"><a class="bc-parent" href="">Home </a><a class="bc-active" >$Title </a></div>
    <div class="videowrapper">
        $URL.RAW
    </div>
    <div class="content-wrapper lrg-col-8 md-col-9">
        <h1>$Title</h1>
        <% if $Transcript %>
            <div class="user-content">
                $Transcript
            </div>
        <% end_if %>
    </div>
    <div class="clear"></div>
    <% include BottomShare %>
</div>
<% include foot %>