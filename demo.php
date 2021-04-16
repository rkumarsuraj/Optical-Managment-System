<?php

if($s = $con->prepare($query)){

	$s->bind_param("ssssiis",$flightno,$traveldate,$passportno,$seatno,$fare,$baggageloadlimit,$name);
	$s->execute();
}
else
	echo $con->error;

?>