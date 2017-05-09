<% if $Photo %>
    <img class="member-image" src="$Photo.Fill(130,158).Link" />
<% else %>
    <img class="member-image" src="mysite/icons/people-fallback.png" />
<% end_if %>
<h2 class="modal-member-title">$Title</h2>
<h2 class="modal-member-firstname">$FirstName</h2>
<h2 class="modal-member-lastname">$LastName</h2>
<h2 class="modal-member-honoraries">$Qualifications</h2>
<div class="clear"></div>
<% if $BiographicalNotes %>
<h2 class="title-modal-member-biography">Biography</h2>
<p class="modal-member-biography">$BiographicalNotes</p>
<% end_if %>
<!--
<h2 class="title-modal-member-grants">Grants recieved</h2>
<p class="modal-member-grants"></p>
<h2 class="title-modal-member-awards">Awards recieved</h2>
<p class="modal-member-awards"></p>
-->