<?php

session_start();

function conexion() {
    $con = mysqli_connect("localhost", "root", "", "proyecto");
##	$con = mysqli_connect("dbserver", "grupo15", "quohy9Oquu", "db_grupo15");
    $acentos = $con->query("SET NAMES 'utf8'");
    return $con;
}

function mAdminIniciado() {
    return isset($_SESSION["idadmin"]);
}

//Comprueba si existe un login de ADMIN y comprueba si esta en la bbdd
    //true si 
    //false no
    function mIniciadoYExisteBD(){
        if (mAdminIniciado()) {
            $con = conexion();
            $idadmin = $_SESSION["idadmin"];
            $consulta = "SELECT idadmin
                         FROM final_admins
                         WHERE idadmin = '$idadmin'";
    
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

    function mIniciarSesion(){
        $con = conexion();

        $admin = $_POST["admin"];
        $clave = $_POST["clave"];

        $consulta = "SELECT idadmin,admin
                        FROM final_admins
                        WHERE admin = '$admin'
                                        AND clave = '$clave' ";

        $resultado = $con->query($consulta);
		$datos = $resultado->fetch_assoc();
		
		
		if ($datos["admin"] != NULL) {
			//Inicia una nueva sesión o reanuda la existente 
			$_SESSION["admin"] = $datos["admin"];
			$_SESSION["idadmin"] = $datos["idadmin"];
			return $datos;
		} else {
			return -1;
		}        

    }

    function mCerrarSesion() {
	    session_destroy(); 
		header('location: index.php?accion=principal&id=2'); 
	}

    function mCogerActas() {
        $con = conexion();
        $consulta = "Select * from final_actas,final_paises,final_usuarios where final_actas.idpais = final_paises.idpais and final_usuarios.idusuario = final_actas.idusuario ORDER BY fecha_creacion DESC";
        $listaActas = $con->query($consulta);
        return $listaActas;
    }

	
    

    function mCargarFotosActa($idActa) {
		$con = conexion();
		$consulta = "SELECT idfoto, nombre, ruta, idacta
                             FROM final_fotos WHERE idacta = '$idActa'";
		return $con->query($consulta);
	}
    function mCogerComentariosActa($idActa) {
		$con = conexion();
		$consulta = "SELECT idcomentario, cuerpo, final_usuarios.idusuario, idacta, final_usuarios.nick, fecha_creacion
                        FROM final_comentarios, final_usuarios
                        WHERE idacta = $idActa AND final_usuarios.idusuario =final_comentarios.idusuario
                        ORDER BY fecha_creacion desc";
		$datos = $con->query($consulta);
		return $datos;
	}

    function mEliminarFotos($fotosEliminar) {
		$rutaAtras = "../";
		while ($foto = $fotosEliminar->fetch_assoc()) {
			$ruta = $rutaAtras . $foto['ruta'];
			unlink($ruta);
		}
	}

    function mEliminarActa($idActa) {
		$con = conexion();
		$eliminarFotosActa = "SELECT idfoto, nombre, ruta, idacta
                                     FROM final_fotos
                                     WHERE idacta = '$idActa'";
		$fotosEliminar = $con->query($eliminarFotosActa);
		mEliminarFotos($fotosEliminar);
		$eliminarActa = "DELETE FROM final_actas WHERE idacta = $idActa";
		return $con->query($eliminarActa);
	}

    function mModificarActa() {
		$con = conexion();
		$titulo = $_POST["titulo"];
		$descripcion = $_POST["descripcion"];
		$idActa = $_POST["idacta"];
		$cambioActa = "UPDATE actas
                         SET final_titulo = '$titulo', descripcion = '$descripcion'
                         WHERE idacta = '$idActa'";

		return $con->query($cambioActa);
	}


    function mBorrarComentario($idActa, $idComentario) {
		$con = conexion();
		$eliminarComentario = "DELETE
                                 FROM final_comentarios
                                 WHERE idcomentario = '$idComentario'";

		if ($con->query($eliminarComentario))
			return $idActa;
		else
			return -1;
	}
    
    function mObtenerActasJSON() {
		$con = conexion();
		$consulta = "SELECT idacta, titulo, puntuacion, descripcion, idlugar, idusuario, fecha_creacion
                             FROM final_actas";
		$json = array();
		$listaActas = $con->query($consulta);
		while ($acta = $listaActas->fetch_assoc()) {
            $json[] = $acta;
	    }
	    $json = json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		return $json;

	}

    function mCogerUsuarios() {
		$con = conexion();
		$consulta = "SELECT idusuario, nick, nombre, apellidos, correo
                         FROM final_usuarios";
		return $con->query($consulta);
	}

    function mEliminarUsuario($idUsuario) {
		$con = conexion();
		$consulta = "DELETE FROM final_usuarios WHERE idusuario = '$idUsuario'"; 
		return $con->query($consulta);
	}

    function mObtenerUsuariosJSON() {
		$con = conexion();
		$consulta = "SELECT idusuario, nick, nombre, apellidos, correo 
                        FROM final_usuarios";
		$json = array();
		$listaUsuarios = $con->query($consulta);
		while ($usuario = $listaUsuarios->fetch_assoc()) {
            $json[] = $usuario;
	    }
	    $json = json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		return $json;
	}



	function mImportarUsuariosCSV(){
		
		
		
		
		//si existe fichero entramos
		if (isset($_POST['submit'])) 
		{
			$con = conexion();
			
			$archivo = fopen($_FILES['filename']['tmp_name'], "r");

			//Lo recorremos
			while (($datos = fgetcsv($archivo,1000,";")) == true) {
				$num = count($datos);
				
				$nick = $datos[0];
				$nombre = $datos[1];
				$apellidos = $datos[2];
				$correo = $datos[3];
				$contraseña = $datos[4];
				echo $nick,$nombre,$apellidos,$correo,$contraseña;
				//obtenemos los datos de la row
				if($nick != ""){
					$consulta = "INSERT INTO `final_usuarios`(`nick`, `nombre`, `apellidos`, `correo`, `clave`)
				 VALUES ('$nick','$nombre','$apellidos','$correo','$contraseña')";
				
				$resultado = $con->query($consulta);
				//
				}
				

			}
			//Cerramos el archivo
			fclose($archivo);
			}
		return $resultado;	
	}
 
?>