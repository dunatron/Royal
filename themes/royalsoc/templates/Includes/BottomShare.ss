<div class="bottom-share">
    <div class="left-share">
        <% if $SiteConfig.CurrentLikePage %>
            <% with $SiteConfig.CurrentLikePage %>
                <a href="$AbsoluteBaseURL{$URL}">
                    <span class="lstext" href="#">$Tag</span>
                    <span class="lstitle" href="#">$Title</span>
                    <div class="arrow-container">
                        <span class="arrow-head"></span>
                        <span class="arrow-line"></span>
                    </div>
                    <div class="clear"></div>
                </a>
            <% end_with %>
        <% end_if %>
    </div>
    <div class="right-share">

        <a href="#" id="SharePage" data-toggle="modal" data-target="#SharePageModal">
            <span class="rstext" href="#">Like what you see?</span>
            <span class="rstitle" href="#">Share this page</span>
            <div class="share-image"></div>
        </a>
    </div>
    <% include SharePageModal %>
</div>