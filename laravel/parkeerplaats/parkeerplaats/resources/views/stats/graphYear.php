<!-- <?php
 
 $dataPoints = [];
 for($i=0;$i<= count($years)-1;$i++){
     $yearData = array("label"=> $years[$i], "y"=> $yearAutos[$i]);
     array_push($dataPoints, $yearData);
 }
     
 ?>
<script>
window.onload = function () {
 
var chart2 = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "dark2",
    backgroundColor: "#18181c",
	title:{
		text: "Auto's per jaar"
	},
	axisX:{
		crosshair: {
			enabled: true,
			snapToDataPoint: true
		}
	},
	axisY:{
		title: "aantal",
		includeZero: true,
		crosshair: {
			enabled: true,
			snapToDataPoint: true
		}
	},
	toolTip:{
		enabled: false
	},
	data: [{
		type: "area",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart2.render();
}
</script> -->