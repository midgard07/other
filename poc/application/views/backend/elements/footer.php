	<div id="footer">
      <div class="container">
		<div id="android_ready" class="android" data-toggle="tooltip" title="Android Device Ready"></div>
		<div id="html5_ready" class="html5" data-toggle="tooltip" title="HTML 5 Based"></div>
        
		<p class="text-muted credit">&copy; 2015 <!--<a href="http://www.ilcs.co.id" target="_blank">PT. Integrasi Logistik Cipta Solusi</a>-->. Icons by: <a href="http://glyphicons.com" target="_blank">Glyphicons</a></p>
		
	  </div>
    </div>
    
	<div id="android_browser_ready"></div>
	<div id="powered_by_html5"></div>
	
	
	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="<?php echo base_url('assets/js/jquery-2.0.3.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap-datepicker.js') ?>"></script>
	
	<script type="text/javascript">
	$(document).ready(function(){
		$('#android_ready, #html5_ready, .floated_tooltip').tooltip().show();
		
	
		$.fn.datepicker.dates['id'] = {
			days: ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"],
			daysShort: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab", "Min"],
			daysMin: ["Mg", "Sn", "Se", "Rb", "Km", "Jm", "Sa", "Mg"],
			months: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
			monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
			today: "Hari Ini",
			clear: "Bersihkan"
		};
		
		$('.date').datepicker({
			startDate : new Date(),
			autoclose: true,
			weekStart : 1,
			forceParse : true,
			language : 'id',
			orientation : 'top auto',
			format : 'yyyy-mm-dd'
		});
	});
	</script>