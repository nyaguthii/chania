$(document).ready( function () {
    
        $('#monthlyCommissionsDataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: myurl+"/commissions/monthlyajax",
            columns: [
            {data: "month"},
            {data: "carrier"},
            {data: "amount"}
            ]
    
        });

        $('#yearlyCommissionsDataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: myurl+"/commissions/yearlyajax",
            columns: [
            {data: "year"},
            {data: "carrier"},
            {data: "amount"}
            ]
    
        });
});