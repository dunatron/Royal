<div id="bookModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">

	        <button type="button" class="close" data-dismiss="modal">
		        <div class="close-button" data-dismiss="modal">
		        </div>
	        </button>
			<% if $IncludeFormTag %>
				<div class="modal-body">

					
				    <form $AttributesHTML>
						<% end_if %>
							<% if $Message %>
							<p id="{$FormName}_error" class="message $MessageType">$Message</p>
							<% else %>
							<p id="{$FormName}_error" class="message $MessageType" style="display: none"></p>
							<% end_if %>

							<fieldset style="background-color:#e1e1e1; padding:15px;">
								<p><strong>Title: </strong>$SiteConfig.BookTitle</p>
								<p><strong>Author: </strong>$SiteConfig.BookAuthor</p>
								<p><strong>Summary: </strong>$SiteConfig.BookIntro</p>
							</fieldset>

							<fieldset>
								<% if $Legend %><legend>$Legend</legend><% end_if %>
								<% loop $Fields %>
									$FieldHolder
								<% end_loop %>
								<div class="clear"><!-- --></div>
								<label class="qty-label hide left">You have requested to order multiple books. You will be contacted directly about your order to combine postage.</label>
								<div class="clear"><!-- --></div>
								<br/><br/>
							</fieldset>

							<table class="resultTable">
								<tr>
									<td class="orderFormTitle">Unit price: </td>
									<td class="orderFormVal">$<span id="orderFormUnitPrice">$SiteConfig.BookPrice</span></td>
								</tr>
								<tr>
									<td class="orderFormTitle">Shipping: </td>
									<td class="orderFormVal"><span id="orderFormUnitShipping">$ $SiteConfig.ShipPriceNZ</span></td>
								</tr>
								<tr>
									<td class="orderFormTitle"><strong>Total: </strong></td>
									<td class="orderFormVal"><strong><span id="orderFormUnitTotal"></span></strong></td>
								</tr>
							</table>
							
							

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