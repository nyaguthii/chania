$(document).ready( function () {
    $('#ordersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: myurl+"/orders/ajax",
        columns: [
        {data: "id"},
        {data: "customer_id"},
        {data: "customer"},
        {data: "date"},
        {data: "amount"},
        {data: "total_cost"},
        {data: "profit"},
        {data: "action", name: "action", orderable: false, searchable: false}
        ]

    });
    $('#dailySalesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: myurl+"/orders/dailysalesajax",
        columns: [
        {data: "transaction_date"},
        {data: "amount"}       
        ]

    });
    $('#tyreDifferenceTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: myurl+"/tyres/differenceajax",
        columns: [
        {data: "id"},
        {data: "member_id"},   
        {data: "name"},
        {data: "payments"}, 
        {data: "credits"},
        {data: "balance"},
        ]

    });

    
     $('#customers-select2').select2();
     $('#products-select2').select2();

        var counter = 0;
     
         $("#sales_add_line").on("click", function () {

            var transaction_date = $('#datepicker').val();
            var customer = $('#customers-select2').val();
            var selling_price = $('#selling_price').val();
            var product = $('#products-select2').val();
            var quantity = $('#quantity').val();
            var payment_method = $('#payment_method').val();
            if(!transaction_date){
                alert('Please give a transaction Date.');
                return false;
            }
            if(! selling_price ){
                alert('Please Put Selling Price.');
                return false;
            }
            if(!/^\d+$/.test(selling_price)) {
                alert('Selling price should be an integer.');
                return false;
            }
            if(! product ){
                alert('Please select a Product.');
                return false;
            }
            if(! quantity ){
                alert('Quantity must be greated than zero.');
                return false;
            }
            if(!/^\d+$/.test(quantity)) {
                alert('Quantity should be an integer.');
                return false;
            }

             var newRow = $("<tr>");
             var cols = "";
     
             cols += '<td><input  name="product[]" value="'+product+'" class="products-select2 disable form-control  ' + counter + '"></td>';
             cols += '<td><input name="selling_price[]" type="text" value="'+selling_price+'" class="disable form-control" ' + counter + '"></td>';
             cols += '<td><input name="quantity[]" type="text" value="'+quantity+'" class="disable form-control" ' + counter + '"></td>';
             cols += '<td><input name="total[]" type="text" value="'+selling_price*quantity+'" class="disable form-control"' + counter + '"></td>';
             cols += '<td><a class="ibtnDel btn btn-md btn-danger "  ><i class="fa fa-trash-o"></i>Delete</a></td>';
             newRow.append(cols);
             $(".ordersTable").append(newRow);
             counter++;

             $('#datepicker').prop('readonly', 'readonly');
             $('#customers-select2 option:not(:selected)').prop('disabled', true);
             //$('#payment_method').attr('disabled', true);
             $('#quantity').val('');
             $('#selling_price').val('');
             $('#quantity').focus();
             //$('.disable').attr('disabled',true);
         });
     
     
     
         $(".ordersTable").on("click", ".ibtnDel", function (event) {
             $(this).closest("tr").remove();       
             counter -= 1
         });

         $('.products-select2').select2({
            placeholder: 'Select an item',
            ajax: {
              url: myurl+"/productsajax",
              dataType: 'json',
              delay: 250,
              processResults: function (data) {
                return {
                  results:  $.map(data, function (product) {
                        return {
                            text: product.name,
                            id: product.id
                        }
                    })
                };
              },
              cache: true
            }
          });
      
    $(document).on('click', '#sales_add_liness', function(event) {
            var transaction_date = $('#datepicker').val();
            var customer = $('#customers-select2').val();
            var selling_price = $('#selling_price').val();
            var product = $('#products-select2').val();
            var quantity = $('#quantity').val();
            var payment_method = $('#payment_method').val();
            if(!transaction_date){
                alert('Please give a transaction Date.');
                return false;
            }
            if(! selling_price ){
                alert('Please Put Selling Price.');
                return false;
            }
            if(! product ){
                alert('Please select a Product.');
                return false;
            }
            if(! quantity ){
                alert('Quantity must be greated than zero.');
                return false;
            }
            if(! payment_method ){
                alert('Select Payment Method.');
                return false;
            }
            $.ajax({
                type: "POST",
                url: "inventory/sales_save",
                data: {sales_no: sales_no, sales_date: sales_date, customer_id: customer_id, item_id: item_id, quantity: quantity, price: price, notes: notes},
                success: function(msg) {
                    //alert(msg);
                    if( msg == "insufficient"){
                        alert("Insufficiant Stock!");
                    } else {
                        $("#sales_details").children().remove();
                        $("#sales_details").html(msg);
                        $("#sample_1").dataTable({
                            "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
                            "sPaginationType": "bootstrap",
                            "oLanguage": {
                                "sLengthMenu": "_MENU_ records per page",
                                "oPaginate": {
                                    "sPrevious": "Prev",
                                    "sNext": "Next"
                                }
                            },
                            "aoColumnDefs": [{
                                'bSortable': false,
                                'aTargets': [0]
                            }]
                        });
                    }
    
                }
            });
            $('#transaction_date').attr('disabled', true);
            $('#payment_method').attr('disabled', true);
            $('#quantity').val('');
            $('#price').val('');
            $('#quantity').focus();
        });
     
  
});

function calculateRow(row) {
    var price = +row.find('input[name^="price"]').val();

}

function calculateGrandTotal() {
    var grandTotal = 0;
    $(".ordersTable").find('input[name^="price"]').each(function () {
        grandTotal += +$(this).val();
    });
    $("#grandtotal").text(grandTotal.toFixed(2));
}

