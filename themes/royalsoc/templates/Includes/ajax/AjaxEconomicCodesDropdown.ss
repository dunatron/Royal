<% if $EconomicCodes %>
    <option value="">-- Select Option --</option>
    <% loop $EconomicCodes %>
        <option value="$ID">$SocioEconomicObjectiveCode</option>
    <% end_loop %>
<% end_if %>