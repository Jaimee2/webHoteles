<?php


	include "../modelo.php";

	// Directorio de subida
	$target_dir = '../fotos/subiendo/'; 

	$request = 1;
	if(isset($_POST['request'])){
		$request = $_POST['request'];
	}

	// Subir archivo
	if($request == 1){

		$trozos = explode("/", $_FILES["file"]["type"]);
		$target_file = $target_dir . basename($_FILES["file"]["name"]);

		$msg = "";

		$nombreFoto = basename($_FILES["file"]["name"]) . '.' . $trozos[1];

		$rutaBD = 'fotos/subiendo/' . $nombreFoto;

		if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir.$_FILES['file']['name'] . "." . $trozos[1])) {
		    mGuardarFotoSubiendo($nombreFoto, $rutaBD);
		    $msg = "Successfully uploaded";

		} else{
		    $msg = "Error while uploading";
		}

		echo $msg;
	}

	// Eliminar archivo
	if($request == 2){
		$filename = $target_dir.$_POST['name']; 
		$files = glob($filename.'*');
		foreach ($files as $file) {
			mBorrarFotoSubida($_POST['name']);
			unlink($file);exit;
		}

	}


?>
