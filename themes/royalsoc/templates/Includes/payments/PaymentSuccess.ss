<div id="SuccessModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <button type="button" class="close" data-dismiss="modal">
                <div class="close-button" data-dismiss="modal">
                </div>
            </button>

            <div class="modal-body">
                
                <% if $FormUsed == book %>
                    <% if $MultiBook == true %>
                        <h2>Thank you $Name for enquiring about $SiteConfig.BookTitle</h2>
                        <p>We will be in touch with you as soon as possible.</p>
                        <p>The contact email we have recorded is: <strong>$EmailAddress</strong></p>
                        <p>Your order ID is: <strong>$OrderID</strong></p>
                        <p>If you have any questions regarding this enquiry, please don't hesitate to contact us.</p>
                        <p>Email: <a href="mailto:$SiteConfig.BookOrderNotificationEmail"><strong>$SiteConfig.BookOrderNotificationEmail</strong></a></p>
                        <p>Number: <a href="tel:$SiteConfig.BookOrderContactNumber"><strong>$SiteConfig.BookOrderContactNumber</strong></a></p>

                    <% else %>

                        <% if $PaymentSuccess == 1 %>

                        <h2>Thank you {$TxnData1} {$TxnData2} for purchasing $SiteConfig.BookTitle</h2>
                        <p>The details of this purchase will be emailed to you shortly.</p>
                        <p>If you have any questions regarding this purchase, please don't hesitate to contact us.</p>
                        <p>Email: <a href="mailto:$SiteConfig.BookOrderNotificationEmail"><strong>$SiteConfig.BookOrderNotificationEmail</strong></a></p>
                        <p>Number: <a href="tel:$SiteConfig.BookOrderContactNumber"><strong>$SiteConfig.BookOrderContactNumber</strong></a></p>
                        <% else_if $PaymentSuccess == 0 %>
                            <h2>Sorry {$TxnData1} {$TxnData2} your purchase has failed</h2>
                            <p>If you have any questions regarding this attempted purchase, please don't hesitate to contact us.</p>
                        <p>Email: <a href="mailto:$SiteConfig.BookOrderNotificationEmail"><strong>$SiteConfig.BookOrderNotificationEmail</strong></a></p>
                        <p>Number: <a href="tel:$SiteConfig.BookOrderContactNumber"><strong>$SiteConfig.BookOrderContactNumber</strong></a></p>
                        <% end_if %>

                    <% end_if%>
                    
                <% else_if $FormUsed == donate %>
                     <% if $PaymentSuccess == 1 %>
                        <h2>Thank you {$TxnData1} {$TxnData2} for your donation of ${$Amount}</h2>
                    <% else_if $PaymentSuccess == 0 %>
                        <h2>Sorry {$TxnData1} {$TxnData2} your donation has failed</h2>
                    <% end_if %>
                <% end_if %>
                


               


                <%--<% if $PaymentSuccess %>--%>
                <%--<h2>Success: $PaymentSuccess</h2>--%>
                <%--<% end_if %>--%>

                <%--<% if $Amount %>--%>
                <%--<h2>Amount: $Amount</h2>--%>
                <%--<% end_if %>--%>

                <%--<% if $AuthCode %>--%>
                <%--<h2>AuthCode: $AuthCode</h2>--%>
                <%--<% end_if %>--%>

                <%--<% if $CardName %>--%>
                <%--<h2>CardName: $CardName</h2>--%>
                <%--<% end_if %>--%>

                <%--<% if $CardNumber %>--%>
                <%--<h2>Card Number: $CardNumber</h2>--%>
                <%--<% end_if %>--%>

                <%--<% if $DateExpiry %>--%>
                <%--<h2>ExpireyDate: $DateExpiry</h2>--%>
                <%--<% end_if %>--%>

                <%--<% if $DpsBillingId %>--%>
                <%--<h2>DpsBillingId: $DpsBillingId</h2>--%>
                <%--<% end_if %>--%>

                <%--<% if $CardHolderName %>--%>
                <%--<h2>CardHolderName: $CardHolderName</h2>--%>
                <%--<% end_if %>--%>

                <%--<% if $DpsTxnRef %>--%>
                <%--<h2>DpsTxnRef: $DpsTxnRef</h2>--%>
                <%--<% end_if %>--%>

                <%--<% if $TxnType %>--%>
                <%--<h2>TxnType: $TxnType</h2>--%>
                <%--<% end_if %>--%>

                <%--<% if $TxnData1 %>--%>
                <%--<h2>TxnData1: $TxnData1</h2>--%>
                <%--<% end_if %>--%>

                <%--<% if $TxnData2 %>--%>
                <%--<h2>TxnData2: $TxnData2</h2>--%>
                <%--<% end_if %>--%>

                <%--<% if $TxnData3 %>--%>
                <%--<h2>TxnData3: $TxnData3</h2>--%>
                <%--<% end_if %>--%>

                <%--<% if $CurrencySettlement %>--%>
                <%--<h2>CurrencySettlement: $CurrencySettlement</h2>--%>
                <%--<% end_if %>--%>

                <%--<% if $ClientInfo %>--%>
                <%--<h2>ClientInfo: $ClientInfo</h2>--%>
                <%--<% end_if %>--%>

                <%--<% if $TxnId %>--%>
                <%--<h2>TxnId: $TxnId</h2>--%>
                <%--<% end_if %>--%>

                <%--<% if $CurrencyInput %>--%>
                <%--<h2>CurrencyInput: $CurrencyInput</h2>--%>
                <%--<% end_if %>--%>


                <%--<% if $EmailAddress %>--%>
                <%--<h2>EmailAddress: $EmailAddress</h2>--%>
                <%--<% end_if %>--%>

                <%--<% if $MerchantReference %>--%>
                <%--<h2>MerchantReference: $MerchantReference</h2>--%>
                <%--<% end_if %>--%>

                <%--<% if $ResponseText %>--%>
                <%--<h2>ResponseText: $ResponseText</h2>--%>
                <%--<% end_if %>--%>

                <%--<% if $TxnMac %>--%>
                <%--<h2>TxnMac: $TxnMac</h2>--%>
                <%--<% end_if %>--%>

            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>