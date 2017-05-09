<h2>List of funds tailored to you</h2>

<% loop $Funds %>
    <div class="calc-list-item-container">
        <h3 class="calc-item-title">$FundTitle</h3>

        <p class="calc-item-paragraph">$FundContent.LimitCharacters(300)</p>
        <a href="$FundURL" class="calc-item-more-link">Find out more</a>
    </div>
    <div>
        <p>Eligible Subject Areas</p>
        <% loop $subjects %>
            <span style="color: #606060;">$Title, </span>
        <% end_loop %>
    </div>
<% end_loop %>
<div class="clear"></div>