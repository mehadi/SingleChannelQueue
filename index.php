<?php 
// Single Channel Queue Problem In PhP
// Mehadi Hasan
	$servie_time_distribution = array(
			array(
	  			"service_time"=>"1",
	  			"ran_min"=>"1",
	  			"ran_max"=>"10",
	  		),
	  		array(
	  			"service_time"=>"2",
	  			"ran_min"=>"11",
	  			"ran_max"=>"30",
	  		),
	  		array(
	  			"service_time"=>"3",
	  			"ran_min"=>"31",
	  			"ran_max"=>"60",
	  		),
	  		array(
	  			"service_time"=>"4",
	  			"ran_min"=>"61",
	  			"ran_max"=>"85",
	  		),
	  		array(
	  			"service_time"=>"5",
	  			"ran_min"=>"86",
	  			"ran_max"=>"95",
	  		),
	  		array(
	  			"service_time"=>"6",
	  			"ran_min"=>"96",
	  			"ran_max"=>"100",
	  		),

		);
	$time_between_arrival = array(
			array(
	  			"t_between_arrival"=>"1",
	  			"t_ran_min"=>"1",
	  			"t_ran_max"=>"125",
	  		),
	  		array(
	  			"t_between_arrival"=>"2",
	  			"t_ran_min"=>"126",
	  			"t_ran_max"=>"250",
	  		),
	  		array(
	  			"t_between_arrival"=>"3",
	  			"t_ran_min"=>"251",
	  			"t_ran_max"=>"375",
	  		),
	  		array(
	  			"t_between_arrival"=>"4",
	  			"t_ran_min"=>"376",
	  			"t_ran_max"=>"500",
	  		),
	  		array(
	  			"t_between_arrival"=>"5",
	  			"t_ran_min"=>"501",
	  			"t_ran_max"=>"625",
	  		),
	  		array(
	  			"t_between_arrival"=>"6",
	  			"t_ran_min"=>"626",
	  			"t_ran_max"=>"750",
	  		),
	  		array(
	  			"t_between_arrival"=>"7",
	  			"t_ran_min"=>"751",
	  			"t_ran_max"=>"875",
	  		),
	  		array(
	  			"t_between_arrival"=>"8",
	  			"t_ran_min"=>"876",
	  			"t_ran_max"=>"1000",
	  		)
		);
	$rd_for_inter_arrival_time = array("302","915","48","235","15","500","650","423","258","700");
	$rd_for_service_time = array("83","45","74","65","17","79","30","61","89","20");
	$i= 0;
	$r = 0;
	$res = null;
	foreach ($rd_for_service_time as $key) {
		$i++;
		$time_since_last_arrival = 0;
		$arrival_time = 0;
		$service_time = 0;
		$time_service_begins = 0;
		$time_customer_waits_in_queue = 0;
		$time_servie_ends = 0;
		$time_customer_spends_in_system = 0;
		if($r>0){
			$check = $rd_for_inter_arrival_time[$r-1];
			foreach ($time_between_arrival as $val2) {
				if($check >= $val2['t_ran_min'] ){
					if($check <= $val2['t_ran_max'] ){
					$time_since_last_arrival = $val2['t_between_arrival'];
					$arrival_time = $res[$r-1]['arrival_time']+$time_since_last_arrival;
				}
				}	
			}
			foreach ($servie_time_distribution as $val) {
			if (($key >= $val['ran_min'] && $key <= $val['ran_max'])){
				$service_time =  $val['service_time'];
			}
			}
			$time_servie_ends = $arrival_time + $service_time;
			if($res[$r-1]['time_servie_ends'] > $arrival_time){
	  			$time_customer_waits_in_queue = $res[$r-1]['time_servie_ends'] - $arrival_time;
	  			$time_service_begins = $time_customer_waits_in_queue + $arrival_time;
	  			$time_servie_ends = $time_service_begins +  $service_time;
  			}else{
  				$time_service_begins = $arrival_time;
  			}
		}else{

			foreach ($servie_time_distribution as $val) {
			if (($key >= $val['ran_min'] && $key <= $val['ran_max'])){
				$service_time =  $val['service_time'];
				$time_service_begins = $arrival_time;
				$time_servie_ends = $service_time;
			}
			}
		}
		$res[$r]['time_since_last_arrival']=$time_since_last_arrival;
		$res[$r]['arrival_time']= $arrival_time;
		$res[$r]['service_time']= $service_time;
		$res[$r]['time_service_begins']= $time_service_begins;
		$res[$r]['time_customer_waits_in_queue']= $time_customer_waits_in_queue;
		$res[$r]['time_servie_ends']= $time_servie_ends;
		$res[$r]['time_customer_spends_in_system']= $service_time+$time_customer_waits_in_queue;
		$r++;
	}
 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>Single Channel Queue..!!!</title>
 	<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}
td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
 </head>
 <body>
 <table>
	<tr>
		<th>time_since_last_arrival</th>
		<th>arrival_time</th>
		<th>service_time</th>	
		<th>time_service_begins</th>	
		<th>time_customer_waits_in_queue</th>
		<th>time_servie_ends</th>	
		<th>time_customer_spends_in_system</th>				

	</tr>

		<?php foreach ($res as $key) {

					echo "<tr>";
				foreach ($key as $value) {
					echo "<td><center>".$value."</center></td>" ;
				}
			echo "</tr>";
		} ?>
</table>
 </body>
 </html>
<?php
echo "<pre>";
	print_r($res);
echo "</pre>";
?>