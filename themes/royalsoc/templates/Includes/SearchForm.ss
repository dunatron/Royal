<% if $IncludeFormTag %>
    <form class="searchForm">
<% end_if %>
    <% loop $Fields %>
        <input $AttributesHTML />
    <% end_loop %>
    <% if $Actions %>
        <% loop $Actions %>
                <button $AttributesHTML></button>
        <% end_loop %>
    <% end_if %>
<% if $IncludeFormTag %>
    </form>
<% end_if %>