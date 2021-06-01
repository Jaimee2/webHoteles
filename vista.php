<?php

    //funcion que muestra la pagina de inicio pagina de inicio
    function vMostrarPrincipal($usuarioIniciado,$acta,$fotosActa){
        $pagina = file_get_contents("vistas/principal.html");
        
        if($usuarioIniciado){
            //implementar despues de generar la bbdd
			$pagina = str_replace("##direccionOp1##","index.php?accion=acta&id=1",$pagina);
            $pagina = str_replace("##op1##","Crear Reseña",$pagina);

            $pagina = str_replace("##direccionOp2##","index.php?accion=usuario&id=5",$pagina);
            $pagina = str_replace("##op2##","Cerrar Sesion",$pagina);

			$opcion3 = '<li><a href="index.php?accion=acta&id=6">Ver/Editar Reseñas</a></li>';
			$opcion4 = '<li><a href="index.php?accion=usuario&id=6">Información usuario</a></li>';
			$pagina = str_replace("##op3##", $opcion3, $pagina);
			$pagina = str_replace("##op4##", $opcion4, $pagina);

        }else{
            $pagina = str_replace("##direccionOp1##","index.php?accion=usuario&id=3",$pagina);
            $pagina = str_replace("##op1##","Iniciar sesion",$pagina);

            $pagina = str_replace("##direccionOp2##","index.php?accion=usuario&id=1",$pagina);
            $pagina = str_replace("##op2##","Registrarse",$pagina);
			$opcion3 = '';
			$opcion4 = '';
			$pagina = str_replace("##op3##", $opcion3, $pagina);
			$pagina = str_replace("##op4##", $opcion4, $pagina);
        }
		//mostramos un listado de las reseñas existentes
        vMostrarActasInicio($pagina,$acta, $fotosActa);

        //echo $pagina;
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
			
			$aux = str_replace("##estrellas##", $datos["puntuacion"], $aux);
			// CAMBIAR EL MOSTRAR ACTA EN OTRA VENTANA
			$aux = str_replace("##idActa##", $datos["idacta"], $aux);//pone el idacta en la url
			if (!is_null($foto['ruta'])){
				
				$aux = str_replace("##foto##", 	"<img src=" . $foto['ruta'] . " width='15%''>" , $aux);
			}else{ 
				$aux = str_replace("##foto##", 	"No tiene foto" , $aux);
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
function vMostrarCrearActa() {
		//mIniciadoYExisteBD();
		echo file_get_contents("vistas/crearacta.html");
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
	$pagina = file_get_contents("vistas/mostraracta.html");

	$trozos = explode("##Comentario##", $pagina);

		$trozos[0] = str_replace("##titulo##", $acta["titulo"], $trozos[0]);
		//$trozos[0] = str_replace("##lugar##", $acta["nombrelugar"], $trozos[0]);
		//$trozos[0] = str_replace("##ciudad##", $acta["nombreciudad"], $trozos[0]);
		$trozos[0] = str_replace("##estrellas##", $acta["puntuacion"], $trozos[0]);
		$trozos[0] = str_replace("##usuario##", $acta["nick"], $trozos[0]);
		$trozos[0] = str_replace("##descripcion##", $acta["descripcion"], $trozos[0]);


		$trozosFoto = explode("##fotos##", $trozos[0]);
		$cuerpoFotos = vMostrarFotos($fotos, $trozosFoto[1], $trozosFoto[2]);

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
		if ($opinion["idusuario"] === $_SESSION["idusuario"]) {
			$opcionEliminar = '<a id="eliminar" href="#" onclick="alerta('.$opinion["idacta"].', '.$opinion["idcomentario"].');">Eliminar</a>';
			$aux = str_replace("##opcionEliminar##", $opcionEliminar, $aux);
		} else {
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

function vMostrarInformacionUsuario($usuario) {
	$pagina = file_get_contents("vistas/informacionusuario.html");
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
?>