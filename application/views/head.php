<!DOCTYPE HTML>
<html>
<head>
  <title>KLINIK GET MEDIK</title>

  <link rel="shortcut icon" href="<?php echo base_url();?>assets/img/web.png">
  <link href="<?php echo base_url();?>assets/data/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/data/css/datepicker3.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/data/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/data/plugin/fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/data/plugin/easyautocomplete/easy-autocomplete.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/data/plugin/easyautocomplete/easy-autocomplete.themes.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/data/css/select2.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/data/css/select2.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/data/plugin/dataTables/datatables.min.css" rel="stylesheet">

  <style type="text/css">
  body{ padding: 70px 0px; }


</style>



<script type="text/javascript" async="" src="<?php echo base_url();?>assets/data/js/script.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>assets/data/js/jquery-1.8.3.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/data/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/data/js/bootstrap-datepicker3.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/data/plugin/bootstrap-filestyle-1.2.1/src/bootstrap-filestyle.js">"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/data/plugin/fancybox/jquery.easing-1.3.pack.js">"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/data/plugin/fancybox/jquery.fancybox-1.3.4.js">"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/data/plugin/fancybox/jquery.mousewheel-3.0.4.pack.js">"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/data/plugin/easyautocomplete/jquery.easy-autocomplete.min.js">"></script>

<script type="text/javascript" src="<?php echo base_url();?>assets/data/js/select2.js">"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/data/js/select2.min.js">"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/data/js/select2.full.js">"></script>  
<script type="text/javascript" src="<?php echo base_url();?>assets/data/js/select2.full.min.js">"></script>  

<script type="text/javascript" src="<?php echo base_url();?>assets/data/plugin/dataTables/datatables.min.js">"></script>  

<script type="text/javascript">

  window.setTimeout(function(){
    $("#pesan").fadeOut(800,0).slideUp(800, function(){
     $(this).remove();
   })
  }, 2000);
  $(":file").filestyle('ButtoText', 'Pilih');  

  // $(document).ready(function() {
  //   $("a.fancyimg").fancybox();
  // });

  /*
  $(document).ready(function() {
    $("a.fancyimg").fancybox({
      console.log('testing');
      'onComplete': function() { // for v2.0.6+ use : 'beforeShow' 
      var win=null;
      var content = $('#fancybox-content'); // for v2.x use : var content = $('.fancybox-inner');
    
    $('#fancybox-outer').append('<div id="fancy_print"></div>'); // for v2.x use : $('.fancybox-wrap').append(...
    
    $('#fancy_print').bind("click", function(){
      win = window.open("width=200,height=200");
      self.focus();
      win.document.open();
      win.document.write('<'+'html'+'><'+'head'+'><'+'style'+'>');
      win.document.write('body, td { font-family: Verdana; font-size: 10pt;}');
      win.document.write('<'+'/'+'style'+'><'+'/'+'head'+'><'+'body'+'>');
      win.document.write(content.html());
      win.document.write('<'+'/'+'body'+'><'+'/'+'html'+'>');
      win.document.close();
      win.print();
      win.close();
    }); // bind
  } //onComplete
 }); // fancybox
}); //  ready
*/
  
  $(document).ready(function() {
    $('a.fancyimg').fancybox({
      'onComplete': function() {
        var win = null;
        var content = $('#fancybox-content');

        $('#fancybox-outer').append('<div id="fancy_print"></div>');

        $('#fancy_print').bind("click", function(){
          win = window.open("width=200,height=200");
          self.focus();
          win.document.open();
          win.document.write('<'+'html'+'><'+'head'+'><'+'style'+'>');
          win.document.write('body, td { font-family: Verdana; font-size: 10pt;}');
          win.document.write('<'+'/'+'style'+'><'+'/'+'head'+'><'+'body'+'>');
          win.document.write(content.html());
          win.document.write('<'+'/'+'body'+'><'+'/'+'html'+'>');
          win.document.close();
          win.print();
          win.close();
        });
      }
    });
  });


  $(document).ready(function () {
    $('.select2').select2({
      placeholder:'pilih data',
      width: '100%' 
    });
    $('.data-table').dataTable({
      retrieve: true
    });

    $('#master-diagnosa').DataTable({
        "ajax": {
            url : "<?= site_url() ?>/master_diagnosa/get_items",
            type : 'GET'
        },
    });

    $('#master-tindakan').DataTable({
        "ajax": {
            url : "<?= site_url() ?>/master_tindakan/get_items",
            type : 'GET'
        },
    });

  });

   $(function() { 
   $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
   localStorage.setItem('lastTab', $(this).attr('href'));
});
   
   var lastTab = localStorage.getItem('lastTab');
   if (lastTab) {
      $('[href="' + lastTab + '"]').tab('show');
   }
});
</script>

</head>