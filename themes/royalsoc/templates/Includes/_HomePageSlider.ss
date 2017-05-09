<li class="project-item">
    <a href="$Link" class="project-url">
        <div <% if $Image %> style="background-image:url('$Image.FocusFill(390,190).Link')" class="project-image sml-col-6"<% else %> class="project-image sml-col-6 no-image" <% end_if %>>
            <div class="project-image-overlay-arrow"></div>
        </div>
        <div class="project-text sml-col-6">
            <h3>$Title</h3>
            <p>$Text</p>
            <div class="arrow-container">
                <span class="arrow-head"></span>
                <span class="arrow-line"></span>
            </div>
        </div>
        <div class="clear"></div>
    </a>
</li>