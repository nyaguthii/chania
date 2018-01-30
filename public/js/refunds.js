$(document).ready( function () {
    
        $('#refundsDataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: myurl+"/refunds/ajax",
            columns: [
            {data: "id"},
            {data: "reference"},
            {data: "policy_no"},
            {data: "name"},
            {data: "amount"},
            {data: "registration"},
            {data: "action", name: "action", orderable: false, searchable: false}
            ]
    
        });
});