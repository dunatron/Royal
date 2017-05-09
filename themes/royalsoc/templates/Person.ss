<% include head %>
<body class="wrap content">
    <% include SearchNavWrapperSml %>
<!-- Add your site or application content here -->
<div class="container">
    <% include Bcrumb %>
    <div class="content-wrapper lrg-col-8 md-col-9">
        <% if $Photo %>
            <img class="member-image" src="$Photo.Fill(130,158).Link" />
        <% else %>
            <img class="member-image" src="mysite/icons/people-fallback.png" />
        <% end_if %>
        <h2>$FullName</h2>
        <h2>$Qualifications</h2>
        <p >$BiographicalNotes</p>
    </div>
    <div class="clear"></div>
    <!-- IF BLOCKS ARE SELECTED DISPLAY THESE ON TEMPLATE -->
    <div class="clear"></div>
    <% include BottomShare %>
</div>
<% include foot %>