<body class="wrap content">
    <% include SearchNavWrapperSml %>
<!-- Add your site or application content here -->
<div class="container">
    <% include Bcrumb %>
    <div class="content-wrapper calc lrg-col-8 md-col-9">
        <h1>$Title</h1>
        <!--               <div class="feature-image">
                          <img src="http://www.placekitten.com/645/300">
                      </div> -->

        <div class="user-content">
            <p>$Intro</p>
            $Content
        </div>
        <div class="filter-grant-apply content-select md-col-12">
            <h3>Category:</h3>
            <div class="selectbox">
                <select id="field-research-sort" class="selectbox-select md-col-6">
                    <option value="">-- Select Option --</option>
                    <% loop $getResearchCategories %>
                        <option value="$ID">$FieldResearchCategory</option>
                    <% end_loop %>
                </select>
            </div>
        </div>

        <div class="filter-grant-who content-select md-col-12 not-visible">
            <%--<div style="visibility: hidden">--%>
            <h3>Sub-category:</h3>
            <div class="selectbox" >
                <select id="sub-cats-sort" class="selectbox-select">
                    <option value="mf1">Post Graduate</option>
                    <option value="mf2">Graduate</option>
                    <option value="mf3">Other</option>
                </select>
            </div>
            <%--</div>--%>
        </div>

        <%-- Research Codes Dropdown --%>
        <div class="filter-grant-who content-select md-col-12 not-visible">
            <%--<div style="visibility: hidden">--%>
            <h3>Code:</h3>
            <div class="selectbox" >
                <select id="research-codes-dropdown" class="selectbox-select">
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