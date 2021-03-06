<?php

/**
 *
 * WHMCS Slack
 *
 * A WHMCS addon for sending messages to Slack based on WHMCS hooks.
 *
 * @author     Markus Tenghamn <m@rkus.io>
 * @copyright  Copyright (c) Markus Tenghamn 2018
 * @license    MIT License (https://github.com/markustenghamn/WHMCS-Slack/blob/master/LICENSE)
 * @version    $Id$
 * @link       https://github.com/markustenghamn/WHMCS-Slack
 *
 */

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

global $hooksArray;

$hooksArray = array(
    //Invoice/Quote hooks
    'AddInvoiceLateFee' => array(
        'description' =>'When a late fee is added to an invoice via the cron run.',
        'args' => array('invoiceid'),
        'default' => "Late fee was added for invoice {invoiceid}",
        'channel' => "#sales" //The suggested channel
    ),
    'AddInvoicePayment' => array(
        'description' => 'This hook is run each time a payment is applied to an invoice. This does not mean that the invoice will be completely paid, the payment could just be partial. See InvoicePaid for when an invoice has been fully paid.',
        'args' => array('invoiceid'),
        'default' => "Payment was added for invoice {invoiceid}",
        'channel' => "#sales"
    ),
    'AddTransaction' => array(
        'description' => 'As a transaction is being added to the system. This can be a payment or refund.',
        'args' => array('userid', 'currencyid', 'gateway', 'date', 'description', 'amountin', 'fees', 'amountout', 'rate', 'transid', 'invoiceid', 'refundid', 'id'),
        'default' => "Transaction {transid} was added\nGateway: {gateway}\nAmount: {amountin}",
        'channel' => "#sales"
    ),
    'AdminAreaViewQuotePage' => array(
        'description' => 'As the quote is being edited in the admin area.',
        'args' => array('quoteid'),
        'default' => "Quote {quoteid} is being edited",
        'channel' => "#sales"
    ),
    'InvoiceCancelled' => array(
        'description' => 'This hook runs as an invoice status is changing to Cancelled. This can be from the invoice in the admin area, a mass update action, cancelling an order, a submitted cancellation request or a client disabling the auto renewal of a domain.',
        'args' => array('invoiceid'),
        'default' => "Invoice {invoiceid} was set to Cancelled",
        'channel' => "#sales"
    ),
    'InvoiceChangeGateway' => array(
        'description' => 'As the payment gateway on an invoice is changed. This can be via the admin area on an invoice directly or for the client via the client area.',
        'args' => array('invoiceid', 'paymentmethod'),
        'default' => "Invoice {invoiceid} changed payment method to {paymentmethod}",
        'channel' => "#sales"
    ),
    'InvoiceCreated' => array(
        'description' => 'This hook is run when a new invoice has been generated by the cron, order process, API or when converting a quote to an invoice. The invoice has already been emailed to the client.',
        'args' => array('source', 'user', 'invoiceid'),
        'default' => "Invoice {invoiceid} was created",
        'channel' => "#sales"
    ),
    'InvoicePaid' => array(
        'description' => 'This hook runs as an invoice status is changing from Unpaid to Paid after all automation associated with the invoice has run.',
        'args' => array('invoiceid'),
        'default' => "Invoice {invoiceid} was set to Paid",
        'channel' => "#sales"
    ),
    'InvoicePaymentReminder' => array(
        'description' => 'This hook runs after the Invoice Payment Reminder or Invoice Overdue Notices are sent to the client for an invoice.',
        'args' => array('invoiceid', 'type'),
        'default' => "Invoice {invoiceid} had a payment reminder sent",
        'channel' => "#sales"
    ),
    'InvoiceRefunded' => array(
        'description' => 'This hook runs as an invoice status is changing to Refunded as a refund is being processed on the invoice. This can be done via the admin area either on the invoice or using the Cancel and Refund order button on an order.',
        'args' => array('invoiceid'),
        'default' => "Invoice {invoiceid} was set to Refunded",
        'channel' => "#sales"
    ),
    'InvoiceSplit' => array(
        'description' => 'After an invoice has been split.',
        'args' => array('originalinvoiceid', 'newinvoiceid'),
        'default' => "Invoice {originalinvoiceid} was split and a new invoice was created with the id {newinvoiceid}",
        'channel' => "#sales"
    ),
    'InvoiceUnpaid' => array(
        'description' => 'This hook runs as an invoice status is changing to Unpaid via the Admin area. This can be from a single invoice, or a mass action. The hook runs for each invoice being processed.',
        'args' => array('invoiceid'),
        'default' => "Invoice {invoiceid} was set to Unpaid",
        'channel' => "#sales"
    ),
    'LogTransaction' => array(
        'description' => 'When an entry is added to the gateway log.',
        'args' => array('date', 'gateway', 'data', 'result'),
        'default' => "Transaction was logged via {gateway}\nData: {data}\nResult: {result}",
        'channel' => "#sales"
    ),
    'ManualRefund' => array(
        'description' => 'Run when a manual refund is required. This can be by choice from the refund dropdown on the invoice in the admin area, or forced when attempting to send a refund to a gateway that does not support refunds.',
        'args' => array('transid', 'amount'),
        'default' => "Manual refund needed for transaction {transid} for the amount of {amount}",
        'channel' => "#sales"
    ),
    'QuoteCreated' => array(
        'description' => 'After a quote has been created in the database.',
        'args' => array('quoteid', 'status'),
        'default' => "Quote {quoteid} was set to {status}",
        'channel' => "#sales"
    ),
    'QuoteStatusChange' => array(
        'description' => 'After a quote has been edited.',
        'args' => array('quoteid', 'status'),
        'default' => "Quote {quoteid} was set to {status}",
        'channel' => "#sales"
    ),
    'AcceptQuote' => array(
        'description' => 'As the quote is being accepted via the client area.',
        'args' => array('quoteid', 'invoiceid'),
        'default' => "Quote {quoteid} was set to Accepted",
        'channel' => "#sales"
    ),
    // Shopping Cart hooks
    'AcceptOrder' => array(
        'description' => 'As the order is being accepted via the admin area or API, before any updates are completed.',
        'args' => array('orderid'),
        'default' => "Order {orderid} was set to Accepted",
        'channel' => "#sales"
    ),
    'AddonFraud' => array(
        'description' => 'Updating the addon status to Fraud from the Admin area Services page or via the API.',
        'args' => array('id', 'userid', 'serviceid', 'addonid'),
        'default' => "Addon {addonid} was set to Fraud",
        'channel' => "#sales"
    ),
    'AfterShoppingCartCheckout' => array(
        'description' => 'After the checkout button is pressed, once the order has been added to the database.',
        'args' => array('OrderID', 'OrderNumber', 'ServiceIDs', 'AddonIDs', 'DomainIDs', 'RenewalIDs', 'PaymentMethod', 'InvoiceID', 'TotalDue'),
        'default' => "Checkout finished for order {orderid}",
        'channel' => "#sales"
    ),
    'CancelOrder' => array(
        'description' => 'From the Order page in the Admin area, clicking on the Cancel Order button or via the API. As the order is being cancelled, before any updates are completed.',
        'args' => array('orderid'),
        'default' => "Order {orderid} was set to Cancelled",
        'channel' => "#sales"
    ),
    'DeleteOrder' => array(
        'description' => 'From the Order page in the Admin area, clicking on the Delete Order button or via the API command. As the order is being Deleted, before any updates are completed.',
        'args' => array('orderid'),
        'default' => "Order {orderid} was set to Deleted",
        'channel' => "#sales"
    ),
    'FraudOrder' => array(
        'description' => 'From the Order page in the Admin area, clicking on the Fraud Order button or via the API command. As the order is being set to Fraud, before any updates are completed.',
        'args' => array('orderid'),
        'default' => "Order {orderid} was set to Fraud",
        'channel' => "#sales"
    ),
    'PendingOrder' => array(
        'description' => 'From the Order page in the Admin area, clicking on the Pending Order button or via the API command. As the order is being set to Pending, before any updates are completed.',
        'args' => array('orderid'),
        'default' => "Order {orderid} was set to Pending",
        'channel' => "#sales"
    ),
    'RunFraudCheck' => array(
        'description' => 'Before the fraud check is run on an order.',
        'args' => array('orderid', 'userid'),
        'default' => "Fraud check was run on order id {orderid}",
        'channel' => "#sales"
    ),
    'ShoppingCartValidateDomain' => array(
        'description' => 'When a client submits a domain request through the cart order process.',
        'args' => array('domainoption', 'sld', 'tld'),
        'default' => "Validated a domain in the shopping cart",
        'channel' => "#sales"
    ),
    'AdminServiceEdit' => array(
        'description' => 'Runs when Save Changes is clicked on the service in the Admin area and after the details are saved.',
        'args' => array('userid', 'serviceid'),
        'default' => "Service {serviceid} was updated by {userid}",
        'channel' => "#sales"
    ),
    'CancellationRequest' => array(
        'description' => 'Runs after a cancellation request has been created.',
        'args' => array('userid', 'relid', 'reason', 'type'),
        'default' => "User with id {userid} requested cancellation\n*Reason:* {reason}",
        'channel' => "#sales"
    ),
    'ServiceDelete' => array(
        'description' => 'Runs immediately prior to a service being removed from the database.',
        'args' => array('id'),
        'default' => "Service was removed",
        'channel' => "#sales"
    ),
    'ServiceRecurringCompleted' => array(
        'description' => 'When the number of recurring invoices has been generated for a product according to the product configuration.',
        'args' => array('recurringinvoices', 'serviceid'),
        'default' => "{recurringinvoices} have been generated!",
        'channel' => "#sales"
    ),
    // Module hooks
    'AfterModuleChangePackage' => array(
        'description' => 'Runs after the ChangePackage function has been successfully run.',
        'args' => array('params' => array('accountid', 'serviceid')), //TODO there are a lot of fields here
        'default' => "Package was changed",
        'channel' => "#support"
    ),
    'AfterModuleChangePassword' => array(
        'description' => 'Runs after the ChangePassword function has been successfully run.',
        'args' => array('accountid', 'serviceid', 'userid', 'domain','username', 'password', 'packageid', 'pid', 'serverid', 'type', 'producttype', 'moduletype', 'configoptionX', 'customfields', 'configoptions', 'clientsdetails', 'server', 'serverip', 'serverhostname', 'serverusername', 'serverpassword', 'serveraccesshash', 'serversecure'),
        'default' => "Package was changed",
        'channel' => "#support"
    ),
    // Ticket hooks
    'TicketAdminReply' => array(
        'description' => 'This hook runs as an admin reply is being added to the ticket.',
        'args' => array('ticketid', 'replyid', 'deptid', 'deptname', 'subject', 'message', 'priority', 'admin', 'status'),
        'default' => "*Ticket:{ticketid}* {admin} added a response to '{subject}'\n{message}\n*Status: {status}*",
        'channel' => "#support"
    ),
    'TicketClose' => array(
        'description' => 'As the ticket status is changed to Closed either manually by an admin or via the cron run.',
        'args' => array('ticketid'),
        'default' => "*Ticket:{ticketid}* has been closed",
        'channel' => "#support"
    ),
    'TicketOpen' => array(
        'description' => 'This hook runs as a ticket is being opened by a client (registered or not).',
        'args' => array('ticketid', 'userid', 'deptid', 'deptname', 'message', 'subject', 'priority'),
        'default' => "*Ticket:{ticketid}* has been opened\n*{subject}*\n{message}\nUser id: {userid} - Priority:{priority}",
        'channel' => "#support"
    ),
    'TicketStatusChange' => array(
        'description' => 'As the ticket status is changed manually by an admin.',
        'args' => array('ticketid', 'status', 'adminid'),
        'default' => "*Ticket:{ticketid}* has been changed to {status}",
        'channel' => "#support"
    ),
    'TicketUserReply' => array(
        'description' => 'This hook runs as a user reply is being added to a ticket.',
        'args' => array('ticketid', 'replyid', 'deptid', 'deptname', 'subject', 'message', 'priority', 'admin', 'status'),
        'default' => "*Ticket:{ticketid}* User responded to '{subject}'\n{message}\n*Status: {status}*",
        'channel' => "#support"
    )
);