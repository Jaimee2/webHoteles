<?php

    include "modelo.php";
    include "vista.php";
    include "topdf.php";


    if (isset($_GET["accion"])){
        $accion = $_GET["accion"];
        $id = $_GET["id"];
    
    } elseif (isset($_POST["accion"])){
        $accion = $_POST["accion"];
        $id = $_POST["id"];
    
    } else if(!mAdminIniciado()) {
        $accion = "principal";
        $id = 2;
    
    }else{
        $accion = "principal";
        $id = 1;
    }

    /*************************
     * accion = principal
     * id:
     *      1. Mostrar la vista principal de la web del administrador
     *      2. Mostrar inicio de sesion
     *      3. Mostrar el resultado de inicio de sesio 
     *      $.Cerrar sesion
     *************************/

    if ($accion == "principal") {
		switch ($id) {
			case 1:
                vMostrarPrincipal();
                
                break;
            case 2:
                vMostrarInicioSesion();
                break;
            case 3:
                vMostrarResultadoIniciarSesion(mIniciarSesion());
                break;
            case 4:
                mCerrarSesion();
                break;
        }
    }
    /*************************
     * accion = acta
     * id:
     *      1.Mostrar actas
     *      2.Resultado de eliminar un acta
     *      3.Modificar una reseña
     *      5.Mostrar el resultado de eliminar un comentario
     *      6.Mostrar resultado modificacion de la reseña
     *      7.PDF
     *      8.Json
     *************************/

    if ($accion == "acta") {
		mIniciadoYExisteBD();
		switch($id) {
            case 1:
                vMostrarActas(mCogerActas());
                break;
            case 2:
                vMostrarResultadoEliminacionActa(mEliminarActa($_GET['idacta']));
                break;
            case 3:
                //modificacion de las actas
                vMostrarModificarActa(mCogerActas($_GET["idacta"]), mCargarFotosActa($_GET['idacta']), mCogerComentariosActa($_GET['idacta']));
                break;
            case 5:
                vMostrarResultadoEliminacionComentarioActa(mBorrarComentario($_GET['idacta'], $_GET['idcomentario']));
                break;
            case 6:
                vMostrarResultadoModificacionActa(mModificarActa($_GET["idacta"]));
                break;
            case 7:
                convertirAPDF(vCogerTablaActasHTML(mCogerActas()), 'actas-'.date("y-m-d"));
                break;
            case 8:
                vMostrarJSON(mObtenerActasJSON(), "actas.json");
                break;
            
        }
    }

/*************************
     * accion = usuario
     * id:
     *      1. Mostrar un listado de los usuarios de la aplicacion
     *      2.  Mostrar resultado eliminacion del usuario 
     *      3. PDF
     *      4.Json
     *************************/

    if ($accion == "usuario") {
		mIniciadoYExisteBD();
		switch($id) {
            case 1:
                vMostrarUsuariosAplicacion(mCogerUsuarios());
                break;
            case 2:
                vMostrarResultadoEliminacionUsuario(mEliminarUsuario($_GET["idusuario"]));
                break;
            case 3:
                convertirAPDF(vCogerTablaUsuariosHTML(mCogerUsuarios()), 'usuarios-'.date("y-m-d"));
                break;
            case 4:
                vMostrarJSON(mObtenerUsuariosJSON(), "usuarios.json");
            break;
            case 5:
                vMostrarImportarUsuariosCSV();
            break;
            case 6:
                
                vMostrarResultadoImportarUsuariosCSV(mImportarUsuariosCSV());
                break;

        }
    }

?>