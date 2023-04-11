<?php
include_once '../bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();
session_start();
$nombres = $_SESSION['nombres'];
$tipo = $_SESSION['tipo'];

$ota = (isset($_POST['ota'])) ? $_POST['ota'] : '';
$marca = (isset($_POST['marca'])) ? $_POST['marca'] : '';
$armado = (isset($_POST['armado'])) ? $_POST['armado'] : '';
$peso_unitario = (isset($_POST['peso_unitario'])) ? $_POST['peso_unitario'] : '';
$soldadura = (isset($_POST['soldadura'])) ? $_POST['soldadura'] : '';
$limpieza = (isset($_POST['limpieza'])) ? $_POST['limpieza'] : '';
$pintura = (isset($_POST['pintura'])) ? $_POST['pintura'] : '';
$fecha_calidad = (isset($_POST['fecha_calidad'])) ? $_POST['fecha_calidad'] : '';
$status_calidad = (isset($_POST['status_calidad'])) ? $_POST['status_calidad'] : '';
$laboratorio = (isset($_POST['laboratorio'])) ? $_POST['laboratorio'] : '';
$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';

$fecha_armado = (isset($_POST['fecha_armado'])) ? $_POST['fecha_armado'] : '';
$fecha_soldadura = (isset($_POST['fecha_soldadura'])) ? $_POST['fecha_soldadura'] : '';
$fecha_limpieza = (isset($_POST['fecha_limpieza'])) ? $_POST['fecha_limpieza'] : '';
$fecha_pintura = (isset($_POST['fecha_pintura'])) ? $_POST['fecha_pintura'] : '';

$pendiente_calidad = (isset($_POST['pendiente_calidad'])) ? $_POST['pendiente_calidad'] : '';

$comentarios_calidad = (isset($_POST['comentarios_calidad'])) ? $_POST['comentarios_calidad'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id_tabla = (isset($_POST['id_tabla'])) ? $_POST['id_tabla'] : '';

$id_produccion = (isset($_POST['id_produccion'])) ? $_POST['id_produccion'] : '';
$ultimo = (isset($_POST['ultimo'])) ? $_POST['ultimo'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$numero = (isset($_POST['numero'])) ? $_POST['numero'] : '';
$concepto = (isset($_POST['concepto'])) ? $_POST['concepto'] : '';
$supervisor = (isset($_POST['supervisor'])) ? $_POST['supervisor'] : '';
$inspeccion = (isset($_POST['inspeccion'])) ? $_POST['inspeccion'] : '';
$acumulado = (isset($_POST['acumulado'])) ? $_POST['acumulado'] : '';

$id_tabla2 = (isset($_POST['id_tabla2'])) ? $_POST['id_tabla2'] : '';


switch ($opcion) {
    case 2:
        $consulta = "UPDATE tabla SET laboratorio='$laboratorio', pendiente_calidad='$pendiente_calidad' , comentarios_calidad = '$comentarios_calidad' WHERE id_tabla='$id_tabla' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * FROM tabla WHERE id_tabla='$id_tabla' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 3:
        $consulta = "UPDATE tabla SET armado = '', soldadura = '', limpieza = '', pintura = '', laboratorio = '', fecha_calidad = '', fecha_armado = '', fecha_soldadura = '', fecha_limpieza = '', fecha_pintura = '', pendiente_calidad = '' , comentarios_calidad = '' WHERE id_tabla='$id_tabla' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta2 = "INSERT INTO historial (id_tabla, nombres, tipo, accion, fecha_modificacion) VALUES ('$id_tabla', '$nombres', '$tipo', 'BORRÓ', NOW())";
        $resultado2 = $conexion->prepare($consulta2);
        $resultado2->execute();

        break;
    case 4:
        $consulta = 
        "SELECT  tabla.id_tabla
        ,tabla.etapa
        ,tabla.contratista
        ,tabla.revision
        ,tabla.marca
        ,tabla.perfil
        ,tabla.consecutivo
        ,tabla.folio
        ,tabla.cantidad
        ,tabla.nombre
        ,tabla.peso_unitario
        ,tabla.armado
        ,tabla.soldadura
        ,tabla.limpieza
        ,tabla.pintura
        ,tabla.laboratorio
        ,tabla.taller
        ,tabla.fecha_armado 
        ,tabla.fecha_soldadura
        ,tabla.fecha_limpieza
        ,tabla.fecha_pintura
        ,tabla.pendiente_calidad
        ,tabla.comentarios_calidad
        ,tabla.status_calidad
        ,tabla.cancelados
        ,t2.registros
        ,IFNULL(t3.porcentaje,0) AS porcentaje
        ,CASE 
        WHEN IFNULL(t3.porcentaje,0) = 0 AND tabla.pendiente_calidad  != 'SI' AND tabla.cancelados != 'SI' THEN 'EN ESPERA' 
        WHEN t3.porcentaje > 0 AND t3.porcentaje <= 33 AND tabla.pendiente_calidad  != 'SI' AND tabla.cancelados != 'SI' THEN 'PROCESO 1'
        WHEN t3.porcentaje > 33 AND t3.porcentaje <= 66 AND tabla.pendiente_calidad  != 'SI' AND tabla.cancelados != 'SI' THEN 'PROCESO 2'
        WHEN t3.porcentaje > 66 AND t3.porcentaje <= 99 AND tabla.pendiente_calidad  != 'SI' AND tabla.cancelados != 'SI' THEN 'PROCESO 3'
        WHEN t3.porcentaje = 100 AND tabla.pendiente_calidad  != 'SI' AND tabla.cancelados != 'SI' THEN 'TERMINADO'
        WHEN tabla.pendiente_calidad  = 'SI' AND tabla.cancelados != 'SI' THEN 'PENDIENTE' 
        WHEN tabla.cancelados = 'SI' THEN 'CANCELADO'
        END AS status_produccion
        FROM tabla
        LEFT JOIN
        (
            SELECT id_tabla, COUNT(id_tabla) AS registros
            FROM produccion_contratistas
            GROUP BY id_tabla
        ) t2
        ON tabla.id_tabla = t2.id_tabla
        LEFT JOIN
        (
            SELECT id_tabla, SUM( (ultimo)/4 ) AS porcentaje
            FROM produccion_contratistas
            GROUP BY id_tabla
        ) t3
        ON tabla.id_tabla = t3.id_tabla
        WHERE ota = '$ota'
        ORDER BY fecha_liberado ASC";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;

    case 5:
        // $consulta = "SELECT *, SUM(ultimo) AS acumulado FROM produccion_contratistas  WHERE id_tabla = '$id_tabla' GROUP BY concepto ORDER by id_produccion";
        $consulta = "
        SELECT  produccion_contratistas.numero AS numero
                ,produccion_contratistas.id_tabla
                ,produccion_contratistas.concepto
                ,t1.acumulado
                ,t2.ultimo
                ,t2.fecha
                ,t2.supervisor
                ,t2.inspeccion
        FROM produccion_contratistas
        LEFT JOIN
        (
            SELECT  concepto
                ,SUM(ultimo) AS acumulado
            FROM produccion_contratistas
            WHERE id_tabla = '$id_tabla'
            GROUP BY  concepto
        )t1
        ON t1.concepto = produccion_contratistas.concepto
        LEFT JOIN
        (
            SELECT  *
            FROM produccion_contratistas
            WHERE id_tabla = '$id_tabla'
            GROUP BY  id_produccion
                    ,concepto
                    ,ultimo
                    ,supervisor
                    ,inspeccion
            ORDER BY id_produccion ASC
        )t2
        ON produccion_contratistas.id_tabla = t2.id_tabla AND produccion_contratistas.concepto = t2.concepto
        WHERE produccion_contratistas.id_tabla = '$id_tabla'
        GROUP BY  produccion_contratistas.concepto
        ORDER BY numero";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;

    case 6:
        $consulta = "UPDATE produccion_contratistas SET ultimo = '$ultimo', fecha = '$fecha', acumulado=acumulado + '$ultimo' WHERE id_produccion='$id_produccion' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * FROM produccion_contratistas WHERE id_produccion='$id_produccion' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;

    case 7:
        $consulta = "INSERT INTO produccion_contratistas (id_tabla, numero, concepto, fecha, ultimo, supervisor, inspeccion, acum) VALUES('$id_tabla2', '$numero', '$concepto', now(), '$ultimo', '$supervisor', '$inspeccion', '$ultimo' + '$acumulado')";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT id_contratista, nombre FROM contratista ORDER BY id_contratista DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;

    case 8:
        $consulta = "INSERT INTO produccion_contratistas (id_tabla, numero, concepto)VALUES('$id_tabla', '1', 'ARMADO')";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta2 = "INSERT INTO produccion_contratistas (id_tabla, numero, concepto)VALUES('$id_tabla', '2', 'SOLDADURA')";
        $resultado2 = $conexion->prepare($consulta2);
        $resultado2->execute();

        $consulta3 = "INSERT INTO produccion_contratistas (id_tabla, numero, concepto)VALUES('$id_tabla', '3', 'LIMPIEZA')";
        $resultado3 = $conexion->prepare($consulta3);
        $resultado3->execute();

        $consulta4 = "INSERT INTO produccion_contratistas (id_tabla, numero, concepto)VALUES('$id_tabla', '4', 'PINTURA')";
        $resultado4 = $conexion->prepare($consulta4);
        $resultado4->execute();
        break;

    case 9:
        $consulta = "SELECT COUNT(id_tabla) AS registros FROM produccion_contratistas WHERE id_tabla = '$id_tabla' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetch(PDO::FETCH_COLUMN, 0);
        break;

}
print json_encode($data, JSON_UNESCAPED_UNICODE); //envio el array final el formato json a AJAX
$conexion = null;
