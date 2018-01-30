$(document).ready( function () {
    
        $('#membersDataTableCashier').DataTable({
            processing: true,
            serverSide: true,
            ajax: myurl+"/customers/membersajax",
            columns: [
            {data: "id"},
            {data: "member_id"},
            {data: "name"},
            {data: "action", name: "action", orderable: false, searchable: false}
            ]
    
        });
        $('#nonMembersDataTableCashier').DataTable({
            processing: true,
            serverSide: true,
            ajax: myurl+"/customers/nonmembersajax",
            columns: [
            {data: "id"},
            {data: "name"},
            {data: "action", name: "action", orderable: false, searchable: false}
            ]
    
        });
        $('#membersDataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: myurl+"/members/getmembersajax",
            columns: [
            {data: "id"},
            {data: "member_id"},
            {data: "name"},
            {data: "contact"},
            {data: "address"},
            {data: "action", name: "action", orderable: false, searchable: false}
            ]
    
        });
        $('#nonMembersDataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: myurl+"/members/getnonmembersajax",
            columns: [
            {data: "id"},
            {data: "name"},
            {data: "contact"},
            {data: "address"},
            {data: "action", name: "action", orderable: false, searchable: false}
            ]
    
        });
        $('#insuranceMembersDataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: myurl+"/insurance/getmembersajax",
            columns: [
            {data: "id"},
            {data: "member_id"},
            {data: "name"},
            {data: "contact"},
            {data: "address"},
            {data: "action", name: "action", orderable: false, searchable: false}
            ]
    
        });
        $('#insuranceNonMembersDataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: myurl+"/insurance/getnonmembersajax",
            columns: [
            {data: "id"},
            {data: "name"},
            {data: "contact"},
            {data: "address"},
            {data: "action", name: "action", orderable: false, searchable: false}
            ]
    
        });
        $('#tyreCustomersDataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: myurl+"/customers/tyres/ajax",
            columns: [
            {data: "id"},
            {data: "name"},
            {data: "contact"},
            {data: "address"},
            {data: "action", name: "action", orderable: false, searchable: false}
            ]
    
        });
        $('#saccoCustomersDataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: myurl+"/sacco/customersAjax",
            columns: [
            {data: "id"},
            {data: "member_id"},
            {data: "name"},
            {data: "contact"},
            {data: "action", name: "action", orderable: false, searchable: false}
            ]
    
        });
    });   