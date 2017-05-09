<% if $SubCategories %>
    <option value="">-- Select Option --</option>
    <% loop $SubCategories %>
        <option value="$ID">$SocioEconomicObjectiveSubCategory</option>
    <% end_loop %>
<% end_if %>