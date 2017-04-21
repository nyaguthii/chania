$(document).ready(function(){

   
    $( "#policy-form" ).submit(function( event ) {
 
      // Stop form from submitting normally
      event.preventDefault();
      
     
      // Get some values from elements on the page:
      var $form = $( this ),
        '_token': $('input[name=_token]').val(),
        policyNo = $form.find( "input[name='policy-no']" ).val(),
        effectiveDate = $form.find( "input[name='effective-date']" ).val(),
        durationType = $form.find( "input[name='duration-type']" ).val(),
        carrier = $form.find( "input[name='carrier']" ).val(),
        agent = $form.find( "input[name='agent']" ).val(),
        url = $form.attr( "action" );
     
      // Send the data using post
      var posting = $.post( url, { 
        policy_no: policyNo,
        effective_date: effectiveDate,
        duration: durationType,
        carrier: carrier,
        agent: agent
    } );
     
      // Put the results in a div
      posting.done(function( data ) {
        //var content = $( data ).find( "#content" );
        //$( "#result" ).empty().append( content );
        location.reload();
        console.log( data );
      });
    });

    $( "#endorsement-form" ).submit(function( event ) {
 
      // Stop form from submitting normally
      event.preventDefault();
      
     
      // Get some values from elements on the page:
      var $form = $( this ),
        '_token': $('input[name=_token]').val(),
        type = $form.find( "input[name='type']" ).val(),
        amount = $form.find( "input[name='amount']" ).val(),
        description = $form.find( "input[name='description']" ).val(),
        percentage = $form.find( "input[name='percentage']" ).val(),
        url = $form.attr( "action" );
     
      // Send the data using post
      var posting = $.post( url, { 
        type: type,
        amount: amount,
        percentage: percentage
    } );
     
      // Put the results in a div
      posting.done(function( data ) {
        //var content = $( data ).find( "#content" );
        //$( "#result" ).empty().append( content );
        //location.reload();
        console.log( data );
      });
    });
    
    
});
