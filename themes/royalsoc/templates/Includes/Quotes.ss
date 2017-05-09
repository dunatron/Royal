<% if $ShowQuotes == 1 %> <!-- Boolean check 1=True -->
    <% loop $QuoteGenerator %>
        <div class="side-right lrg-col-4">
            <div class="quote-block">
                <div class="quote-person">
                    <p class="quote-name">$Person</p>
                    <p class="quote-title">$Title</p>
                </div>
                <div class="quote-text">
                    <p>$Quote</p>
                </div>
            </div>
        </div>
    <% end_loop %>
<% end_if %>