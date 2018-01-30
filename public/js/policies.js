$(document).ready( function () {
    
        $('#activePoliciesDataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: myurl+"/policies/active/ajax",
            columns: [
            {data: "id"},
            {data: "policy_no"},
            {data: "name"},
            {data: "effective_date"},
            {data: "expiry_date"},
            {data: "total_premium"},
            {data: "registration"},
            {data: "status"},
            {"width": "20%",data: "action", name: "action", orderable: false, searchable: false}
            
            ]
    
        });
        $('#cancelledPoliciesDataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: myurl+"/policies/cancelled/ajax",
            columns: [
                {data: "id"},
                {data: "policy_no"},
                {data: "name"},
                {data: "effective_date"},
                {data: "expiry_date"},
                {data: "total_premium"},
                {data: "registration"},
                {data: "status"},
                {"width": "20%",data: "action", name: "action", orderable: false, searchable: false}
               
            ]
    
        });
        $('#suspendedPoliciesDataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: myurl+"/policies/suspended/ajax",
            columns: [
                {data: "id"},
                {data: "policy_no"},
                {data: "name"},
                {data: "effective_date"},
                {data: "expiry_date"},
                {data: "total_premium"},
                {data: "registration"},
                {data: "status"},
                {"width": "20%",data: "action", name: "action", orderable: false, searchable: false}
                
            ]
    
        });
        $('#expiredPoliciesDataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: myurl+"/policies/expired/ajax",
            columns: [
                {data: "id"},
                {data: "policy_no"},
                {data: "name"},
                {data: "effective_date"},
                {data: "expiry_date"},
                {data: "total_premium"},
                {data: "registration"},
                {data: "status"},
                {"width": "20%",data: "action", name: "action", orderable: false, searchable: false}
            ]
    
        });
});