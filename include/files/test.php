<?php
//

	$date= time();
	$date_m=strftime("%m", $date);//moi
	$date_H=strftime("%H", $date);//heur
	$date_d=strftime("%d", $date);//jour
	$date_M=strftime("%M", $date);//minute
	$date_y=strftime("%Y", $date);//minute
	
	// en minute : H*60
	$minute_flood = strftime("%Y", $date).strftime("%m", $date).(strftime("%H", $date)*60)+(strftime("%M", $date))+(strftime("%H", $date)*24*60);
	echo $date_m;
	echo '<br>';
	echo $date_H;
	echo '<br>';
	echo $date_d;
	echo '<br>';
	echo $date_M;
	echo '<br>';
	echo $date_y;

?>


