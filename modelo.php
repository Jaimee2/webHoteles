<?php

session_start();
//funcion: conexion con la base de datos
function conexion() {
    $con = mysqli_connect("localhost", "root", "", "proyecto");
	//$con = mysqli_connect("dbserver", "grupo35", "fo5quooVae", "db_grupo35");
    $acentos = $con->query("SET NAMES 'utf8'");
    return $con;
}
//Funcion que obtine todas las actas existentes SE DEBE MODIFICAR
function mCogerActas() {
    $con = conexion();
    $consulta = "Select * 
                    from final_actas,final_paises
                    where final_actas.idpais= final_paises.idpais 
                    ORDER BY fecha_creacion DESC";
    $listaActas = $con->query($consulta);
    return $listaActas;
}
/**************************
	Función que añade un usuario a la base de datos
	Devuelve
		0 --> inserción correcta
		-1 --> nick y correo ya existen
		-2 --> nick ya existe
		-3 --> correo ya existe
		-4 --> No coinciden las contraseñas
		-5 --> otro error de consulta
	 *************************/
function mRegistrarUsuario() {
    $con = conexion();
    
    $nick = $_POST['nick'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $clave = $_POST['clave'];
    $clave2 = $_POST['clave2'];
    
    // Comprobamos si las claves introducidas son iguales
    if ($clave != $clave2) {
        return -4;
    }


    //$llave = $GLOBALS['llaveAES'];

    $consulta = "INSERT INTO final_usuarios (nick, nombre, apellidos, correo, clave)
                 VALUES ('$nick','$nombre','$apellidos', '$correo',$clave)";
    

    # Comprobamos si falla porque ya existe ese correo o contraseña
    $consultaNick = "SELECT idusuario
                     FROM final_usuarios
                         WHERE nick = '$nick'"; 
    $resultadoNick =  $con->query($consultaNick);
    $consultaCorreo = "SELECT idusuario 
                        FROM final_usuarios 
                            WHERE correo = '$correo'";
    $resultadoCorreo =  $con->query($consultaCorreo);

    // Como tenemos programa la BD para que no permita valores repetidos ni nombres de Nick, comprobamos estos errores.
    /*if ($con->query($consulta) === TRUE) {
        return 0;
    } else {
        
        if (($resultadoNick->num_rows + $resultadoCorreo->num_rows) == 2) {
            return -1;
        } else {
            if($resultadoNick->num_rows > 0)
                return -2;
            else
                return -3;
        }
        return -4;*/

    
    if ($con->query($consulta) === TRUE) {
        return 0;
    } else {
        if (($resultadoNick->num_rows + $resultadoCorreo->num_rows) == 2) {
            return -1;
        }else if ($resultadoNick->num_rows > 0) {
            return -2;
        }else if ($resultadoCorreo->num_rows > 0) {
            return -3;
        }else{
            return -5; 
        }
        
    }
}

function mInicionSesion(){
    $con = conexion();

    $correo = $_POST["correo"];
    $clave = $_POST["clave"];

    //$llave = $GLOBALS['llaveAES'];

    $consulta = "Select idusuario,nick
                    from final_usuarios
                    where correo = '$correo' and clave = '$clave'";

    $resultado = $con->query($consulta);
    $datos = $resultado -> fetch_assoc();
    

    if($datos["idusuario"] != NULL){
       
        //Iniciamos sesion o reanudamos la existente
        $_SESSION["idusuario"] = $datos["idusuario"];
        $_SESSION["nick"] = $datos["nick"];
        return $datos;
    }else{
        
        return -1;
    }
}
//funcion que comprueba si hay un usuario iniciado
function mUsuarioIniciado() {
    return isset($_SESSION["idusuario"]);
}

function mCerrarSesion() {
    session_destroy(); 
    header('location: index.php'); 
}
//Comprueba si existe un login de usuario y comprueba si esta en la bbdd
    //true si 
    //false no
function mIniciadoYExisteBD(){
   
    if (mUsuarioIniciado()) {
        $con = conexion();
        $idUsuario = $_SESSION["idusuario"];
        $consulta = "SELECT idusuario
                     FROM final_usuarios
                     WHERE idusuario = '$idUsuario'";

        $resultado = $con->query($consulta);
        if ($resultado->num_rows == 0)  {
            mCerrarSesion();
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}

//MIDIFICAR LOUEGO LA ELIMINACIN DE LA FOTO SI ES DUPLICADO
function mCrearActa(){

    $con = conexion();
		//Obteneoms los resultado con el metodo post
		$titulo = $_POST["titulo"];
		$puntuacion = $_POST["puntuacion"];
		$descripcion = $_POST["descripcion"];
		$idlugar = $_POST["idlugar"];	
        $idpais = $_POST["pais"];
        //Obtenemos el id del usuario que esta conectado
		$idusuario = $_SESSION["idusuario"];
		
		$comprobarDuplicidad = "SELECT idacta 
                                FROM final_actas 
                                WHERE titulo = $titulo AND idusuario = $idusuario";
		
		$resultado =  $con->query($comprobarDuplicidad);
       
		if ($resultado->num_rows >0) {
            
			mEliminarFotosSubiendo($idusuario);
			return -1; 
		}
		$crearActa = "INSERT INTO final_actas (titulo, puntuacion, descripcion, idlugar,idpais, idusuario)
                         VALUES ('$titulo','$puntuacion','$descripcion', '$idlugar','$idpais','$idusuario')";
		
		if(!$con->query($crearActa)){
           
			return -1;

        }
    
        // Ponemos las fotos
		mFotosActa($idlugar, $idusuario, $con);
		return 0;
}

function mEliminarFotosSubiendo($idUsuario) {
    $con = conexion();
    $consulta = "SELECT idfoto, nombre, ruta, idusuario
                 FROM final_fotos_subiendo
                 WHERE idusuario = '$idUsuario'";
    $fotosBorrar = $con->query($consulta);
    mEliminarFotos($fotosBorrar);
    mEliminarFotosSubiendoBD($idUsuario);
    
}

function mEliminarFotos($fotosEliminar) {
    while ($foto = $fotosEliminar->fetch_assoc()) {
        unlink($foto['ruta']);
    }
}

function mEliminarFotosSubiendoBD($idUsuario) {
    $con = conexion();
    $consulta = "DELETE FROM final_fotos_subiendo 
                    WHERE idusuario = '$idUsuario'";
    return $con->query($consulta);
}

function mGuardarFotoSubiendo($nombre, $ruta) {

    $con = conexion();
    $idUsuario = $_SESSION["idusuario"];
    $consulta = "INSERT INTO final_fotos_subiendo (nombre, ruta, idusuario)
                     VALUES ('$nombre', '$ruta', '$idUsuario')";
    return $con->query($consulta);

}

function mFotosActa($idlugar, $idUsuario, $con) {
    echo "entro";

    $consulta = "SELECT idfoto, nombre, ruta, idusuario 
                        FROM final_fotos_subiendo 
                        WHERE idusuario = '$idUsuario'
                        ORDER BY idfoto DESC";
    $consultaIDActa = "SELECT idacta FROM final_actas 
                        WHERE idlugar = '$idlugar' AND idusuario = '$idUsuario'";
    $idActa = $con->query($consultaIDActa);
    $idActa = $idActa->fetch_assoc();
    $idActa = $idActa['idacta'];
    // Fotos máximas que puede haber en una reseña
    $fotos = $con->query($consulta);
    $i = 5;
    while ($foto = $fotos->fetch_assoc()) {
        if ($i == 0)
            break;
        
        $nombreFoto = $foto['nombre'];//obtenemos los nombres de las fotos en la tabla fotos_subiendo
        $nuevaRuta = "fotos/" . $nombreFoto; 
        mMoverFoto($nombreFoto, $nuevaRuta);//cambiamos la ruta cambiando su nombre con rename
        $consultaMeterFoto = "INSERT INTO final_fotos (nombre, ruta, idacta)
                                         VALUES ('$nombreFoto', '$nuevaRuta', '$idActa')";//consolidamos la foto en la tabla fotos asociandola al idcta
        $con->query($consultaMeterFoto);
        $i--;
    }
    eliminarRestoFotos($foto, $fotos, $idUsuario, $con);
    return true;
}

// Funcion que borra las fotos que excenden mas 5  de /fotos/subiendo y las asocicacones de la tabla fotos-subiendo
function eliminarRestoFotos($foto, $fotos, $idUsuario, $con) {
    if ($foto != null)
        unlink($foto['ruta']);//unlink borra un fichero
    while ($foto = $fotos->fetch_assoc()) {
        unlink($foto['ruta']);
    }
    $eliminarFotosSubida = "DELETE FROM final_fotos_subiendo
                             WHERE idusuario = '$idUsuario'";

    return $con->query($eliminarFotosSubida);
}

//funcion que cambia de directorio una foto
function mMoverFoto($nombreFoto, $nuevaRuta) {
    rename("fotos/subiendo/$nombreFoto", $nuevaRuta);
    return true;
}
//Obtien una lista de idactas y le asocia una única foto al acta min(ruta)
function mCogerFotosActa(){
    $con = conexion();
    $consulta = "SELECT final_actas.idacta, min(ruta) as ruta 
                    FROM final_actas LEFT JOIN final_fotos ON final_actas.idacta = final_fotos.idacta
                    GROUP BY final_actas.idacta
                    ORDER BY fecha_creacion DESC";
    $fotos = $con->query($consulta);
    return $fotos;
}
//lectura de un acta a partir de u idacta
function mLeerActa($idActa) {
    $con = conexion();
    /*$consulta = "SELECT final_actas.idacta, titulo, puntuacion, descripcion, final_actas.idlugar, final_actas.idusuario, final_lugares.nombre as nombrelugar, final_ciudades.nombre as nombreciudad, final_usuarios.nick
                 FROM final_actas, final_lugares, final_ciudades, final_usuarios WHERE final_actas.idlugar = final_lugares.idlugar AND final_lugares.idciudad = final_ciudades.idciudad AND final_usuarios.idusuario = final_actas.idusuario AND final_actas.idacta = $idActa;";*/
    
    $consulta = "SELECT *
                 FROM final_actas,final_usuarios
                 WHERE final_actas.idacta = $idActa and final_usuarios.idusuario = final_actas.idusuario " ;
    
    $datos = $con->query($consulta);
    $acta = $datos->fetch_assoc();
    return $acta;
}
//a partir de un idacta obtiene las fotos asociadas al acta
function mCargarFotosActa($idActa) {
    $con = conexion();
    $consulta = "SELECT idfoto, nombre, ruta, idacta 
                    FROM final_fotos WHERE idacta = '$idActa'";
    return $con->query($consulta);
}
//registra un comentario en la bbdd
function mEscribirComentario() {
    $con = conexion();
    $comentario = $_POST["comentario"];
    $idActa = $_POST["idacta"];
    $idUsuario = $_SESSION["idusuario"];
    $escribirComentario = "INSERT INTO final_comentarios (cuerpo, idusuario, idacta)
                             VALUES ('$comentario', '$idUsuario', '$idActa')";
    return $con->query($escribirComentario);
}
//lectura de los comentarios de un acta
function mLeerComentarios($idActa) {
    $con = conexion();
    $consulta = "SELECT idcomentario, cuerpo, final_usuarios.idusuario, idacta, final_usuarios.nick, fecha_creacion
                 FROM final_comentarios, final_usuarios
                  WHERE idacta = $idActa AND final_usuarios.idusuario = final_comentarios.idusuario
                 ORDER BY fecha_creacion desc";
    $datos = $con->query($consulta);
    return $datos;
}

//funcion que borra un comentario
function mBorrarComentario() {
    $con = conexion();
    $idComentario = $_GET["idcomentario"];
    $eliminarComentario = "DELETE FROM final_comentarios WHERE idcomentario = '$idComentario'";
    return $con->query($eliminarComentario);
}
//funcion que carga la informacion del usuario a mostrar
function mCargarInformacionUsuario($idUsuario) {
    mIniciadoYExisteBD();
    $con = conexion();
   
    $consulta = "SELECT idusuario, nick, correo, nombre, apellidos, clave FROM 
                    final_usuarios
                     WHERE idusuario = $idUsuario";
    $datos = $con->query($consulta);
    $usuario = $datos->fetch_assoc();
    return $usuario;
}
//funcion que cambia la infromacion del usuario
    //-2 contraseña no coincide
    //-1 fallo
    // 0 ok
function mCambiarInformacionUsuario() {
    mIniciadoYExisteBD();
    $con = conexion();
    $clave = $_POST["clave"];
    $clave2 = $_POST["clave2"];
    $opcionClave = $_POST["cambiarclave"];
    if ($clave != $clave2)
        return -2;
    $idUsuario = $_POST["idusuario"];
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    
    if ($opcionClave == "no") {
        $consulta = "UPDATE final_usuarios
                     SET nombre = '$nombre', apellidos = '$apellidos'
                     WHERE idusuario = $idUsuario";
    } else {
        $consulta = "UPDATE final_usuarios
                     SET nombre = '$nombre', apellidos = '$apellidos', clave = '$llave'
                      WHERE idusuario = $idUsuario";
    }
    $resultado = $con->query($consulta);
    if($resultado)
        return 0;
    else 
        return -1;
}

function mCogerPaises(){
    $con = conexion();
    $consulta = "SELECT idpais, nombre
                 FROM final_paises;";
    $listaPaises = $con->query($consulta);
    return $listaPaises;
}

function mRealizarBusquedaPais() {
    $con = conexion();
    $idpais = $_GET['idpais'];
    $puntuacion =  $_GET['puntuacion'];
    $texto = $_GET['texto'];
    
    if ($idpais == '0' && $puntuacion == '0' && $texto ==""){
        $consulta = "SELECT * 
                    FROM final_actas,final_paises
                    WHERE final_actas.idpais = final_paises.idpais
                    ";
    }else if ($idpais != '0' && $puntuacion == '0' && $texto ==""){
        $consulta = "SELECT * 
                    FROM final_actas,final_paises
                    WHERE final_actas.idpais = final_paises.idpais
                    and final_paises.idpais = '$idpais'";
    }else if ($idpais == '0' && $puntuacion != '0' && $texto ==""){
        $consulta = "SELECT * 
                    FROM final_actas,final_paises
                    WHERE final_actas.idpais = final_paises.idpais
                    and final_actas.puntuacion = $puntuacion";
    }else if ($idpais != '0' && $puntuacion != '0'&& $texto ==""){
        $consulta = "SELECT * 
                    FROM final_actas,final_paises
                    WHERE final_actas.idpais = final_paises.idpais
                    and final_paises.idpais = '$idpais'
                    and final_actas.puntuacion = '$puntuacion'";

    }elseif($idpais != '0' && $puntuacion != '0' && $texto !=""){
       
        $consulta = "SELECT * 
                    FROM final_actas,final_paises
                    WHERE final_actas.idpais = final_paises.idpais
                    and final_paises.idpais = '$idpais'
                    and final_actas.puntuacion = '$puntuacion'
                    and final_actas.titulo like '%$texto%'";
    }elseif($idpais == '0' && $puntuacion != '0' && $texto !=""){
       
        $consulta = "SELECT * 
                    FROM final_actas,final_paises
                    WHERE final_actas.idpais = final_paises.idpais
                    
                    and final_actas.puntuacion = '$puntuacion'
                    and final_actas.titulo like '%$texto%'";
    }elseif($idpais != '0' && $puntuacion == '0' && $texto !=""){
       
        $consulta = "SELECT * 
                    FROM final_actas,final_paises
                    WHERE final_actas.idpais = final_paises.idpais
                    and final_paises.idpais = '$idpais'
                    
                    and final_actas.titulo like '%$texto%'";
    }elseif($idpais == '0' && $puntuacion == '0' && $texto !=""){
       
        $consulta = "SELECT * 
                    FROM final_actas,final_paises
                    WHERE final_actas.idpais = final_paises.idpais
                    
                    
                    and final_actas.titulo like '%$texto%'";
    }else{
        echo "no entro en nigun if ";
    }
    
    $resultado = $con->query($consulta);
    return $resultado;		
}






?>