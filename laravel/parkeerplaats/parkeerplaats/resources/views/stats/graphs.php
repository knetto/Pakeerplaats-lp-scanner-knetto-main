<?php
 
 $dataPoints = [];
 sort($months);

 
 for($i=0;$i<= count($months)-1;$i++){

	$month_name = date("F", mktime(0, 0, 0, $months[$i], 10));

	
     $monthData = array("label"=> $month_name, "y"=> $monthAutos2[$months[$i]]);

	
     array_push($dataPoints, $monthData);
 }
     
 ?>
<script>
window.onload = function () {
 
var chart1 = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "dark2",
    backgroundColor: "#18181c",
	title:{
		text: "Auto's per maand"
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

<?php
 
 $dataPoints = [];
 for($i=0;$i<= count($years)-1;$i++){
     $yearData = array("label"=> $years[$i], "y"=> $yearAutos2[$years[$i]]);
     array_push($dataPoints, $yearData);
 }
     
 ?>

var chart2 = new CanvasJS.Chart("chartContainer1", {
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
chart1.render();
}
</script>