<body class="wrap content members">
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
            </div>
        <% end_if %>
        
        <div class="filter-members content-select">
            <% if $DefaultView == 'Selectable' %>
            <div>
                <h3>Filter by member type:</h3>
                <div class="selectbox">
                    <select id="member-sort" class="selectbox-select">
                        $GradeOptions
                    </select>
                </div>
            </div>
            <% end_if %>
            <div>
                <% if $DefaultView == 'Selectable' %>
                    <h3 class="list-title">Filter <span>Fellows</span> by surname:</h3>
                <% else %>
                    <h3 class="list-title">Filter <span>{$DefaultView}s</span> by surname:</h3>
                <% end_if %>
                <div class="filterbox">
                    <input type="text" name="surname-filter" id="surname-filter" placeholder="enter surname" />
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <% if $DefaultView == 'Selectable' %>
            <h2 class="list-title">List of <span>Fellows</span> of the Royal Society of New Zealand</h2>
        <% else %>
            <h2 class="list-title">List of <span>{$DefaultView}s</span> of the Royal Society of New Zealand</h2>
        <% end_if %>
    </div>
    <!-- RANDOMIZED QUOTE HERE (IF USER WANTS TO DISPLAY) -->
    <% include Quotes %>
    <!-- RANDOMIZED QUOTE HERE (IF USER WANTS TO DISPLAY) -->

    <div class="member-list-container">
        <% loop $People %>
        <div class="member-container" data-surname="$LastName">
            <a type="button" id="$ID" class="btn btn-info btn-lg member-click" data-toggle="modal" data-target="#memberModal">
                <% if $Photo %>
                    <img class="member-image" src="$Photo.Fill(130,158).Link" />
                <% else %>
                    <img class="member-image" src="mysite/icons/people-fallback.png" />
                <% end_if %>
                <p class="title">$Title</p>
                <p class="firstname">$FirstName</p>
                <p class="lastname">$LastName</p>
                <p class="honoraries">$Qualifications</p>
            </a>
        </div>
        <% end_loop %>
    </div>

    <div class="clear"></div>

    <!-- IF BLOCKS ARE SELECTED DISPLAY THESE ON TEMPLATE -->
    <% include Related %>
    <!-- IF BLOCKS ARE SELECTED DISPLAY THESE ON TEMPLATE -->
    <div class="clear"></div>
    <% include BottomShare %>
</div>

<!-- Modal -->
<div id="memberModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal">
                <div class="close-button" data-dismiss="modal"></div>
            </button>
            <div class="modal-body">

            </div>
            <pre id="test"></pre>
        </div>
    </div>
</div>