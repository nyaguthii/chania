
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>AdminLTE 2 | Simple Tables</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="/css/_all-skins.min.css">
  <link rel="stylesheet" href="/css/datepicker3.css">
  <link rel="stylesheet" href="/css/flash.css">
  <link rel="stylesheet" href="/css/dataTables.bootstrap.css">

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
<script src="/js/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="/js/bootstrap.min.js"></script>
<!-- Slimscroll -->
<script src="/js/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/js/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/js/demo.js"></script>
<script src="/js/bootstrap-datepicker.js"></script>
<script src="/js/sing.js"></script>
<script src="/js/jquery.dataTables.min.js"></script>
<script src="/js/dataTables.bootstrap.min.js"></script>
<script>
    

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