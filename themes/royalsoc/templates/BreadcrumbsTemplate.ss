<a class="bc-parent" href="">Home </a>
<%-- Loop is all on one line to prevent whitespace bug in older versions of IE --%>
<% if $Pages %>
	<% loop $Pages %>
		<% if $Last %>
			<a class="bc-active" >$MenuTitle.XML </a>
		<% else %>
			<a href="$Link" class="bc-parent">$MenuTitle.XML </a>
		<% end_if %>
	<% end_loop %>
<% end_if %>