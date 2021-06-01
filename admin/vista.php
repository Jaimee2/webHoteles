<?php

function vMostrarMensaje($titulo, $mensaje) {
    $cadena = file_get_contents("vistas/mensaje.html");
    $cadena = str_replace("##titulo##", $titulo, $cadena);
    $cadena = str_replace("##mensaje##", $mensaje, $cadena);
    echo $cadena;
} 
function vMostrarPrincipal() {
    $pagina = file_get_contents("vistas/principal.html");
    echo $pagina;
}

function vMostrarInicioSesion() {
    $pagina = file_get_contents("vistas/inicioadmin.html");
    echo $pagina;
}

function vMostrarResultadoIniciarSesion($resultado) {
    if($resultado != -1) {
        header('location: index.php?accion=principal&id=1'); 
    } else 
        vMostrarMensaje("Inicio Sesión", "El usuario o contraseña son incorrectos");
}


function vMostrarActas($actas) {
    $cadena = file_get_contents("vistas/listaractas.html");
    $trozos = explode("##Acta##", $cadena);

    $aux = "";
    $cuerpo = "";
    while ($acta = $actas->fetch_assoc()) {
        $aux = $trozos[1];
        $aux = str_replace("##id##", $acta["idacta"], $aux);
        $aux = str_replace("##idlugar##", $acta["idlugar"], $aux);
        $aux = str_replace("##pais##", $acta["nombre"], $aux);
        $aux = str_replace("##titulo##", $acta["titulo"], $aux);
        $aux = str_replace("##estrellas##", $acta["puntuacion"], $aux);
        
        $cuerpo .= $aux;
    }
    echo $trozos[0] . $cuerpo . $trozos[2];
}

function vMostrarResultadoEliminacionActa($resultado) {
    if ($resultado) {
        header('location: index.php?accion=acta&id=1');
    } else {
        vMostrarMensaje("Error al eliminar la reseña", "No se ha podido eliminar la reseña");
    }
}


function vCogerTablaActasHTML($actas) {
    $cadena = file_get_contents("vistas/listaractaspdf.html");
    $trozos = explode("##Acta##", $cadena);

    $aux = "";
    $cuerpo = "";
    while ($acta = $actas->fetch_assoc()) {
        $aux = $trozos[1];
        $aux = str_replace("##id##", $acta["idacta"], $aux);
       // $aux = str_replace("##lugar##", $acta["nombrelugar"], $aux);
        //$aux = str_replace("##ciudad##", $acta["nombreciudad"], $aux);
        $aux = str_replace("##titulo##", $acta["titulo"], $aux);
        $aux = str_replace("##estrellas##", $acta["puntuacion"], $aux);
        //$aux = str_replace("##nick##", $acta["nick"], $aux);
        $cuerpo .= $aux;
    }
    return $trozos[0] . $cuerpo . $trozos[2];
}


function vMostrarComentariosActa($comentarios, $trozo) {

    $aux = "";
    $cuerpo = "";
    while ($opinion = $comentarios->fetch_assoc()) {
        $aux = $trozo;
        $aux = str_replace("##usuarioComentario##", $opinion["nick"], $aux);
        $aux = str_replace("##opinion##", $opinion["cuerpo"], $aux);
        $aux = str_replace("##fechaComentario##", $opinion["fecha_creacion"], $aux);
        $opcionEliminar = '<a id="eliminar" href="#" onclick="alerta('.$opinion["idacta"].', '.$opinion["idcomentario"].');return false;">Eliminar</a>';
        $aux = str_replace("##opcionEliminar##", $opcionEliminar, $aux);
        $cuerpo .= $aux;
    }

    return $cuerpo;

}

function vMostrarFotosEdicion($fotosActa, $trozo) {
    $aux = "";
    $cuerpo = "";
    while ($foto = $fotosActa->fetch_assoc()) {
        $aux = $trozo;
        $rutaAdmin = "../" . $foto["ruta"];
        $aux = str_replace("##ruta##", $rutaAdmin, $aux);
        $aux = str_replace("##idFoto##", $foto["idfoto"], $aux);

        $cuerpo .= $aux;
    }
    return $cuerpo;
}

function vMostrarModificarActa($acta, $fotosActa, $comentariosActa) {
    $acta = $acta->fetch_assoc();
    $cadena = file_get_contents("vistas/editaractas.html");

    $cadena = str_replace("##titulo##", $acta["titulo"], $cadena);
	$cadena = str_replace("##pais##", $acta["nombre"], $cadena);
	$cadena = str_replace("##codigopostal##", $acta["idlugar"], $cadena);
	$cadena = str_replace("##puntuacion##", $acta["puntuacion"], $cadena);
	$cadena = str_replace("##descripcion##", $acta["descripcion"], $cadena);
	$cadena = str_replace("##idacta##", $acta["idacta"], $cadena);
    $trozos = explode("##Foto##", $cadena);
		$cuerpo = vMostrarFotosEdicion($fotosActa, $trozos[1]);

    $trozosComentarios = explode("##Comentario##", $trozos[2]);
		$cuerpoComentarios = vMostrarComentariosActa($comentariosActa, $trozosComentarios[1]);


    echo $trozos[0] . $cuerpo .$trozosComentarios[0] . $cuerpoComentarios . $trozosComentarios[2];

}

function vMostrarResultadoModificacionActa($resultado) {
    if ($resultado) 
        header("location: index.php?accion=acta&id=1"); 
    else
        vMostrarMensaje("Error al modificar la reseña", "No se ha podido modificar la reseña");
}

function vMostrarResultadoEliminacionComentarioActa($resultado) {
    if ($resultado > 0) {
        header("location: index.php?accion=acta&id=3&idacta=$resultado"); 
    } else {
        vMostrarMensaje("Error al eliminar el comentario", "No se ha podido eliminar el comentario seleccionado");
    }
}

function vMostrarJSON($json, $nombreFichero) {
    $ruta = "ficheros/$nombreFichero.json";
    $file = fopen($ruta, "w");
    fwrite($file, $json);
    fclose($file);
    header("location: ficheros/$nombreFichero.json"); 
}

function vMostrarUsuariosAplicacion($usuarios) {
    $cadena = file_get_contents("vistas/listarusuarios.html");
    $trozos = explode("##fila##", $cadena);

    $aux = "";
    $cuerpo = "";
    while ($usuario = $usuarios->fetch_assoc()) {
        $aux = $trozos[1];
        $aux = str_replace("##id##", $usuario["idusuario"], $aux);
        $aux = str_replace("##nick##", $usuario["nick"], $aux);
        $aux = str_replace("##nombre##", $usuario["nombre"], $aux);
        $aux = str_replace("##apellidos##", $usuario["apellidos"], $aux);
        $aux = str_replace("##correo##", $usuario["correo"], $aux);
        $cuerpo .= $aux;
    }
    echo $trozos[0] . $cuerpo . $trozos[2];
    return $trozos[0] . $cuerpo . $trozos[2];
}

function vMostrarResultadoEliminacionUsuario($resultado) {
    if ($resultado) {
        header('location: index.php?accion=usuario&id=1');
    } else {
        vMostrarMensaje("Error al eliminar el usuario", "No se ha podido eliminar el usuario");
    }
}

function vCogerTablaUsuariosHTML($usuarios) {
    $cadena = file_get_contents("vistas/listarusuariospdf.html");
    $trozos = explode("##fila##", $cadena);

    $aux = "";
    $cuerpo = "";
    while ($usuario = $usuarios->fetch_assoc()) {
        $aux = $trozos[1];
        $aux = str_replace("##id##", $usuario["idusuario"], $aux);
        $aux = str_replace("##nick##", $usuario["nick"], $aux);
        $aux = str_replace("##nombre##", $usuario["nombre"], $aux);
        $aux = str_replace("##apellidos##", $usuario["apellidos"], $aux);
        $aux = str_replace("##correo##", $usuario["correo"], $aux);
        $cuerpo .= $aux;
    }
    return $trozos[0] . $cuerpo . $trozos[2];
}
?>