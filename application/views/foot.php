<div class="container">
	<hr>
		<p>&nbsp;</p>
</div>
</div>

	  
    <script src="<?php echo base_url();?>assets/data/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/data/js/exporting.js"></script>

    
    <script type="text/javascript">
   	$(function() { 
		   // for bootstrap 3 use 'shown.bs.tab', for bootstrap 2 use 'shown' in the next line
		   $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		   // save the latest tab; use cookies if you like 'em better:
		   localStorage.setItem('lastTab', $(this).attr('href'));
		});
		   
		   // go to the latest tab, if it exists:
		   var lastTab = localStorage.getItem('lastTab');
		   if (lastTab) {
		   	$('[href="' + lastTab + '"]').tab('show');
		   }
		});
    </script>
	</body>
</html>