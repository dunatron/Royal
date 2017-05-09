<% if $IncludeFormTag %>
    <form $AttributesHTML>
<% end_if %>
	<% loop $Fields %>
		<input $AttributesHTML />
	<% end_loop %>
	<% if $Actions %>
		<% loop $Actions %>
				<button $AttributesHTML></button>
		<% end_loop %>
	<% end_if %>
    <h3>Explore as a</h3>
    <!-- need to be submitted with above form -->
    <input class="vistorstatus" id="firstvs" type="radio" name="vistorstatus" value="audience:researchers"/>
    <label for="firstvs">Researcher</label>
    <input class="vistorstatus" id="secondvs" type="radio" name="vistorstatus" value="audience:teachersandstudents"/>
    <label for="secondvs">Student or Teacher</label>
    <input class="vistorstatus" checked="checked" id="thirdvs" type="radio" name="vistorstatus" value="audience:all"/>
    <label for="thirdvs">Member of public</label>
<% if $IncludeFormTag %>
	</form>
<% end_if %>
