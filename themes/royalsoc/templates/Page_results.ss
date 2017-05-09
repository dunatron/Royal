<% include head %>
<body class="wrap content search-results">
    <% include SearchNavWrapperSml %>
<!-- Add your site or application content here -->
<!-- Add your site or application content here -->
<div class="container">

    <%--<div class="breadcrumbs">--%>
        <%--<a class="bc-parent" href="">--%>
            <%--HOME--%>
        <%--</a>--%>
        <%--<a class="bc-active" href="">--%>
            <%--SEARCH RESULTS--%>
        <%--</a>--%>
    <%--</div>--%>
    <% include Bcrumb %>

    <div class="content-wrapper lrg-col-9 md-col-8">
        <div class="filter-trigger">
            <span>FILTERS</span>
            <img src="img/controls/homepage/communities-tab-arrow.svg"/>
        </div>
        <h1>Search Results</h1>
        <h3 class="result-search-term">Results containing "{$KeyWord}"</h3>
        <div class="results-container">
            <%-- Basic All Search --%>
            <% loop $Results %>
                <div class="result-item-container research-funding ">
                    <a href="$Link">
                        <%-- Hero Image --%>
                        
                        <%-- Title Field --%>
                        <% if $ClassName == 'People' %>
                            <% if $Photo %>
                                <img class="result-image" src="$Photo.Fill(130,158).Link" />
                            <% else %>
                                <img class="result-image" src="mysite/icons/people-fallback.png" />
                            <% end_if %>
                            <p><span>$Title $FirstName $LastName</span></p>
                            <% if $BiographicalNotes %>
                                <p><span></span>$BiographicalNotes.ContextSummary(500, 0,1,1, '...', '...')</p>
                            <% end_if %>
                        <% else %>
                            <% if $HeroImage %>
                                <img class="result-image" src="$HeroImage.Fill(130,158).Link"/>
                            <% end_if %>
                            <% if $Title %>
                                <p><span>$Title</span></p>
                            <% end_if %>
                            <% if $Content.ContextSummary %>
                                <p><span></span>$Content.ContextSummary(250)</p>
                            <% end_if %>
                        <% end_if %>
                        <%-- Content Field --%>
                        <%--<% if $Content.ContextSummary %>--%>
                            <%--<p><span></span>$Content.LimitCharacters(300)</p>--%>
                        <%--<% end_if %>--%>

                        <%--<% if $Excerpt %>--%>
                            <%--<p><span></span>$Excerpt.LimitCharacters(300)</p>--%>
                        <%--<% end_if %>--%>


                    </a>
                    <div class="clear"></div>
                </div>
            <% end_loop %>
        </div>

        <!-- BEGIN PAGINATION -->
        <% if $Results.MoreThanOnePage %>
        <div class="pagination">
            <% if $Results.NotFirstPage %>
            <ul id="previous" class="col-xs-6">
                <li><a href="$Results.PrevLink"><span class="desktop-pagination-arrow"><img src="$ThemeDir/img/controls/red-arrow.svg" class="prev-arrow"> </span><span class="mobile-pagination-arrow">Previous</span></a></li>
            </ul>
            <% end_if %>
            <ul class="hidden-sm pagination-pages">
                <% loop $Results.Pages %>
                <li <% if $CurrentBool %>class="active"<% end_if %>><a href="$Link">$PageNum</a></li>
                <% end_loop %>
            </ul>
            <% if $Results.NotLastPage %>
            <ul id="next" class="col-xs-6">
                <li><a href="$Results.NextLink"><span class="mobile-pagination-arrow">Next</span><span class="desktop-pagination-arrow"><img src="$ThemeDir/img/controls/red-arrow.svg" class="next-arrow"></span></a></li>
            </ul>
            <% end_if %>

        </div>
        <% end_if %>
        <!-- END PAGINATION -->

    </div>
    <div class="filter-wrap lrg-col-3 md-col-4">
        <%--
        <div class="form-search-container">


            <h3>Filters:</h3>


            <form>

                <fieldset class="search-wrap recent-search-container">
                    <legend>Your recent search:</legend>
                    <div class="fieldsetPadding">
                        <a class="search-term" href="">Funding</a>
                        <a class="search-term" href="">ORCID</a>
                        <a class="search-term" href="">Events</a>
                        <a class="search-term" href="">Events Auckland</a>
                        <a class="search-term" href="">Research Funding</a>
                    </div>
                </fieldset>
            <fieldset class="search-wrap">

                <% if not $from  %>


                    <legend>Search Content:</legend>

                    <div class="fieldsetPadding">
                        <label>Search Panels:</label>
                        <div class="selectbox">
                            <select id="panelSearch" class="selectbox-select">
                                <option value="" disabled selected>Panel..</option>
                                <option value="pan1">Panel Title One</option>
                                <option value="pan2">Panel Title Two</option>
                                <option value="pan3">Panel Title Three</option>
                                <option value="pan4">Panel Title Four</option>
                                <option value="pan5">Panel Title Five</option>
                                <option value="pan6">Panel Title Six</option>
                                <option value="pan7">Panel Title Seven</option>
                                <option value="pan8">Panel Title Eight</option>
                            </select>
                        </div>


                        <label>Search Projects:</label>
                        <div class="selectbox">
                            <select id="panelSearch" class="selectbox-select">
                                <option value="" disabled selected>Project..</option>
                                <option value="prj1">Project Title One</option>
                                <option value="prj2">Project Title Two</option>
                                <option value="prj3">Project Title Three</option>
                                <option value="prj4">Project Title Four</option>
                                <option value="prj5">Project Title Five</option>
                                <option value="prj6">Project Title Six</option>
                                <option value="prj7">Project Title Seven</option>
                                <option value="prj8">Project Title Eight</option>
                            </select>
                        </div>


                        <label>Publication Type:</label>
                        <input type="checkbox" name="checkboxReport">
                        <label class="rad" for="checkboxReport">Report</label>
                        <input type="checkbox" name="checkboxPaper">
                        <label class="rad" for="checkboxPaper">Paper</label>
                        <input type="checkbox" name="checkboxJournal">
                        <label class="rad" for="checkboxJournal">Journal</label>


                        <div class="clear"></div>
                        <label>Date Published:</label>
                        <div class="selectbox">
                            <select id="searchDateYear" class="selectbox-select">
                                <option value="" disabled selected>Year..</option>
                                <option value="sy1">2017</option>
                                <option value="sy2">2016</option>
                            </select>
                        </div>
                    </div>
                </fieldset>
                    <br/>

                <% else %>


                    <fieldset class="search-wrap award-medal-wrap">
                        <legend>Awards and medals</legend>
                        <div class="fieldsetPadding">
                            <label>Year awarded:</label>
                            <div class="selectbox">
                                <select id="searchMedalAward" class="selectbox-select">
                                    <option value="" disabled selected>Award/Medal..</option>
                                    <option value="am1">Callaghan Medal</option>
                                    <option value="am2">Charles Fleming Award</option>
                                    <option value="am3">Cooper Award</option>
                                    <option value="am4">Cooper Medal</option>
                                    <option value="am5">Dame Joan Metge Medal</option>
                                    <option value="am6">Hamilton Award</option>
                                    <option value="am7">Hatherton Award</option>
                                    <option value="am8">Hector Medal</option>
                                </select>
                            </div>


                            <label>Year awarded:</label>
                            <div class="selectbox">
                                <select id="searchMedalYear" class="selectbox-select">
                                    <option value="" disabled selected>Year..</option>
                                    <option value="ya1">2017</option>
                                    <option value="ya2">2016</option>
                                    <option value="ya1">2015</option>
                                    <option value="ya2">2014</option>
                                    <option value="ya1">2013</option>
                                    <option value="ya2">2012</option>
                                    <option value="ya1">2011</option>
                                    <option value="ya2">2010</option>
                                </select>
                            </div>

                        </div>
                    </fieldset>


                    <fieldset class="search-wrap research-fund-wrap">
                        <legend>Researcher and funding</legend>
                        <div class="fieldsetPadding">

                            <label>Year awarded:</label>
                            <div class="selectbox">
                                <select id="searchFundYearAwarded" class="selectbox-select">
                                    <option value="" disabled selected>Year..</option>
                                    <option value="rfy1">2017</option>
                                    <option value="rfy2">2016</option>
                                    <option value="rfy3">2015</option>
                                    <option value="rfy4">2014</option>
                                    <option value="rfy5">2013</option>
                                    <option value="rfy6">2012</option>
                                    <option value="rfy7">2011</option>
                                    <option value="rfy8">2010</option>
                                </select>
                            </div>

                            <label>Minimum Fund:</label>
                            <div class="selectbox">
                                <select id="searchFundMin" class="selectbox-select">
                                    <option value="" disabled selected>Min fund..</option>
                                    <option value="rfmin1">Any</option>
                                    <option value="rfmin2">$500.00</option>
                                    <option value="rfmin3">$1000.00</option>
                                    <option value="rfmin4">$2000.00</option>
                                    <option value="rfmin5">$5000.00</option>
                                </select>
                            </div>


                            <label>Maximum Fund:</label>
                            <div class="selectbox">
                                <select id="searchFundMax" class="selectbox-select">
                                    <option value="" disabled selected>Max fund..</option>
                                    <option value="rfmax1">Any</option>
                                    <option value="rfmax2">$500.00</option>
                                    <option value="rfmax3">$1000.00</option>
                                    <option value="rfmax4">$2000.00</option>
                                    <option value="rfmax5">$5000.00</option>
                                    <option value="rfmax5">$10000.00</option>
                                </select>
                            </div>

                            <label>Lastname:</label>
                            <input placeholder="Lastname.." id="lastnameFund" type="text"/>
                            <label>Firstname:</label>
                            <input placeholder="Firstname.." id="firstnameFund" type="text"/>

                            <label>Year joined:</label>
                            <div class="selectbox">
                                <select id="searchFundYearJoined" class="selectbox-select">
                                    <option value="" disabled selected>Year..</option>
                                    <option value="rfy1">2017</option>
                                    <option value="rfy2">2016</option>
                                    <option value="rfy3">2015</option>
                                    <option value="rfy4">2014</option>
                                    <option value="rfy5">2013</option>
                                    <option value="rfy6">2012</option>
                                    <option value="rfy7">2011</option>
                                    <option value="rfy8">2010</option>
                                </select>
                            </div>

                        </div>
                    </fieldset>


                    <fieldset class="search-wrap membership-wrap">
                        <legend>Memberships</legend>
                        <div class="fieldsetPadding">

                            <label>Lastname:</label>
                            <input placeholder="Lastname.." id="lastnameMember" type="text"/>
                            <label>Firstname:</label>
                            <input placeholder="Firstname.." id="firstnameMember" type="text"/>

                            <label>Class of membership:</label>
                            <div class="selectbox">
                                <select id="memberClassSearch" class="selectbox-select">
                                    <option value="" disabled selected>Class..</option>
                                    <option value="cls1">Class One</option>
                                    <option value="cls2">Class Two</option>
                                    <option value="cls3">Class Three</option>
                                    <option value="cls4">Class Four</option>
                                    <option value="cls5">Class Five</option>
                                    <option value="cls6">Class Six</option>
                                    <option value="cls7">Class Seven</option>
                                    <option value="cls8">Class Eight</option>
                                </select>
                            </div>

                            <label>Organisation:</label>
                            <div class="selectbox">
                                <select id="memberOrgSearch" class="selectbox-select">
                                    <option value="" disabled selected>Organisation..</option>
                                    <option value="morg1">Association for Women in the Sciences</option>
                                    <option value="morg2">Nutrition Society of New Zealand</option>
                                    <option value="morg3">Philosophy of Education Society of Australasia</option>
                                    <option value="morg4">Physiological Society of New Zealand</option>
                                    <option value="morg5">Population Association of New Zealand</option>
                                    <option value="morg6">Royal Astronomical Society of New Zealand</option>
                                    <option value="morg7">Sociological Association of Aotearoa NZ (SAANZ)</option>
                                    <option value="morg8">New Zealand Society for Oncology</option>
                                </select>
                            </div>

                            <label>Year joined:</label>
                            <div class="selectbox">
                                <select id="searchFundYearAwarded" class="selectbox-select">
                                    <option value="" disabled selected>Year..</option>
                                    <option value="rfy1">2017</option>
                                    <option value="rfy2">2016</option>
                                    <option value="rfy3">2015</option>
                                    <option value="rfy4">2014</option>
                                    <option value="rfy5">2013</option>
                                    <option value="rfy6">2012</option>
                                    <option value="rfy7">2011</option>
                                    <option value="rfy8">2010</option>
                                </select>
                            </div>

                        </div>
                    </fieldset>


                <fieldset class="search-wrap event-wrap">
                    <legend>Events</legend>
                    <div class="fieldsetPadding">

                        <label>Title:</label>
                        <input placeholder="Title.." id="titleEvent" type="text"/>

                        <label>Topic:</label>
                        <div class="selectbox">
                            <select id="eventTopicSearch" class="selectbox-select">
                                <option value="" disabled selected>Topic..</option>
                                <option value="et1">Event Topic One</option>
                                <option value="et2">Event Topic Two</option>
                                <option value="et3">Event Topic Three</option>
                                <option value="et4">Event Topic Four</option>
                                <option value="et5">Event Topic Five</option>
                                <option value="et6">Event Topic Six</option>
                                <option value="et7">Event Topic Seven</option>
                                <option value="et8">Event Topic Eight</option>
                            </select>
                        </div>

                        <label>Location:</label>
                        <div class="selectbox">
                            <select id="eventLocationSearch" class="selectbox-select">
                                <option value="" disabled selected>Location..</option>
                                <option value="el1">North Island</option>
                                <option value="el2">South Island</option>
                                <option value="el3">Auckland</option>
                                <option value="el4">Hamilton</option>
                                <option value="el5">Napier</option>
                                <option value="el6">Wellington</option>
                                <option value="el7">Christchurch</option>
                            </select>
                        </div>

                        <label>Speaker:</label>
                        <div class="selectbox">
                            <select id="eventSpeakerSearch" class="selectbox-select">
                                <option value="" disabled selected>Speaker..</option>
                                <option value="es1">Joe Blogs</option>
                                <option value="es2">Jane Doe</option>
                                <option value="es3">Chuck Norris</option>
                                <option value="es4">Joe King</option>
                                <option value="es5">Jack Sun</option>
                                <option value="es6">Don Key</option>
                            </select>
                        </div>

                        <label>Organisation:</label>
                        <div class="selectbox">
                            <select id="hostOrgSearch" class="selectbox-select">
                                <option value="" disabled selected>Organisation..</option>
                                <option value="ho1">HoS NZ Charitable Trust</option>
                                <option value="ho2">Motu Economic and Public Policy Research</option>
                                <option value="ho3">National Science-Technology Roadshow Trust</option>
                                <option value="ho4">New Zealand Association of Economists</option>
                                <option value="ho5">Opus Intl Laboratories</option>
                                <option value="ho6">Science Alive</option>
                            </select>
                        </div>

                        <label>Event Date</label>
                        <div class="selectbox">
                            <select id="eventMonthSearch" class="selectbox-select">
                                <option value="" disabled selected>Month..</option>
                                <option value="em1">January</option>
                                <option value="em2">February</option>
                                <option value="em3">March</option>
                                <option value="em4">April</option>
                                <option value="em5">May</option>
                                <option value="em6">June</option>
                                <option value="em7">July</option>
                                <option value="em8">August</option>
                                <option value="em9">September</option>
                                <option value="em10">October</option>
                                <option value="em11">November</option>
                                <option value="em12">December</option>
                            </select>
                        </div>

                        <div class="clear"></div>
                        <br/>
                        <input class="eventYearRad" id="currentYearEvent" type="radio" name="yearEvent" value="2017"/>
                        <label class="rad" for="currentYearEvent">2017</label>
                        <div class="clear"></div>
                        <input class="eventYearRad" id="nextYearEvent" type="radio" name="yearEvent" value="2018"/>
                        <label class="rad" for="nextYearEvent">2018</label>

                    </div>
                <% end_if %>
            </fieldset>


                <div class="button-outer">
                    <button type="submit" name="action_submitsearch" value="Send" class="button action"
                            id="Form_SearchForm">
                        <a href="#">Search</a>
                    </button>
                </div>
            </form>
        </div>
        --%>

    </div>

    <div class="clear"></div>

    <% include BottomShare %>


</div>
<div class="clear"></div>
<% include foot %>