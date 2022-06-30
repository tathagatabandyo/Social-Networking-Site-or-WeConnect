<?php
	if($_SERVER['REQUEST_METHOD'] == "POST") {
		if(isset($_POST['file_name'])) {
			$file = $_POST['file_name'];
			// $file = "1653302115_2159_index.html";
		
			header("Content-Disposition: attachment; filename=".urlencode($file));
		
			// $fb = fopen("message_i_v_d/".$file,"r");
			// while(!feof($fb)) {
			// 	echo fread($fb,filesize("message_i_v_d/".$file));
			// 	flush();
			// }
			// fclose("message_i_v_d/".$file);
		
			header('Content-Type: application/octet-stream');
			header('Content-Description: File Transfer');
		
			// header('Content-Description: attachment; filename='.basename($file));
		
			header('Expires: 0');
		
			header('Cache-Control: must-revalidate');
			header('Pragma:public');
		
			header('Content-Length:'.filesize("message_i_v_d/".$file));
		
			readfile("message_i_v_d/".$file);
		}
	}

	// $newCount = 
?>