$(document).ready( function () {
    
        $('#cancellationsDataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: myurl+"/cancellations/ajax",
            columns: [
            {data: "id"},
            {data: "effective_date"},
            {data: "name"},
            {data: "registration"},
            {data: "policy_no"}
            ]
    
        });
});