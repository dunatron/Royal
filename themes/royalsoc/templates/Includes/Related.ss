<% if $RelatedPageData %>
<div class="activity-blocks">
    <h2>$RelatedContentLabel</h2>   
    <% loop $RelatedPageData %>
        <div class="activity-block lrg-col-4 md-col-6">
            <div class="block-color-fill">
                <a href="$Link" $OffSite class="block-link">
                    <h3>$Title</h3>
                    <div class="arrow-container">
                        <span class="arrow-head"></span>
                        <span class="arrow-line"></span>
                    </div>
                </a>
            </div>
        </div>
    <% end_loop %>
</div>
<% end_if %>