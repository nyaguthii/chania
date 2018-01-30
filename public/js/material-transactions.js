$(document).ready( function () {
    
        $('#materialTransactionsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: myurl+"/inoutajax",
            columns: [
            {data: "id"},
            {data: "name"},
            {data: "type"},
            {data: "quantity"},
            {data: "unit_price"},
            {data: "transaction_date"},
            {data: "action", name: "action", orderable: false, searchable: false}
            ]
    
        });
    });   