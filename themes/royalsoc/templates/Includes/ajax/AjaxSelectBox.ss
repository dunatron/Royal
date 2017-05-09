<% if $Subjects %>
    <option value="">-- Select Option --</option>
    <% loop $Subjects %>
        <option value="$ID">$Subject</option>
    <% end_loop %>
<% end_if %>