<?php

include "modelo.php";
include "vista.php";


if (isset($_GET["accion"])){
    $accion = $_GET["accion"];
    $id = $_GET["id"];

} elseif (isset($_POST["accion"])){
    $accion = $_POST["accion"];
    $id = $_POST["id"];

} else {
    $accion = "principal";
    $id = 1;

}



/*************************
 * accion = principal
 * id:
 *      1. Mostrar la vista principal de la web
 *************************/
if ($accion == "principal") {
    switch ($id) {
        case 1:
           //le pasamos existencia de usuario, actas,fotos de las actas
            vMostrarPrincipal(mIniciadoYExisteBD(),mCogerActas(),mCogerFotosActa(),mCogerPaises());
            break;
    }
}
/*************************
 * accion = usuario
 * id:
 *      1. Mostrar una vista para registrar un usuario
 *      2. Registrar en la base de datos el nuevo usuario y mostrar si ha sido con exito o no
 *      3. Mostrar una vista con el inicio de sesion para un usuario
 *      4. Iniciamos sesion y printeamos un error si no ha sido valido el login.
 *      5. Cierra la sesion del usuario.
 *      6. Muestra la informacion del usuario logeado
 *      7. Muestra el cambio realizado por el usuario de su informacion
 *************************/

if ($accion == "usuario") {
    switch ($id) {
        case 1:
            vMostrarRegistrarUsuario();
            break;
        case 2:
            $resultadoResgistro =  mRegistrarUsuario();
            vMostrarResultadoRegistroUsuario($resultadoResgistro);
        break;
        case 3:
            vMostrarInicioSesion();
            break;
        case 4:
            $datos = mInicionSesion();
            vMostrarResultadoIniciarSesion($datos);
            break;
        case 5:
            mCerrarSesion();
            break;
        case 6:
            vMostrarInformacionUsuario(mCargarInformacionUsuario($_SESSION["idusuario"]));
            break;
        case 7:
            vMostrarResultadoCambioInformacionUsuario(mCambiarInformacionUsuario());
            break;
    }
}

/*************************
 * accion = acta
 * id:
 *      1.Muesta la vista de crear la reseña
 *      2.Guarda el acta y visualiza un resultado de la creacion de la misma
 *      3.Leer mas sobre un acta: Muestra toda la informacion del acta
 *      4.Crea un comentario para una determinada reseña y actualiza la visio de la misma con el comentario añadido
 *      5.Borra un comentario generado por el mismo usuario y actualiza la vision de la reseña con el comentario eliminado
 *      6.Buscador de reseñas.
 *      7.Muetra las actas de un usuario en concreto.
 *************************/

if ($accion == "acta") {
    switch ($id) {
        case 1:
            vMostrarCrearActa(mIniciadoYExisteBD());
            break;
        case 2:
            //crear acta
            $validez = mCrearActa();
            vMostrarResultadoCrearActa($validez);
            break;
        case 3:
            //leer mas, mostrar el acta seleccionado obtenemos por url el idacta
            vMostrarActa(mIniciadoYExisteBD(),mLeerActa($_GET["idacta"]),mLeerComentarios($_GET["idacta"]),mCargarFotosActa($_GET["idacta"]));
            break;
        case 4:
            //crear comentario
            vMostrarResultadoComentario(mEscribirComentario(),mIniciadoYExisteBD(),mLeerActa($_POST["idacta"]),mLeerComentarios($_POST["idacta"]),mCargarFotosActa($_POST["idacta"]));
            break;
        case 5:
            //borrar comentario
            vMostrarResultadoComentarioEliminacion(mBorrarComentario(), isset($_SESSION["idusuario"]),  mLeerActa($_GET["idacta"]), mLeerComentarios($_GET["idacta"]), mCargarFotosActa($_GET["idacta"]));
            break;
        case 6:
            //busqueda
            vMostrarBusqueda(mRealizarBusquedaPais(),mCogerFotosActa());
            break;
        case 7:
            vMostrarActasUsuario(mCargarActasUsuario(),mIniciadoYExisteBD());
            break;
        case 8:
            vMostrarEdicionActa(mLeerActa($_GET["idacta"]), mCargarFotosActa($_GET["idacta"]),mIniciadoYExisteBD());
            break;
        case 9:
            vMostrarResultadoActualizacionActa(mActualizarActa());
            break;
        case 10:
            vMostrarEliminarActa(mEliminarActa($_GET["idacta"]), mCargarActasUsuario(),mIniciadoYExisteBD());
            break;
        case 11:
            vMostrarResultadoBorradoFotoActa(mBorrarFotoActa($_GET["idacta"], $_GET["idfoto"], $_GET["ruta"]));
            break;
        }
}

if ($accion == "pais") {
    switch ($id) {
        case 1:
            
            vMostrarSeleccionPaises(mCogerPaises());
            break;
    }
}

?>