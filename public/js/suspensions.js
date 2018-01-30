$(document).ready( function () {
    
        $('#suspensionsDataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: myurl+"/suspensions/ajax",
            columns: [
            {data: "id"},
            {data: "effective_date"},
            {data: "name"},
            {data: "registration"},
            {data: "policy_no"}
            ]
    
        });
});