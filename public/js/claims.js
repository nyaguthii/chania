$(document).ready( function () {
    
        $('#claimsDataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: myurl+"/claims/ajax",
            columns: [
            {data: "id"},
            {data: "accident_date"},
            {data: "name"},
            {data: "registration"},
            {data: "policy_no"},
            {data: "driver_name"},
            {data: "driver_contact"},
            {data: "action", name: "action", orderable: false, searchable: false}
            ]
    
        });
});