<?php



	function vMostrarCabecera($usuarioIniciado,$vista){

		$pagina = file_get_contents($vista);

		if($usuarioIniciado){
            //implementar despues de generar la bbdd
			$pagina = str_replace("##direccionOp1##","index.php?accion=acta&id=1",$pagina);
            $pagina = str_replace("##op1##","Crear Reseña",$pagina);

            $pagina = str_replace("##direccionOp2##","index.php?accion=usuario&id=5",$pagina);
            $pagina = str_replace("##op2##","Cerrar Sesion",$pagina);

			
			$pagina = str_replace("##direccionOp3##","index.php?accion=acta&id=7",$pagina);
            $pagina = str_replace("##op3##","Ver/editar Mis Reseñas",$pagina);

			$pagina = str_replace("##direccionOp4##","index.php?accion=usuario&id=6",$pagina);
            $pagina = str_replace("##op4##","Informacion de usuario",$pagina);
			
			$nick = $_SESSION['nick'];
	
			$pagina = str_replace("##nick##", $nick, $pagina);

		
        }else{
            $pagina = str_replace("##direccionOp2##","index.php?accion=usuario&id=3",$pagina);
            $pagina = str_replace("##op2##","Iniciar sesion",$pagina);

            $pagina = str_replace("##direccionOp4##","index.php?accion=usuario&id=1",$pagina);
            $pagina = str_replace("##op4##","Registrarse",$pagina);
			
			$opcion1 = '';
			
			$pagina = str_replace("##op1##", $opcion1, $pagina);
			$opcion3 = '';
			
			$pagina = str_replace("##op3##", $opcion3, $pagina);
			
			$nick = "Usuario no iniciado";
	
			$pagina = str_replace("##nick##", $nick, $pagina);
        }

		return $pagina;

	}





    //funcion que muestra la pagina de inicio pagina de inicio
    function vMostrarPrincipal($usuarioIniciado,$acta,$fotosActa,$Rpaises){

		$vista = "vistas/principal.html";
        $pagina = file_get_contents($vista);
        
        $pagina = vMostrarCabecera($usuarioIniciado,$vista);
		

		//buscador----------
			//select pais
			$trozosfilapais = explode("##filapais##", $pagina);
			$cuerpoPais="";
			while ($paises = $Rpaises->fetch_assoc()){
				$aux = $trozosfilapais[1];

				$aux = str_replace("##idpais##", $paises["idpais"], $aux);
				$aux = str_replace("##pais##", $paises["nombre"], $aux);
			
				$cuerpoPais .= $aux;
			}

			$pagina = $trozosfilapais[0] .$cuerpoPais . $trozosfilapais[2];
		//-----------------

		//mostramos un listado de las reseñas existentes
        vMostrarActasInicio($pagina,$acta, $fotosActa);

    }

	//Funcion que muestra las reseñas de hoteles de forma resumida en la pagina principal
    function vMostrarActasInicio($pagina, $actas, $fotosActa){
        // Muestra las actas en la página
		
		$trozos = explode("##Acta##", $pagina);

		$aux = "";
		$cuerpo = "";
		while ($datos = $actas->fetch_assoc()) {
			$foto = $fotosActa->fetch_assoc();
			$aux = $trozos[1];
			//$aux = str_replace("##lugar##", "$datos["nombrelugar"]", $aux);
			$aux = str_replace("##pais##", $datos["nombre"], $aux);
			$aux = str_replace("##tituloActa##", $datos["titulo"], $aux);
			
			if($datos["puntuacion"] == 1 ){
				$aux = str_replace("##estrellas##",
									'<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star-o text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star-o text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star-o text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star-o text-success"></i></li>'
									, $aux);
			}else if($datos["puntuacion"] == 2){
				$aux = str_replace("##estrellas##",
									'<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star-o text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star-o text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star-o text-success"></i></li>'
									, $aux);

			}else if($datos["puntuacion"] == 3){
				$aux = str_replace("##estrellas##",
									'<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star-o text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star-o text-success"></i></li>'
									, $aux);
			}else if($datos["puntuacion"] == 4){
				$aux = str_replace("##estrellas##",
									'<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star-o text-success"></i></li>'
									, $aux);
			}else if($datos["puntuacion"] == 5){
				$aux = str_replace("##estrellas##",
									'<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>'
									, $aux);
			}
			
			// CAMBIAR EL MOSTRAR ACTA EN OTRA VENTANA
			$aux = str_replace("##idActa##", $datos["idacta"], $aux);//pone el idacta en la url
			if (!is_null($foto['ruta'])){
				
				$aux = str_replace("##foto##", $foto['ruta'], $aux);
			}else{ 
				$aux = str_replace("##foto##", 	"fotos/monumento.png" , $aux);
			}
			$cuerpo .= $aux;
		}

		echo $trozos[0] . $cuerpo . $trozos[2];
	}

	function vMostrarBusqueda($actas){
		  // Muestra las actas en la página principal despues de una busqueda
		
		$pagina = file_get_contents("vistas/mostrarActasPrincipal.html");
		 
		$trozos = explode("##Acta##", $pagina);

		$aux = "";
		$cuerpo = "";
		while ($datos = $actas->fetch_assoc()) {
			
			$aux = $trozos[1];
			//$aux = str_replace("##lugar##", "$datos["nombrelugar"]", $aux);
			$aux = str_replace("##pais##", $datos["nombre"], $aux);
			$aux = str_replace("##tituloActa##", $datos["titulo"], $aux);
			
			if($datos["puntuacion"] == 1 ){
				$aux = str_replace("##estrellas##",
									'<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star-o text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star-o text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star-o text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star-o text-success"></i></li>'
									, $aux);
			}else if($datos["puntuacion"] == 2){
				$aux = str_replace("##estrellas##",
									'<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star-o text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star-o text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star-o text-success"></i></li>'
									, $aux);

			}else if($datos["puntuacion"] == 3){
				$aux = str_replace("##estrellas##",
									'<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star-o text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star-o text-success"></i></li>'
									, $aux);
			}else if($datos["puntuacion"] == 4){
				$aux = str_replace("##estrellas##",
									'<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star-o text-success"></i></li>'
									, $aux);
			}else if($datos["puntuacion"] == 5){
				$aux = str_replace("##estrellas##",
									'<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
									<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>'
									, $aux);
			}
			
			// CAMBIAR EL MOSTRAR ACTA EN OTRA VENTANA
			$aux = str_replace("##idActa##", $datos["idacta"], $aux);//pone el idacta en la url
			if (!is_null($datos["rutaFoto"])){
				
				$aux = str_replace("##foto##", $datos["rutaFoto"], $aux);
			}else{ 
				$aux = str_replace("##foto##", 	"fotos/monumento.png" , $aux);
			}
			$cuerpo .= $aux;
		}
	  
		echo $trozos[0] . $cuerpo . $trozos[2];
	}

	//Funcion que muestra la vista para reistrar un nuevo usario
    function vMostrarRegistrarUsuario(){
        echo file_get_contents("vistas/registrarse.html");
    }
	//funcion auxiliar donde le pasamos un titulo y un mensaje y lo muestra de una forma generica
    function vMostrarMensaje($titulo, $mensaje) {
		$cadena = file_get_contents("vistas/mensaje.html");
		$cadena = str_replace("##titulo##", $titulo, $cadena);
		$cadena = str_replace("##mensaje##", $mensaje, $cadena);
		echo $cadena;
	} 
	//funcion que recibe un valor etre[-5,0] y muestra el resultado del exito o no del registro de un nuevo usuario 
    function vMostrarResultadoRegistroUsuario($resultado){
        switch ($resultado) {
			case 0: 
				vMostrarMensaje("Registro Usuario", "Usuario registrado satisfactoriamente.");
				break;
			case -1:
				vMostrarMensaje("Registro Usuario", "El nick y el correo introducidos ya existen.");
				break;
			case -2:
				vMostrarMensaje("Registro Usuario", "El nick introducido ya existe.");
				break;
			case -3:
				vMostrarMensaje("Registro Usuario", "El correo introducido ya existe.");
				break;
			case -5:
				vMostrarMensaje("Registro Usuario", "Las contraseñas no coinciden");
				break;
			case -5:
				vMostrarMensaje("Registro Usuario", "Error al registrar al usuario. Ínténtelo de nuevo.");
				break;
		}
    }
	//Funcion que muestra el login de un usuario
	function vMostrarInicioSesion(){
		echo file_get_contents("vistas/iniciarsesion.html");
	}
	// funcion que muestra o un mensaje de erro o te redirige al principal.html con el usuario iniciado
	function vMostrarResultadoIniciarSesion($resultado) {
		if($resultado != -1) {
			header('location: index.php?accion=principal&id=1'); 
		} else 
			vMostrarMensaje("Inicio Sesión", "El correo o la contraseña son incorrectos");
	}
	//Funcion que muestra la vista de crear actas
function vMostrarCrearActa($usuarioIniciado) {

		//mIniciadoYExisteBD();
		$vista = "vistas/crearacta.html";
		
		$pagina = vMostrarCabecera($usuarioIniciado,$vista);
		
		echo $pagina;
	}

function vMostrarResultadoCrearActa($resultado) {
	if($resultado == 0){
		vMostrarMensaje("Creación reseña", "Se ha creado la reseña correctamente");
	}
	else if ($resultado == -1){
		vMostrarMensaje("Creación reseña", "ERROR---> Ya ha creado una reseña del mismo lugar");
	}else{
		vMostrarMensaje("Creación reseña", "ERROR---> Ya ha creado una reseña del mismo lugar");
	}
		
	
		
}
	
//mostrat acta completa
//IMPLEMETAR PRIMERO LOS COMENTARIOS
function vMostrarActa($usuarioIniciado,$acta,$comentarios,$fotos){

	$vista = "vistas/mostraracta.html";
	//$pagina = file_get_contents($vista);


	$pagina = vMostrarCabecera($usuarioIniciado,$vista);

	$trozos = explode("##Comentario##", $pagina);

		$trozos[0] = str_replace("##titulo##", $acta["titulo"], $trozos[0]);
		$trozos[0] = str_replace("##pais##", $acta["nombre"], $trozos[0]);
		
		//$trozos[0] = str_replace("##lugar##", $acta["nombrelugar"], $trozos[0]);
		//$trozos[0] = str_replace("##ciudad##", $acta["nombreciudad"], $trozos[0]);
		if($acta["puntuacion"] == 1 ){
			$trozos[0] = str_replace("##estrellas##",
								'<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
								<li class="list-inline-item m-0"><i class="fa fa-star-o text-success"></i></li>
								<li class="list-inline-item m-0"><i class="fa fa-star-o text-success"></i></li>
								<li class="list-inline-item m-0"><i class="fa fa-star-o text-success"></i></li>
								<li class="list-inline-item m-0"><i class="fa fa-star-o text-success"></i></li>'
								,  $trozos[0]);
		}else if($acta["puntuacion"] == 2){
			$trozos[0] = str_replace("##estrellas##",
								'<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
								<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
								<li class="list-inline-item m-0"><i class="fa fa-star-o text-success"></i></li>
								<li class="list-inline-item m-0"><i class="fa fa-star-o text-success"></i></li>
								<li class="list-inline-item m-0"><i class="fa fa-star-o text-success"></i></li>'
								,  $trozos[0]);

		}else if($acta["puntuacion"] == 3){
			$trozos[0] = str_replace("##estrellas##",
								'<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
								<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
								<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
								<li class="list-inline-item m-0"><i class="fa fa-star-o text-success"></i></li>
								<li class="list-inline-item m-0"><i class="fa fa-star-o text-success"></i></li>'
								,  $trozos[0]);
		}else if($acta["puntuacion"] == 4){
			$trozos[0] = str_replace("##estrellas##",
								'<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
								<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
								<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
								<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
								<li class="list-inline-item m-0"><i class="fa fa-star-o text-success"></i></li>'
								,  $trozos[0]);
		}else if($acta["puntuacion"] == 5){
			$trozos[0] = str_replace("##estrellas##",
								'<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
								<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
								<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
								<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
								<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>'
								,  $trozos[0]);
		}else{
			echo "noenteo";
		}
		



		$trozos[0] = str_replace("##usuario##", $acta["nick"], $trozos[0]);
		$trozos[0] = str_replace("##descripcion##", $acta["descripcion"], $trozos[0]);


		$trozosFoto = explode("##fotos##", $trozos[0]);
		$cuerpoFotos = vMostrarFotos($fotos, $trozosFoto[1], $trozosFoto[0]);

		$cuerpo = vMostrarComentariosActa($comentarios, $trozos[1]);

		echo $trozosFoto[0] . $cuerpoFotos . $trozosFoto[2] . $cuerpo;

		// Si el usuario ha iniciado sesión puede escribir un comentario
		if ($usuarioIniciado) {
			//si envia el formulario --> accion = acta id = 4
			echo vMostarFormularioComentarioActa($acta["idacta"]);
		}
		echo $trozos[2];
}


function vMostrarComentariosActa($comentarios, $trozo) {

	$aux = "";
	$cuerpo = "";
	while ($opinion = $comentarios->fetch_assoc()) {
		$aux = $trozo;
		$aux = str_replace("##usuarioComentario##", $opinion["nick"], $aux);
		$aux = str_replace("##opinion##", $opinion["cuerpo"], $aux);
		$aux = str_replace("##fechaComentario##", $opinion["fecha_creacion"], $aux);
		if(isset($_SESSION["idusuario"])){
			if ($opinion["idusuario"] === $_SESSION["idusuario"]) {
				$opcionEliminar = '<a id="eliminar" href="#" onclick="alerta('.$opinion["idacta"].', '.$opinion["idcomentario"].');">Eliminar</a>';
				$aux = str_replace("##opcionEliminar##", $opcionEliminar, $aux);
			} else {
				$opcionEliminar = '';
				$aux = str_replace("##opcionEliminar##", $opcionEliminar, $aux);
			}
		}else{
			 
				$opcionEliminar = '';
				$aux = str_replace("##opcionEliminar##", $opcionEliminar, $aux);
		}
		$cuerpo .= $aux;
	}

	return $cuerpo;

}

function vMostrarResultadoComentarioEliminacion($resultado, $idUsuario, $acta, $comentarios, $fotosActa) {
	if ($resultado) {
		vMostrarActa($idUsuario, $acta, $comentarios, $fotosActa);
	}else {
		vMostrarMensaje("Error al eliminar comentario", "Ha habido un error al eliminar el comentario seleccionado.");
	}
}


function vMostarFormularioComentarioActa($idActa) {
	$pagina = file_get_contents("vistas/escribircomentario.html");
	$pagina = str_replace("##idacta##", $idActa, $pagina);
return $pagina;
}

function vMostrarResultadoComentario($resultado, $idUsuario, $acta, $comentarios, $fotosActa) {
	if ($resultado) {
		vMostrarActa($idUsuario, $acta, $comentarios, $fotosActa);
	} else {
		vMostrarMensaje("Error al escribir comentario", "Ha habido un error al escribir el comentario.");
	}
}

function vMostrarFotos($fotos, $trozoActa, &$trozosFoto) {
	$aux = "";
	$cuerpo = "";
	$b = false;
	
	//$trozosFoto = str_replace("##fotoPrincipal##", 'fotos/monumento.png', $trozosFoto);
	while ($foto = $fotos->fetch_assoc()) {
		
		if (!$b) {
			
			$b = true;
			$trozosFoto = str_replace("##fotoPrincipal##", $foto['ruta'], $trozosFoto);
		}

		$aux = $trozoActa;
		$aux = str_replace("##foto##", $foto['ruta'], $aux);
		$cuerpo .= $aux;
	}
	if (!$b) {
		$trozosFoto = str_replace("##fotoPrincipal##", 'fotos/monumento.png', $trozosFoto);
	}

	return $cuerpo;
}

function vMostrarInformacionUsuario($usuario,$usuarioIniciado) {

	$vista = "vistas/informacionusuario.html";

	$pagina = vMostrarCabecera($usuarioIniciado,$vista);

	$pagina = str_replace("##nick##", $usuario["nick"], $pagina);
	$pagina = str_replace("##nombre##", $usuario["nombre"], $pagina);
	$pagina = str_replace("##apellidos##", $usuario["apellidos"], $pagina);
	$pagina = str_replace("##correo##", $usuario["correo"], $pagina);
	$pagina = str_replace("##clave##", $usuario["clave"], $pagina);
	$pagina = str_replace("##idusuario##", $usuario["idusuario"], $pagina);
	echo $pagina;
}

function vMostrarResultadoCambioInformacionUsuario($resultado) {
	if ($resultado == 0){
		vMostrarMensaje("Éxito al actualizar el usuario", "Se ha actualizado la información del usuario correctamente");
	} else if ($resultado == -1) {
		vMostrarMensaje("Éxito al actualizar el usuario", "Se ha actualizado la información del usuario correctamente");
	} else {
		vMostrarMensaje("Las contraseñas no coinciden", "Las contraseñas introducidas no coinciden");
	}
}

function vMostrarSeleccionPaises($resultado) {
	$cadena = file_get_contents("vistas/pais.html");
	$trozos = explode("##fila##", $cadena);

	$aux = "";
	$cuerpo = "";
	while ($datos = $resultado->fetch_assoc()) {
		$aux = $trozos[1];
		$aux = str_replace("##idpais##", $datos["idpais"], $aux);
		$aux = str_replace("##pais##", $datos["nombre"], $aux);
		$cuerpo .= $aux;
	}

	echo $trozos[0] . $cuerpo . $trozos[2];
}

function vMostrarActasUsuario($actas,$usuarioIniciado) {

	$vista = "vistas/mostraractasusuario.html";
	$pagina = file_get_contents($vista);
	//insertamos la cabecera
	$pagina = vMostrarCabecera($usuarioIniciado,$vista);
	

	$trozos = explode("##Acta##", $pagina);

	$aux = "";
	$cuerpo = "";
	while ($datos = $actas->fetch_assoc()) {
		$aux = $trozos[1];
		
		$aux = str_replace("##pais##", $datos["nombre"], $aux);
		$aux = str_replace("##titulo##", $datos["titulo"], $aux);
		$aux = str_replace("##estrellas##", $datos["puntuacion"], $aux);
		$aux = str_replace("##idActa##", $datos["idacta"], $aux);

		$cuerpo .= $aux;
	}

	echo $trozos[0] . $cuerpo . $trozos[2];

}

function vMostrarEdicionActa($acta, $fotosActa,$usuarioIniciado) {

	$vista = "vistas/editaracta.html";

	$pagina = vMostrarCabecera($usuarioIniciado,$vista);

	

	$pagina = str_replace("##titulo##", $acta["titulo"], $pagina);
	
	$pagina = str_replace("##pais##", $acta["nombre"], $pagina);
	$pagina = str_replace("##puntuacion##", $acta["puntuacion"], $pagina);
	$pagina = str_replace("##descripcion##", $acta["descripcion"], $pagina);
	$pagina = str_replace("##lugar##", $acta["idlugar"], $pagina);
	
	$pagina = str_replace("##idacta##", $acta["idacta"], $pagina);
	$trozos = explode("##Foto##", $pagina);
	$cuerpo = vMostrarFotosEdicion($fotosActa, $trozos[1]);
	echo $trozos[0] . $cuerpo . $trozos[2];
}


function vMostrarFotosEdicion($fotosActa, $trozo) {
	$aux = "";
	$cuerpo = "";
	while ($foto = $fotosActa->fetch_assoc()) {
		$aux = $trozo;
		$aux = str_replace("##ruta##", $foto["ruta"], $aux);
		$aux = str_replace("##idFoto##", $foto["idfoto"], $aux);

		$cuerpo .= $aux;
	}
	return $cuerpo;
}


function vMostrarResultadoActualizacionActa($resultado) {
	if ($resultado) {
		vMostrarMensaje("Éxito al actualizar la reseña", "Se ha actualizado la reseña correctamente");
	} else {
		vMostrarMensaje("Error al actualizar la reseña", "Ha habido un error al actualizar la reseña.");
	}
}



function vMostrarEliminarActa($resultado, $actas,$usuarioIniciado) {
	if ($resultado) {
		vMostrarActasUsuario($actas,$usuarioIniciado);
	} else {
		vMostrarMensaje("Error al eliminar una reseña", "Ha habido un error al eliminar una reseña.");
	}
}


function vMostrarResultadoBorradoFotoActa($resultado) {
	if ($resultado > 0)
		header("location: index.php?accion=acta&id=8&idacta=$resultado");
	else
		vMostrarMensaje("Error al eliminar la foto", "Se ha producido un error al eliminar la foto"); 
} 

?>