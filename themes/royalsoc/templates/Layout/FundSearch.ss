<body class="wrap content">
    <% include SearchNavWrapperSml %>
<!-- Add your site or application content here -->
<div class="container">
    <% include Bcrumb %>
    <div class="content-wrapper lrg-col-8 md-col-9">
        <h1>$Title</h1>

        <div class="user-content">
            <p>$Intro</p>
            $Content
        </div>
        <div class="filter-grant-apply content-select md-col-6">
            <h3>I am a:</h3>
            <div class="selectbox">
                <select id="fund-member-sort" class="selectbox-select md-col-6">
                    <option value="">-- Select Option --</option>
                    <% loop $getFundAudience %>
                        <option value="$ID">$Audience</option>
                    <% end_loop %>
                </select>
            </div>
        </div>

        <div class="filter-grant-who content-select md-col-6 not-visible">
            <%--<div style="visibility: hidden">--%>
            <h3>I am seeking:</h3>
            <div class="selectbox" >
                <select id="fund-type-sort" class="selectbox-select">
                    <option value="mf1">Post Graduate</option>
                    <option value="mf2">Graduate</option>
                    <option value="mf3">Other</option>
                </select>
            </div>
            <%--</div>--%>
        </div>

        <div class="calc-full-list-container">

        </div>

    </div>
    <!-- RANDOMIZED QUOTE HERE (IF USER WANTS TO DISPLAY) -->
    <% include Quotes %>
    <!-- RANDOMIZED QUOTE HERE (IF USER WANTS TO DISPLAY) -->

    <div class="clear"></div>
    <% include BottomShare %> 
</div>