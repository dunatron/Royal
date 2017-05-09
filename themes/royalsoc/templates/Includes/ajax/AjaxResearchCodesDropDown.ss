<% if $ResearchCodes %>
    <option value="">-- Select Option --</option>
    <% loop $ResearchCodes %>
        <option value="$ID">$FieldResearchCode</option>
    <% end_loop %>
<% end_if %>