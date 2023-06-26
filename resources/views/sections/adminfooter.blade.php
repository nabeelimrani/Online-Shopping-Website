<script src="{{asset('js/plugins.js')}}"></script>
<script src="{{asset('js/custom.js')}}"></script>
<script type="text/javascript" src="{{asset('DataTables/datatables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('datepicker/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('bundles/sweetalert/sweetalert.min.js')}}"></script>
<script type="text/javascript" src="{{asset('chart/apexcharts.min.js')}}"></script>
<script>
	
$(document).ready(function () {

$(".datepicker").datepicker({
	format: 'yyyy-mm-dd',
	todayHighlight:'TRUE',
autoclose: true,
	});
});
</script>