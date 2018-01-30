$(document).ready( function () {

    $('#paymentsDataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: myurl+"/payments/ajax",
        columns: [
        {data: "id"},
        {data: "name"},
        {data: "amount"},
        {data: "transaction_date"},
        {data: "action", name: "action", orderable: false, searchable: false}
        ]

    });

    $('#dailyPaymentsTyresTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: myurl+"/orders/dailypaymentsajax",
        columns: [
        {data: "transaction_date"},
        {data: "amount"}
        ]

    });
    $('#totalAjaxPerDayDataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: myurl+"/payments/dailytotaldayajax",
        columns: [
        {data: "transaction_date"},
        {data: "total"}
        ]

    });
    $('#totalAjaxPerDayDataTable2').DataTable({
        processing: true,
        serverSide: true,
        ajax: myurl+"/payments/dailytotaldayajax2",
        columns: [
        {data: "transaction_date"},
        {data: "paid_from"},
        {data: "total"}
        ]

    });
    $('#totalAjaxPerDayDataTable3').DataTable({
        processing: true,
        serverSide: true,
        ajax: myurl+"/payments/dailytotaldayajax3",
        columns: [
        {data: "transaction_date"},
        {data: "paid_from"},
        {data: "type"},
        {data: "total"}
        ]

    });
    $('#totalAjaxPerDayDataTable4').DataTable({
        processing: true,
        serverSide: true,
        ajax: myurl+"/payments/dailytotaldayajax4",
        columns: [
        {data: "transaction_date"},
        {data: "type"},
        {data: "total"}
        ]

    });
    
    $('#saccoPaymentsDataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: myurl+"/sacco/paymentsAjax",
        columns: [
        {data: "id"},
        {data: "member_id"},
        {data: "name"},
        {data: "amount"},
        {data: "transaction_date"}
        ]

    });
    $('#excessDataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: myurl+"/excess/ajax",
        columns: [
        {data: "id"},
        {data: "name"},
        {data: "amount"},
        {data: "registration"},
        {data: "transaction_date"}
        ]

    });

});   

