<div id="contactModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">

	        <button type="button" class="close" data-dismiss="modal">
		        <div class="close-button" data-dismiss="modal">
		        </div>
	        </button>
			<% if $IncludeFormTag %>
				<div class="modal-body">
				    <h2>Contact us</h2>
				    <form $AttributesHTML>
						<% end_if %>
							<% if $Message %>
							<p id="{$FormName}_error" class="message $MessageType">$Message</p>
							<% else %>
							<p id="{$FormName}_error" class="message $MessageType" style="display: none"></p>
							<% end_if %>

							<fieldset>
								<% if $Legend %><legend>$Legend</legend><% end_if %>
								<% loop $Fields %>
									$FieldHolder
								<% end_loop %>
								<div class="clear"><!-- --></div>
							</fieldset>

							<% if $Actions %>
							<div class="Actions button-outer">
								<% loop $Actions %>
									$Field
								<% end_loop %>
							</div>
							<% end_if %>
						<% if $IncludeFormTag %>
					</form>
				  </div>
				  <div class="clear"></div>
			<% end_if %>
		</div>
	</div>
</div>