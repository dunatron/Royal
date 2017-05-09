<% if $Types %>
    <option value="">-- Select Option --</option>
    <% loop $Types %>
        <option value="$ID">$Type</option>
    <% end_loop %>
<% end_if %>