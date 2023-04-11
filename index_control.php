<?php
include_once 'bd/control_usuarios.php';
$ota = $_GET['ota'];
$proyecto = $_GET['proyecto'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <!-- Datatables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="style_control.css">
    <link rel="icon" href="../logo.ico">
    <!-- select-checkbox -->
    <link href="https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css" rel="stylesheet">
    <title>PRODUCCION</title>
    <style>
        td.details-control 
        {
            background: url('https://www.datatables.net/examples/resources/details_open.png') no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control 
        {
            background: url('https://www.datatables.net/examples/resources/details_close.png') no-repeat center center;
        }
        .selected 
        {
            opacity: 0.7;
        }
        table.dataTable tr.selected td.select-checkbox:after,
        table.dataTable tr.selected th.select-checkbox:after 
        {
            text-shadow: 1px 1px white, -1px -1px white, 1px -1px white, -1px 1px white;
            color: black;
        }
    </style>
</head>
<body class="bg-light">
    <div class="wrapper">
        <?php include '../nav.php';?>
        <div class="main bg-light">
            <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-none">
                <a class="sidebar-toggle d-flex">
                    <i class="hamburger align-self-center"></i>
                </a>
                <form class="d-none d-sm-inline-block">
                    <div class="input-group input-group-navbar">
                    </div>
                </form>
                <div class="nav nav-tabs d-flex" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link" href="index.php?ota=<?php echo $ota ?>&proyecto=<?php echo utf8_encode($proyecto) ?>">PRINCIPAL</a>
                    <a class="nav-item nav-link active" href="index_control.php?ota=<?php echo $ota ?>&proyecto=<?php echo utf8_encode($proyecto) ?>">CONTROL</a>
                    <a class="nav-item nav-link" href="index_aditivas.php?ota=<?php echo $ota ?>&proyecto=<?php echo utf8_encode($proyecto) ?>">ADITIVAS Y DEDUCTIVAS</a>
                    <a class="nav-item nav-link" href="index_liberar.php?ota=<?php echo $ota ?>&proyecto=<?php echo utf8_encode($proyecto) ?>">LIBERAR SIN CALIDAD</a>
                </div>
            </nav>
            <div class="container-fluid">
                <header align="center">
                    <h4>PRODUCCION</h4>
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-3">
                            <h5><kbd>OTA</kbd>: <?php echo $ota ?></h5>
                            <input type="hidden" id="ota" value="<?php echo $ota ?>">
                        </div>
                        <div class="col-md-3">
                            <h5><kbd>PROYECTO</kbd>: <?php echo utf8_encode($proyecto) ?></h5>
                        </div>
                    </div>
                </header>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-60 bg-light">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="row">
                                                <div class="col-md-4 d-flex justify-content-center font-weight-bold text-primary text-uppercase mb-1">
                                                    PESO:</div>
                                                <div class="col-md-8 d-flex justify-content-center h5">
                                                    <?php
                                                    $sql = "SELECT IFNULL(FORMAT(SUM(peso_unitario),2),0) AS peso_total from tabla WHERE ota = '$ota' AND cancelados != 'SI'";
                                                    $result = mysqli_query($conexion, $sql);
                                                    while ($mostrar = mysqli_fetch_array($result)) 
                                                    {
                                                    ?>
                                                        <?php echo $mostrar['peso_total'] ?> Kg.
                                                    <?php 
                                                } ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 d-flex justify-content-center h6 text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    PIEZAS:</div>
                                                <div class="col-md-8 d-flex justify-content-center h5">
                                                    <?php
                                                    $sql = "SELECT IFNULL(SUM(cantidad),0) AS piezas_totales from tabla WHERE ota = '$ota' AND cancelados != 'SI'";
                                                    $result = mysqli_query($conexion, $sql);
                                                    while ($mostrar = mysqli_fetch_array($result)) {
                                                    ?>
                                                        <?php echo $mostrar['piezas_totales'] ?> Pz.
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="row">
                                                <div class="col-md-12 d-flex justify-content-center align-items-center">
                                                    <i class="fas fa-weight fa-3x"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-60 bg-light">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="row">
                                                <div class="col-md-4 d-flex justify-content-center font-weight-bold text-success text-uppercase mb-1">
                                                    LIBERADO:</div>
                                                <div class="col-md-8 d-flex justify-content-center h5">
                                                    <?php
                                                    $sql = "SELECT IFNULL( FORMAT( (SUM((tabla.peso_unitario * produccion_contratistas.ultimo) / 4))/100 ,2) ,0) as peso_liberado FROM produccion_contratistas INNER JOIN tabla ON tabla.id_tabla = produccion_contratistas.id_tabla WHERE tabla.ota = '$ota' AND tabla.cancelados != 'SI'";
                                                    $result = mysqli_query($conexion, $sql);
                                                    while ($mostrar = mysqli_fetch_array($result)) 
                                                    {
                                                        ?>
                                                            <?php echo $mostrar['peso_liberado'] ?> Kg.
                                                        <?php 
                                                    } 
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 d-flex justify-content-center h6 text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    PIEZAS:</div>
                                                <div class="col-md-8 d-flex justify-content-center h5">
                                                    <?php
                                                    $sql = "SELECT IFNULL(COUNT(t2.piezas_totales),0) as piezas FROM tabla INNER JOIN ( SELECT tabla.id_tabla, SUM(produccion_contratistas.acum) piezas_totales FROM tabla INNER JOIN produccion_contratistas ON produccion_contratistas.id_tabla = tabla.id_tabla WHERE produccion_contratistas.acum = 100 AND tabla.ota = '$ota' AND tabla.cancelados != 'SI' GROUP BY produccion_contratistas.id_tabla HAVING SUM(produccion_contratistas.acum) = 400 ) t2 ON t2.id_tabla = tabla.id_tabla";
                                                    $result = mysqli_query($conexion, $sql);
                                                    while ($mostrar = mysqli_fetch_array($result)) {
                                                    ?>
                                                        <?php echo $mostrar['piezas'] ?> Pz.
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="row">
                                                <div class="col-md-12 d-flex justify-content-center align-items-center">
                                                    <i class="fas fa-truck-loading fa-3x"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-60 bg-light">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="row">
                                                <div class="col-md-4 d-flex justify-content-center font-weight-bold text-info text-uppercase mb-1">
                                                    PESO:</div>
                                                <div class="col-md-8 d-flex justify-content-center h5">
                                                    <?php
                                                    $sql3 = "SELECT IFNULL( FORMAT( (SUM((tabla.peso_unitario * produccion_contratistas.ultimo) / 4))/(SELECT SUM(peso_unitario) AS peso_total from tabla WHERE ota = '$ota' AND cancelados != 'SI') ,2) ,0) as peso_liberado FROM produccion_contratistas INNER JOIN tabla ON tabla.id_tabla = produccion_contratistas.id_tabla WHERE tabla.ota = '$ota' AND tabla.cancelados != 'SI'";
                                                    $result3 = mysqli_query($conexion, $sql3);
                                                    while ($mostrar3 = mysqli_fetch_array($result3)) {
                                                    ?>
                                                        <div class="col-mr-6 d-flexjustify-content-start h-100">
                                                            <?php echo $mostrar3['peso_liberado'] ?>%</div><br>
                                                        <div class="progress" style="height: 20px; width:220px;">
                                                            <div class="progress-bar progress-bar-striped bg-info progress-bar-animated" role="progressbar" style="width:<?php echo $mostrar3['peso_liberado'] ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 d-flex justify-content-center text-info font-weight-bold text-uppercase mb-1">
                                                    PIEZAS:</div>
                                                <div class="col-md-8 d-flex justify-content-center h5">
                                                    <?php
                                                    $sql3 = "SELECT IFNULL(FORMAT(COUNT(t2.piezas_totales)*100 / (SELECT SUM(cantidad) from tabla WHERE ota = '$ota' AND cancelados != 'SI'),2),0.00) AS porcentaje FROM tabla INNER JOIN ( SELECT tabla.id_tabla, SUM(produccion_contratistas.acum) piezas_totales FROM tabla INNER JOIN produccion_contratistas ON produccion_contratistas.id_tabla = tabla.id_tabla WHERE produccion_contratistas.acum = 100 AND tabla.ota = '$ota' AND tabla.cancelados != 'SI' GROUP BY produccion_contratistas.id_tabla HAVING SUM(produccion_contratistas.acum) = 400 ) t2 ON t2.id_tabla = tabla.id_tabla";
                                                    $result3 = mysqli_query($conexion, $sql3);
                                                    while ($mostrar3 = mysqli_fetch_array($result3)) {
                                                    ?>
                                                        <div class="col-mr-6 d-flex justify-content-end h-100">
                                                            <?php echo $mostrar3['porcentaje'] ?>%</div>
                                                        <div class="progress" style="height: 20px; width:220px;">
                                                            <div class="progress-bar progress-bar-striped bg-info progress-bar-animated" role="progressbar" style="width:<?php echo $mostrar3['porcentaje'] ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="row">
                                                <div class="col-md-12 d-flex justify-content-center align-items-center">
                                                    <i class="fas fa-percentage fa-3x"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <center>
                    <p id="table-filter">
                        Filtrar:
                        <select id="color_me" class="btn btn-dark">
                            <option class="btn btn-dark" value="">TODO</option>
                            <option class="btn TERMINADO" value="TERMINADO">TERMINADO</option>
                            <option class="btn PROCESO-3" value="PROCESO 3">PROCESO 3</option>
                            <option class="btn PROCESO-2" value="PROCESO 2">PROCESO 2</option>
                            <option class="btn PROCESO-1" value="PROCESO 1">PROCESO 1</option>
                            <option class="btn EN-ESPERA text-white" value="EN ESPERA">EN ESPERA</option>
                            <option class="btn PENDIENTE" value="PENDIENTE">PENDIENTE</option>
                            <option class="btn CANCELADO text-white" value="CANCELADO">CANCELADO</option>
                        </select>
                    </p>
                </center>
                <div class="container-fluid table-responsive">
                    <table id="tablaUsuarios" class="table table-sm table-striped table-bordered" style="width:100%;">
                        <thead>
                           <!-- Comienzo botones encabezado -->
                           <?php if ($tipo == 'produccion' || $tipo == 'Admin') 
                           {
                             ?>
                                <tr>
                                    <td>
                                    <div class="input-group" style="width:250px;">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="checkbox" id="c-todo">
                                                </div>
                                            </div>
                                            <div class="input-group-append">
                                                <button class="btn btn-sm btn-dark" type="button" disabled id="btn-todo"><i class="fas fa-save"></i></button>
                                            </div>
                                        </div>
                                    </td>
                                    <td colspan="10"></td> <!--Salto de columnas -->
                                    <td>
                                        <div class="input-group" style="width:250px;">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="checkbox" id="c-folio">
                                                </div>
                                            </div>
                                            <select name="nomPro" id="nomPro" class="form-control form-control-sm">
                                                <option selected>Selecciona opción</option>
                                                <?php
                                                $sql4 = "SELECT nombre, COUNT(nombre) AS Cantidad_N, marca FROM tabla WHERE ota = '$ota' GROUP BY 'nombre'";
                                                $result4 = mysqli_query($conexion, $sql4);
                                                while ($mostrar4 = mysqli_fetch_array($result4)) {
                                                ?>
                                                    <option value="<?php echo $mostrar4['nombre'] ?>"> <?php echo $mostrar4['nombre'] ?> </option>
                                                <?php } ?>
                                            </select>
                                            <div class="input-group-append">
                                                <button class="btn btn-sm btn-dark" type="button" disabled id="btn-folio"><i class="fas fa-save"></i></button>
                                            </div>
                                        </div>
                                    </td>
                                <?php } ?>
                                <!-- Final botones encabezado -->
                                <tr class="thead-dark">
                                    <?php if ($tipo == 'produccion' || $tipo == 'Admin') { ?>
                                        <th style="width:10px" class="text-center">
                                            <button class="text-white" style="border: none; background: transparent; font-size: 14px;" id="check-all">TODO
                                                <i class="far fa-square"></i>
                                            </button>
                                        </th>
                                    <?php } ?>
                                    <th></th>
                                    <th>ID</th>
                                    <th>ETAPA</th>
                                    <th>CONTRATISTA</th>
                                    <th>REV</th>
                                    <th>MARCA</th>
                                    <th>PERFIL</th>
                                    <th>CONSEC</th>
                                    <th>TIPO</th>
                                    <th>CANTI</th>
                                    <th>NOMBRE</th>
                                    <th>PESO</th>
                                    <th>LAB</th>
                                    <th>TALLER</th>
                                    <th>PENDIENTE</th>
                                    <th>COMENTARIOS</th>
                                    <th>STATUS</th>
                                    <th>AVANCE</th>
                                    <?php if ($tipo == 'produccion' || $tipo == 'Admin') { ?>
                                        <th>ACCIONES</th>
                                    <?php } ?>
                                </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <?php if ($tipo == 'produccion' || $tipo == 'Admin') { ?>
                                    <td></td>
                                <?php } ?>
                            </tr>
                        </tfoot>
                    </table>
                </div>
    <!--SEGUNDO MODAL CONTRATISTA, MARCA, CANTIDAD, NOMBRE-->
                <div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog " role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="container-fluid table-responsive">
                                <form id="formUsuarios" class="table table-sm table-striped table-bordered" style="width:100%;">
                                    <div class="modal-body">
                                        <div class="selected-items"></div>
                                    </div>
                                    <div class="modal-footer">
                                    <!--Botones de Continuar y Cancelar del 2 Modal-->
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" id="btnGuardar" class="btn btn-success">Continuar</button>
                                </div>
                                </form>
                            </div>        
                        </div>
                    </div>
                </div>
    <!--TERMINA CÓDIGO DE SEGUNDO MODAL CONTRATISTA, MARCA, CANTIDAD, NOMBRE-->

    <!--TERCER MODAL o MODAL DE N.SUP, ARM, SOL, LIM, PINT.-->
     <div class="modal fade" id="modalSegundo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title2" id="exampleModalLabel">Contratistas Seleccionados</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                 </div>
            <div class="modal-body">
                <div class="row">
                <!-- Primera columna -->
                <div class="col-md-6">
                    <h5>NOMBRE DEL SUPERVISOR</h5>
                    <br>
                    <h5>ARMADO</h5>
                    <br>
                    <h5>SOLDADURA</h5>
                    <br>
                    <h5>LIMPIEZA</h5>
                    <br>
                    <h5>PINTURA</h5>
                </div>
                <!-- Segunda columna -->
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-9">
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-3">
                            <button type="button"class="btn btn-secondary btn-block" style="width: 160px;">100%</button>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-3">
                            <button type="button" class="btn btn-secondary btn-block" style="width: 160px;">100%</button>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-3">
                             <button type="button" class="btn btn-secondary btn-block" style="width: 160px;">100%</button>
                         </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-3">
                            <button type="button"class="btn btn-secondary btn-block" style="width: 160px;">100%</button>
                         </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" id="btnSubirAvance" class="btn btn-success">Continuar</button>
            </div>
            </div>
        </div>
    </div>
    <!--TERMINA TERCER MODAL-->
    <!--MODAL DE SE SUBIERON AL 100% EXITOSAMENTE-->
    <div class="modal fade" id="modalSExito" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title2" id="exampleModalLabel">Contratistas Seleccionados</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                 </div>
            <div class="modal-body">
                <div class="row">
                    <h5>Se han subido exitosamente los niveles al 100%</h5>               
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="btnGuardar" class="btn btn-success">Aceptar</button>
            </div>
            </div>
        </div>
    </div>
    <!--termina el modal se subieron exitosamente al 100%-->
                <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog " role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-dark text-white">
                                <h5 class="modal-title text-white" id="exampleModalLabel">
                                    <img src="../css/calidad.png" style="width: 30px;">
                                    CALIDAD
                                </h5>
                                <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <form id="formUsuarios2">
                                <input type="hidden" id="numero">
                                <input type="hidden" id="concepto">
                                <input type="hidden" id="id_tabla2">
                                <input type="hidden" id="acumulado">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="" class="col-form-label">AVANCE:</label>
                                                <!-- <input  type="number"  class="form-control" min="0"> -->
                                                <input type="number" id="ultimo" name="ultimo" min="0" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="" class="col-form-label">SUPERVISOR:</label>
                                                <input type="text" id="supervisor" class="form-control">
                                            </div>
                                        </div>
                                        <!-- <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="" class="col-form-label">FECHA:</label>
                                                <input type="date" id="fecha" class="form-control">
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="" class="col-form-label">T. INSPECCIÓN:</label>
                                                <input type="text" id="inspeccion" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" id="btnGuardar2" class="btn btn-dark">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap js -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous">
    </script>
    <!-- Datatables js -->
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <!-- scripts para botones de exportar datos -->
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.11.3/dataRender/percentageBars.js"></script>
    <!-- select-checkbox -->
    <script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
     <!-- Sweet Alert 2 -->
     <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php if ($tipo == 'produccion' || $tipo == 'Admin') { ?>
        <script src="main_control.js?v=<?php echo (rand()); ?>"></script>
    <?php 
} ?>
    <?php if ($tipo !== 'produccion' || $tipo !== 'Admin') 
    { ?>
        <!-- <script src="main_control_secondary.js?v=<?php echo (rand()); ?>"></script> -->
    <?php 
} ?>
</body>
</html>
