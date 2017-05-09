<body class="wrap content">
    <% include SearchNavWrapperSml %>
<!-- Add your site or application content here -->
<div class="container">
    <% include Bcrumb %>
    <div class="content-wrapper lrg-col-8 md-col-9">
        <h1>$Title</h1>

        <div class="royal-site-map">
            <ul>
                <% loop $getAllTopLevelPages %>
                    <li>
                        <a href="$Link">$Title</a>
                        <ul>
                            <% if $ClassName == 'EventPanel' %>
                                <% loop $AllChildren.Sort(LastEdited, ASC) %>                              
                                    <% if $End > $Now %>
                                        <% if $ClassName != 'DocumentSection' && $ClassName != 'DocumentParagraph' %>
                                            <li><a href="$Link">$Title</a> </li>
                                            <ul>
                                                <% loop $AllChildren %>
                                                    <% if $ClassName != 'DocumentSection' && $ClassName != 'DocumentParagraph' %>
                                                        <li><a href="$Link">$Title</a> </li>
                                                        <ul>
                                                            <% loop $AllChildren %>
                                                                <% if $ClassName != 'DocumentSection' && $ClassName != 'DocumentParagraph' %>
                                                                    <li><a href="$Link">$Title</a> </li>
                                                                    <ul>
                                                                        <% loop $AllChildren %>
                                                                            <% if $ClassName != 'DocumentSection' && $ClassName != 'DocumentParagraph' %>
                                                                                <li><a href="$Link">$Title</a> </li>
                                                                            <% end_if %>
                                                                        <% end_loop %>
                                                                    </ul>
                                                                <% end_if %>
                                                            <% end_loop %>
                                                        </ul>
                                                    <% end_if %>
                                                <% end_loop %>
                                            </ul>
                                        <% end_if %>
                                    <% end_if %>
                                <% end_loop %>
                            <% else_if $CLassName == 'NewsPanel' %>
                                <% loop $AllChildren.Sort(LastEdited, DESC) %>
                                    <% if $ClassName != 'DocumentSection' && $ClassName != 'DocumentParagraph' %>
                                        <li><a href="$Link">$Title</a> </li>
                                        <ul>
                                            <% loop $AllChildren %>
                                                <% if $ClassName != 'DocumentSection' && $ClassName != 'DocumentParagraph' %>
                                                    <li><a href="$Link">$Title</a> </li>
                                                    <ul>
                                                        <% loop $AllChildren %>
                                                            <% if $ClassName != 'DocumentSection' && $ClassName != 'DocumentParagraph' %>
                                                                <li><a href="$Link">$Title</a> </li>
                                                                <ul>
                                                                    <% loop $AllChildren %>
                                                                        <% if $ClassName != 'DocumentSection' && $ClassName != 'DocumentParagraph' %>
                                                                            <li><a href="$Link">$Title</a> </li>
                                                                        <% end_if %>
                                                                    <% end_loop %>
                                                                </ul>
                                                            <% end_if %>

                                                        <% end_loop %>
                                                    </ul>
                                                <% end_if %>
                                            <% end_loop %>
                                        </ul>
                                    <% end_if %>
                                <% end_loop %>
                            <% else %>
                                <% loop $AllChildren %>
                                    <% if $ClassName != 'DocumentSection' && $ClassName != 'DocumentParagraph' %>
                                        <li><a href="$Link">$Title</a> </li>
                                        <ul>
                                            <% loop $AllChildren %>
                                                <% if $ClassName != 'DocumentSection' && $ClassName != 'DocumentParagraph' %>
                                                    <li><a href="$Link">$Title</a> </li>
                                                    <ul>
                                                        <% loop $AllChildren %>
                                                            <% if $ClassName != 'DocumentSection' && $ClassName != 'DocumentParagraph' %>
                                                                <li><a href="$Link">$Title</a> </li>
                                                                <ul>
                                                                    <% loop $AllChildren %>
                                                                        <% if $ClassName != 'DocumentSection' && $ClassName != 'DocumentParagraph' %>
                                                                            <li><a href="$Link">$Title</a> </li>
                                                                        <% end_if %>
                                                                    <% end_loop %>
                                                                </ul>
                                                            <% end_if %>

                                                        <% end_loop %>
                                                    </ul>
                                                <% end_if %>
                                            <% end_loop %>
                                        </ul>
                                    <% end_if %>
                                <% end_loop %>
                            <% end_if %>
                        </ul>
                    </li>
                <% end_loop %>

            </ul>
        </div>

    </div>
    <!-- RANDOMIZED QUOTE HERE (IF USER WANTS TO DISPLAY) -->
    <% include Quotes %>
    <!-- RANDOMIZED QUOTE HERE (IF USER WANTS TO DISPLAY) -->

    <div class="clear"></div>
    <% include BottomShare %>
</div>