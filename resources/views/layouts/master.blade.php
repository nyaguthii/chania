
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Chania Sacco</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->

  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <!-- Ionicons -->
 
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->

  <script>
    var myurl = "{{url('/')}}";
  </script>    
  <link rel="stylesheet" href="{{ asset('css/_all-skins.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/datepicker3.css') }}">
  <link rel="stylesheet" href="{{ asset('css/flash.css') }}">
  <link rel="stylesheet" href="{{ asset('css/receipt.css') }}">
  <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

@include('layouts.header')
  <!-- Left side column. contains the logo and sidebar -->
 
 <!-- sidebar menu: : style can be found in sidebar.less -->
@include('layouts.nav')

  <!-- Content Wrapper. Contains page content -->
@yield('content')
  <!-- /.content-wrapper -->
  <!-- /.footer -->
@include('layouts.flash')
@include('layouts.footer')  

</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<!-- Slimscroll -->
<script src="{{ asset('js/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('js/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('js/app.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('js/demo.js') }}"></script>
<script src="{{ asset('js/fastclick.js') }}"></script>
<script src="{{ asset('js/sing.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{ asset('js/bootstrap-datepicker.js')}}"></script>
<script src="{{ asset('js/jquery.validate.min.js')}}"></script>
<script src="{{ asset('js/select2.full.min.js')}}"></script>
<script src="{{ asset('js/products.js')}}"></script>
<script src="{{ asset('js/orders.js')}}"></script>
<script src="{{ asset('js/material-transactions.js')}}"></script>
<script src="{{ asset('js/payments.js')}}"></script>
<script src="{{ asset('js/members.js')}}"></script>
<script src="{{ asset('js/refunds.js')}}"></script>
<script src="{{ asset('js/suspensions.js')}}"></script>
<script src="{{ asset('js/cancellations.js')}}"></script>
<script src="{{ asset('js/policies.js')}}"></script>
<script src="{{ asset('js/vehicles.js')}}"></script>
<script src="{{ asset('js/commissions.js')}}"></script>
<script src="{{ asset('js/claims.js')}}"></script>
<script>
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          'CONTENT_TYPE':'application/json'
      }
  });
  $(function () {
    
    $("#example1").DataTable();
    $('#isPayDaily').prop('checked', false);
    $('#datepicker').datepicker({
      autoclose: true
    });
    $('#suspenddatepicker').datepicker({
      autoclose: true
    });
    $('#activatedatepicker').datepicker({
      autoclose: true
    });
    $('#sustaindatepicker').datepicker({
      autoclose: true
    });
    $('#endDate').datepicker({
      autoclose: true
    });
    $('#datepicker-endorsement').datepicker({
      autoclose: true
    });
    $('#accidentdatepicker').datepicker({
      autoclose: true
    });
    $('#todatepicker').datepicker({
      autoclose: true
    });  

    $("#commission-percent").change(function(){

      
       var amount = $( "#endorsement-amount" ).val();
       var percent= $( "#commission-percent" ).val();

       var commission = (percent/100)*amount;

       $( "#commission-amount" ).val(String(commission));
       
    });

    $('#duration').change(function(){
      getExpiryDate();
    });
    $('#datepicker').change(function(){

      getExpiryDate();
    });
    $('#flash').delay(500).fadeIn('normal', function() {
         $(this).delay(2500).fadeOut();
    });
    $('#cashierVehiclesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax:"{!!route('vehicles.ajax')!!}",
            columns: [
            {data: "id"},
            {data: "registration"},
            {data: "name"},
            {data: "action", name: "action", orderable: false, searchable: false}
            ]

        });
    
    function getExpiryDate(){

      var x=0;
      var period=$('#duration').val();

        switch (period) {
          case 'Annual':
              x = 12;
              break;
          case 'Ten Months':
              x = 10;
              break;
          case 'Semi Annual':
              x = 6;
              break;
          case 'Quartely':
              x = 3;
              break;
          case 'Monthly':
              x = 1;
              
      } 
      var d = new Date($('#datepicker').val() );
       //x=x+1;
      d.setMonth(d.getMonth()+x);
      //d.setDate(d.getDate()+1)    
        $("#expiry-date").val(d.getMonth()+"/"+d.getDate()+"/"+d.getFullYear());
  
        //alert(d.getMonth()+"/"+d.getDate()+"/"+d.getFullYear());
        
    }
    $('#isPayDaily').bind('change', function () {

       if ($(this).is(':checked')){

         $("#remaining-payments").val(1);
         //$("#remaining-payments").val('');
         $("#remaining-payments").hide();
       }

       else{
         $("#remaining-payments").show();
         $("#remaining-payments").val('');

       }
    });

 
       
 


  });
  

</script>
</body>
</html>