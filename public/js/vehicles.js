$(document).ready( function () {
    
        $('#insuranceVehiclesDataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: myurl+"/insurance/getvehiclesajax",
            columns: [
            {data: "id"},
            {data: "registration"},
            {data: "name"},
            {data: "action", name: "action", orderable: false, searchable: false}
            ]
    
        });
});