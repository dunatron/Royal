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
        <h3>
        <% if $ResearcherName %>
            Researcher: $ResearcherName<br />
        <% end_if %>
        <% if $ResearcherEmail %>
            Researcher Email: <a href="mailto: $ResearcherEmail">$ResearcherEmail</a><br />
        <% end_if %>
        <% if $ResearcherOrganisation %>
            Researcher Organisation: $ResearcherOrganistion<br />
        <% end_if %>
        </h3>
        <!-- OPTIONAL INTRO TEXT HERE (IF INTRO TEXT EXISTS) -->
        <% if $Intro %>
            <div class="intro-content">
                <p>$Intro</p>
            </div>
        <% end_if %>
        <!-- OPTIONAL INTRO TEXT HERE (IF INTRO TEXT EXISTS) -->
        <% if $Content %>
            <div class="user-content">
                $Content
                <% if $ExternalLink1 %>
                    <% if $ExternalLink1Title %>
                        <p><a href="$ExternalLink1" target="_blank">$ExternalLink1Title</a></p>
                    <% else %>
                        <p><a href="$ExternalLink1" target="_blank">$ExternalLink1</a></p>
                    <% end_if %>
                <% end_if %>
                <% if $ExternalLink2 %>
                    <% if $ExternalLink2Title %>
                        <p><a href="$ExternalLink2" target="_blank">$ExternalLink2Title</a></p>
                    <% else %>
                        <p><a href="$ExternalLink2" target="_blank">$ExternalLink2</a></p>
                    <% end_if %>
                <% end_if %>  
                $Form
            </div>
        <% end_if %>
        <% if $ChildPages %>
            <div>
            <% loop $ChildPages %>
                <div class="child-links">
                    <h2><a href="$Link">$Title</a></h2>
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