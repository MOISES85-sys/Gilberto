$(document).ready(function () 
{
	var id_tabla, usersTable, opcion;
	opcion = 4;
	ota = $('#ota').val();
	tablaUsuarios = $('#tablaUsuarios').DataTable
	(
		{
		createdRow: function (row, data) 
		{
			if (data['status_produccion'] === 'EN ESPERA') 
			{
				if (data['registros'] > 0) {
					$('td', row).closest('tr').find('.btnAgregar').prop('disabled', true);
				}
				$('td', row).closest('tr').css('background-color', '#FF0000'); //ROJO
				$('td', row).closest('tr').css('color', 'white');
				$('td', row).closest('tr').find('button').css('color', 'white');
			} else if (data['status_produccion'] === 'PROCESO 1') 
			{
				if (data['registros'] > 0) 
				{
					$('td', row).closest('tr').find('.btnAgregar').prop('disabled', true);
				}
				$('td', row).closest('tr').css('background-color', '#f58c84'); //NARANJA
				$('td', row).closest('tr').css('color', 'black');
			} 
			else if (data['status_produccion'] === 'PROCESO 2') 
			{
				if (data['registros'] > 0) 
				{
					$('td', row).closest('tr').find('.btnAgregar').prop('disabled', true);
				}
				$('td', row).closest('tr').css('background-color', '#E3B146'); //AMARILLO
				$('td', row).closest('tr').css('color', 'black');
			} else if (data['status_produccion'] === 'PROCESO 3') 
			{
				if (data['registros'] > 0) 
				{
					$('td', row).closest('tr').find('.btnAgregar').prop('disabled', true);
				}
				$('td', row).closest('tr').css('background-color', '#AEFA5A'); //casi terminado
				$('td', row).closest('tr').css('color', 'black');
			} else if (data['status_produccion'] === 'TERMINADO') 
			{
				if (data['registros'] > 0) 
				{
					$('td', row).closest('tr').find('.btnAgregar').prop('disabled', true);
				}
				$('td', row).closest('tr').css('background-color', '#00E700'); //VERDE
				// $("td", row).closest('tr').find('button').prop("disabled", true);
			} else if (data['status_produccion'] === 'PENDIENTE') 
			{
				if (data['registros'] > 0) 
				{
					$('td', row).closest('tr').find('.btnAgregar').prop('disabled', true);
				}
				$('td', row).closest('tr').css('background-color', '#00FFFF');
				$('td', row).closest('tr').css('color', 'black');
			} else if (data['status_produccion'] === 'CANCELADO') 
			{
				// if (data["registros"] > 0) 
				{
				//     $("td", row).closest('tr').find('.btnAgregar').prop("disabled", true);
				// 
			}
				$('td', row).closest('tr').css('background-color', '#0000FF');
				$('td', row).closest('tr').css('color', 'white');
				$('td', row).closest('tr').css('text-decoration', 'line-through');
				$('td', row).closest('tr').find('button').css('color', 'white');
				$('td', row).closest('tr').find('button').prop('disabled', true);
			} 
			else 
			{
				if (data['registros'] > 0) 
				{
					$('td', row).closest('tr').find('.btnAgregar').prop('disabled', true);
				}
				$('td', row).closest('tr').css('background-color', 'blue'); //AMARILLO
				$('td', row).closest('tr').css('color', 'red');
			}
		},
		//filtro de busqueda sobre una columna
		initComplete: function (settings)
		{
			var api = new $.fn.dataTable.Api(settings);
			$('#table-filter select').on('change', function () 
			{
				// table.column(17).search(this.value ,true,false).draw();
				table.columns(19).search(this.value).draw(); //filtro por de color
			});
		},
		aaSorting: [],
		//botones exportar
		responsive: 'true',
		dom: 'Bfrtilp',
		buttons: 
		[
			{
				extend: 'excelHtml5',
				text: '<i class="fas fa-file-excel"></i> ',
				titleAttr: 'Exportar a Excel',
				className: 'btn btn-success excel',
				exportOptions: 
				{
					columns: 
					[
						2, 3, 4, 5, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, //columas a descargar en el excel
					],
				},
			},
		],
		language: {
			lengthMenu: 'Mostrar _MENU_ registros',
			zeroRecords: 'No se encontraron resultados',
			info: 'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
			infoEmpty: 'Mostrando registros del 0 al 0 de un total de 0 registros',
			infoFiltered: '(filtrado de un total de _MAX_ registros)',
			sSearch: 'Busqueda general:',
			oPaginate: 
			{
				sFirst: 'Primero',
				sLast: 'Último',
				sNext: 'Siguiente',
				sPrevious: 'Anterior',
			},
			sProcessing: 'Procesando...',
			select: 
			{
				rows: 
				{
					_: '%d filas seleccionadas',
					0: 'Haz click a una fila para seleccionar',
					1: '1 fila seleccionada',
				},
			},
		},
		rowId: 'id_tabla',
		lengthMenu: 
		[
			[50, 100, 500, 1000, -1],
			[50, 100, 500, 1000, 'TODO'],
		],
		ajax: 
		{
			url: 'bd/crud_control.php',
			method: 'POST',
			data: 
			{
				opcion: opcion,
				ota: ota,
			},
			dataSrc: '',
		},
		columns: 
		[
			{
				data: null,
				defaultContent: '',
			},
			{
				className: 'details-control',
				orderable: false,
				data: null,
				defaultContent: '',
			},
			{
				data: 'id_tabla',
			},
			{
				data: 'etapa',
			},
			{
				data: 'contratista',
			},
			{
				data: 'revision',
			},
			{
				data: 'marca',
			},
			{
				data: 'perfil',
			},
			{
				data: 'consecutivo',
			},
			{
				data: 'folio',
			},
			{
				data: 'cantidad',
			},
			{
				data: 'nombre',
			},
			{
				data: 'peso_unitario',
			},
			{
				data: 'laboratorio',
			},
			{
				data: 'taller',
			},
			{
				data: 'pendiente_calidad',
			},
			{
				data: 'comentarios_calidad',
			},
			{
				data: 'status_produccion',
			},
			{
				data: 'porcentaje',
			},
			{
				defaultContent:
					"<div class='text-center'><div class='btn-group'><button class='btn btn-outline-dark btn-sm btnAgregar'>Agregar</button><button class='btn btn-outline-dark btn-sm btnEditar'>Editar</button><button class='btn btn-outline-dark btn-sm btnBorrar'>Borrar</button></div></div>",
			},
		],
		columnDefs: 
		[
			{
				orderable: false,
				className: 'select-checkbox',
				targets: 0,
			},
			{
				targets: 18, //columna donde se enceuntra el porcentaje
				render: $.fn.dataTable.render.percentBar(
					'round',
					'#FFFFFF',
					'none',
					'#0000FF',
					'black',
					0,
					'ridge'
				), //letra, borde, fonfo
			},
			{
				orderable: false,
				className: 'select-checkbox',
				targets: 0,
			},
		],
		select: 
		{
			style: 'multi',
			selector: 'td:first-child',
		},
		order: [[1, 'asc']],
	});
	//impide selección individual desde la tabla
	tablaUsuarios.on('user-select', function (e, dt, type, cell, originalEvent) 
	{
		if (
			tablaUsuarios.row(originalEvent.target._DT_CellIndex.row).data()
			[
				'status_produccion'
			] === 'CANCELADO' ||
		tablaUsuarios.row(originalEvent.target._DT_CellIndex.row).data()
		[
				'status_produccion'
			] === 'TERMINADO'
		) {
			e.preventDefault();
		}
	});

	// cambiar el icono de TODO dependiendo si esta selecionado o no
	tablaUsuarios.on('select deselect draw', function () 
	{
		var all = tablaUsuarios
			.rows(
				function (idx, data, node) 
				{
					return data['status_produccion'] === 'CANCELADO' ||
						data['status_produccion'] === 'TERMINADO'
						? false
						: true;
				},
				{ search: 'applied' 
			}
			)
			.count();
		var selectedRows = tablaUsuarios
			.rows({ selected: true, search: 'applied' })
			.count(); // get total count of selected rows
		if (selectedRows < all) 
		{
			$('#check-all i').attr('class', 'far fa-square text-white');
		} 
		else 
		{
			$('#check-all i').attr('class', 'far fa-check-square text-white');
		}
	});

	$('#check-all').click(function () 
	{
		var all = tablaUsuarios
			.rows(
				function (idx, data, node) 
				{
					return data['status_produccion'] === 'CANCELADO' ||
						data['status_produccion'] === 'TERMINADO'
						? false
						: true;
				},

				{ search: 'applied' 
			}
			)
			.count();
		var selectedRows = tablaUsuarios
			.rows({ selected: true, search: 'applied' })
			.count(); // get total count of selected rows
		console.log('all: ' + all);
		console.log('selected rows: ' + selectedRows);
		if (selectedRows < all) 
		{
			tablaUsuarios
				.rows(
					function (idx, data, node) 
					{
						return data['status_produccion'] === 'CANCELADO' ||
							data['status_produccion'] === 'TERMINADO'
							? false
							: true;
					},
					{
						search: 'applied',
					}
				)
				.select();
		} 
		else 
		{
			tablaUsuarios.rows().deselect();
		}
	});

	$('#c-todo').change(function () 
	{
		if ($(this).is(':checked')) 
		{
			/*$('#s-nomPro').prop('disabled', false);*/
			$('#btn-todo').prop('disabled', false);
		} 
		else 
		{
			/*$('#s-nomPro').prop('disabled', true);*/
			$('#btn-todo').prop('disabled', true);
		}
	});

	$(document).on('click', '#btn-todo', function () 
	{
		opcion = 5;
		var events = $('#events');
		var table = $('#tablaUsuarios').DataTable();
		var datos = table.rows({ selected: true }).data().pluck('id_tabla').toArray();
		var numero_registros = table
			.rows({ selected: true })
			.data()
			.pluck('id_tabla')
			.count();
			id_tabla = $.trim($('id_tabla').val());

			Swal.fire
			(
				{
				title: '¿Está seguro de editar ' + numero_registros + ' registros?',
				text: 'Esta opción elevará el nivel de los registros seleccionados al 100%.',
				icon: 'warning',
				showCancelButton: true,
				cancelButtonColor: '#d33',
				confirmButtonColor: '#28a745',
				cancelButtonText: 'No, Cancelar',
				confirmButtonText: 'Sí, Editar',
				reverseButtons: true // se agrega esta propiedad para invertir los botones
			  }
			).then((result) => 
			  {
			if (result.isConfirmed) 
			{
				$('#formUsuarios').trigger('reset');
				$('.modal-header').addClass('bg-dark text-white');
				$('.modal-title').text('Contratistas Seleccionados');
				$('.modal-title2').text('Editar Valores');
				$('.modal-title3').text('Se han subido correctamente los valores');

				$('#modalCRUD').modal('show');
			}
		});
	});
	$('#c-nomPro').change(function () 
	{
		if ($(this).is(':checked')) 
		{
			$('#s-nomPro').prop('disabled', false);
			$('#btn-nomPro').prop('disabled', false);
		} 
		else 
		{
			$('#s-nomPro').prop('disabled', true);
			$('#btn-nomPro').prop('disabled', true);
		}
	});
	//filtros encabezado
	var table = $('#tablaUsuarios').DataTable();
	$('#tablaUsuarios tfoot td').each(function () 
	{
		var title = $(this).text();
		$(this).html(
			'<input type="text" class="form-control form-control-sm bg-light" style="width:170px;" placeholder="Buscar"/>'
		);
		$(this).removeClass('details-control');
	});
	table.columns().every(function () 
	{
		var that = this;
		$('input', this.footer()).on('keyup change', function () 
		{
			if (that.search() !== this.value) 
			{
				that.search(this.value).draw();
			}
		});
	});
	$('#tablaUsuarios tfoot tr').appendTo('#tablaUsuarios thead');

	$('#tablaUsuarios tbody').on('click', 'td.details-control', function () 
	{
		var tr = $(this).closest('tr');
		var row = tablaUsuarios.row(tr);
		
		id_tabla = tr.find('td:eq(2)').text();
		
		if (row.child.isShown()) 
		{
			
			destroyChild(row);
			tr.removeClass('shown ' + id_tabla);
		} else 
		{
			// Open this row
			createChild(row);
			// row.child( format(row.data()) ).show();
			tr.addClass('shown ' + id_tabla);
		}
	});

	$(document).on('click', '.btnAgregar', function () 
	{
	
		fila = $(this).closest('tr');
		id_tabla = parseInt(fila.find('td:eq(2)').text());
		// console.log('id tabla: ' + id_tabla);
		$(this).closest('tr').find('.btnAgregar').prop('disabled', true);

		var tr = $(this).closest('tr');
		var row = tablaUsuarios.row(tr);

		opcion = 8;
		$.ajax
		(
			{
				url: 'bd/crud_control.php',
				type: 'POST',
				datatype: 'json',
				data: 
				{
					id_tabla: id_tabla,
					opcion: opcion,
				},
				success: function (data) 
				{
					createChild(row);
					tr.addClass('shown ' + id_tabla);	
				},
			}
		);
	});
	function destroyChild(row) 
	{
		var table = $('table', row.child());
		table.detach();
		table.DataTable().destroy();
		// And then hide the row
		row.child.hide();
	}
	function updateChild(row) 
	{
		$('table', row.child()).DataTable().ajax.reload();
	}
	function createChild(row) 
	{
		var table = $('<table id ="usersTable" class="table table-sm table-border"><thead class="table-light"><th>#</th><th>CONCEPTO</th><th>ACUMULADO</th><th>AVANCE</th><th>FECHA</th><th>SUPERVISOR</th><th>INSPECCION</th><th>ID</th><th>ACCIONES</th></thead><tbody></tbody></table>');
		row.child(table).show();
		opcion = 5;
		usersTable = table.DataTable({
			createdRow: function (row, data) 
			{
				if (data['acumulado'] === '100') 
				{
					$('td', row).closest('tr').find('button').prop('disabled', true);
					
				} 
				else 
				{
					$('td', row).closest('tr').find('button').prop('disabled', false);
				}
			},
			ordering: false,
			bPaginate: false,
			bFilter: false,
			bInfo: false,
			language: 
			{
				lengthMenu: 'Mostrar _MENU_ registros',
				zeroRecords: 'No se encontraron resultados',
				info: 'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
				infoEmpty: 'Mostrando registros del 0 al 0 de un total de 0 registros',
				infoFiltered: '(filtrado de un total de _MAX_ registros)',
				sSearch: 'Busqueda general:',
				oPaginate: 
				{
					sFirst: 'Primero',
					sLast: 'Último',
					sNext: 'Siguiente',
					sPrevious: 'Anterior',
				},
				sProcessing: 'Procesando...',
			},
			ajax: 
			{
				url: 'bd/crud_control.php',
				method: 'POST',
				data: 
				{
					id_tabla: id_tabla,
					opcion: opcion,
				},
				dataSrc: '',
			},
			columns: 
			[
				{
					data: 'numero',
				},
				{
					data: 'concepto',
				},
				{
					data: 'acumulado',
				},
				{
					data: 'ultimo',
				},
				{
					data: 'fecha',
				},
				{
					data: 'supervisor',
				},
				{
					data: 'inspeccion',
				},
				{
					data: 'id_tabla',
				},
				{
					defaultContent:
						"<div class='text-center'><div class='btn-group'><button class='btn btn-outline-dark btn-sm'  id='Editar2'>Editar</button></div></div>",
				},
			],
		}
		);
	}
	$(document).on('click', '#Editar2', function () 
	{
		opcion = 7;
		fila = $(this).closest('tr');
		acumulado = parseInt(fila.find('td:eq(2)').text());
		numero = parseInt(fila.find('td:eq(0)').text());
		concepto = fila.find('td:eq(1)').text();
		id_tabla2 = parseInt(fila.find('td:eq(7)').text());
		maximo = 100 - acumulado;
		$('#acumulado').val(acumulado);
		$('#numero').val(numero);
		$('#concepto').val(concepto);
		$('#id_tabla2').val(id_tabla2);
		$('#ultimo').attr
		(
			{
				max: maximo,
			}	
		);
		$('#exampleModal2').modal('show');
		$('#formUsuarios2').trigger('reset');
		console.log('acum: ' + acumulado);
	});
	$('#formUsuarios2').submit(function (e) 
	{
		e.preventDefault();
		id_tabla2 = $.trim($('#id_tabla2').val());
		numero = $.trim($('#numero').val());
		concepto = $.trim($('#concepto').val());
		ultimo = $.trim($('#ultimo').val());
		supervisor = $.trim($('#supervisor').val());
		inspeccion = $.trim($('#inspeccion').val());
		acumulado = $.trim($('#acumulado').val());
		$.ajax
		(
			{
			url: 'bd/crud_control.php',
			type: 'POST',
			datatype: 'json',
			data: 
			{
				id_tabla2: id_tabla2,
				numero: numero,
				concepto: concepto,
				ultimo: ultimo,
				supervisor: supervisor,
				inspeccion: inspeccion,
				acumulado: acumulado,
				opcion: opcion,
			},
			success: function (data) 
			{
				console.log('Mi psicodélia');
				tr_primary = $('.' + id_tabla2);
				row_primary = tablaUsuarios.row(tr_primary);
				id_tabla = tr_primary.find('td:eq(2)').text();
				destroyChild(row_primary);
				if (row_primary.child.isShown()) 
				{
					destroyChild(row_primary);
					tr_primary.removeClass('shown ' + id_tabla);
				} else {
					// Open this row
					createChild(row_primary);
					// row.child( format(row.data()) ).show();
					tr_primary.addClass('shown ' + id_tabla);
				}
			},
			}
		);
		$('#exampleModal2').modal('hide');
	});
	var fila;
	$('#formUsuarios').submit(function (e) 
	{
		e.preventDefault();
		id_tabla = $.trim($('#id_tabla').val());
		laboratorio = $.trim($('#laboratorio').val());
		pendiente_calidad = $.trim($('#pendiente_calidad').val());
		comentarios_calidad = $.trim($('#comentarios_calidad').val());
		$.ajax
		({
			url: 'bd/crud_control.php',
			type: 'POST',
			datatype: 'json',
			data: 
			{
				id_tabla: id_tabla,
				laboratorio: laboratorio,
				pendiente_calidad: pendiente_calidad,
				comentarios_calidad: comentarios_calidad,
				opcion: opcion,
			},
			success: function (data) 
			{
				tablaUsuarios.ajax.reload(null, false);
			},
		});
		$('#modalCRUD').modal('hide');
	});
	$('#btnNuevo').click(function ()
	{
		opcion = 1; //alta
		id_tabla = null;
		$('#formUsuarios').trigger('reset');
		$('.modal-header').addClass('bg-dark text-white');
		$('.modal-title').text('Registro nuevo');
		$('#modalCRUD').modal('show');
	});
	$(document).on('click', '.btnEditar', function () 
	{
		fila = $(this).closest('tr');
		id_tabla = parseInt(fila.find('td:eq(2)').text());

		var resultadojson = '';
		opcion = 9;
		$.ajax({
			url: 'bd/crud_control.php',
			method: 'POST',
			async: false,
			datatype: 'json',
			data: 
			{
				id_tabla: id_tabla,
				opcion: opcion,
			},
			dataSrc: '',
			success: function (data) 
			{
				resultadojson = data;
			},
		});
		data = resultadojson.replace(/['"]+/g, '');
		registros = parseInt(data);
		console.log(registros);
		opcion = 2;
		laboratorio = fila.find('td:eq(12)').text();
		pendiente_calidad = fila.find('td:eq(14)').text();
		comentarios_calidad = fila.find('td:eq(15)').text();
		$('#id_tabla').val(id_tabla);
		$('#laboratorio').val(laboratorio);
		$('#pendiente_calidad').val(pendiente_calidad);
		$('#comentarios_calidad').val(comentarios_calidad);
		$('.modal-header').addClass('bg-dark text-white');
		$('#modalCRUD').modal('show');
	});
	$(document).on('click', '.btnBorrar', function () 
	{
		fila = $(this);
		id_tabla = parseInt($(this).closest('tr').find('td:eq(2)').text());
		opcion = 3;
		var respuesta = confirm(
			'¿Está seguro de borrar el registro ' + id_tabla + '?'
		);
		if (respuesta) 
		{
			$.ajax({
				url: 'bd/crud_control.php',
				type: 'POST',
				datatype: 'json',
				data: 
				{
					opcion: opcion,
					id_tabla: id_tabla,
				},
				success: function () 
				{
					tablaUsuarios.ajax.reload(null, false);
				},
			});
		}
	});
	//cambiar select a colores
	$('#color_me').change(function () 
	{
		var color = $('option:selected', this).attr('class');
		$('#color_me').attr('class', color);
	});
});  
$(document).on('click', '#btnGuardar', function () 
	{
        // Oculta el primer modal
        $('#modalCRUD').modal('hide');

        // Muestra el segundo modal
        $('#modalSegundo').modal('show');
    });
	$(document).on('click', '#btnSave', function () 
	{
        // Oculta el primer modal
        $('#modalSegundo').modal('hide');
        // Muestra el segundo modal   
		Swal.fire({
			title: "Se han subido correctamente los valores al 100%",
			icon: "success",
			confirmButtonText: "Aceptar",
			confirmButtonColor: "#28a745"
		  });
    });
	$(document).ready(function () 
	{
		var opcion = 0;
		var ota = "";
		tablaUsuarios = $("#tablaUsuarios").DataTable(
			{
		  responsive: true,
		  pageLength: 10,
		  ajax: 
		  {
			method: "POST",
			url: "ajax.php",
			data: 
			{ opcion: opcion, ota: ota },
			dataSrc: "",
		  },
		  columns: 
		  [
			{ data: "marca" },
			{ data: "cantidad" },
			{ data: "nombre" },
			{ data: "contratista" },
			{
			  orderable: false,
			  className: "select-checkbox",
			  targets: 0,
			  checkboxes: 
			  {
				selectRow: true,
			  },
			},
		  ],
		  select: 
		  {
			style: "multi",
		  },
		  order: [[1, "asc"]],
		  language: 
		  {
			lengthMenu: "Mostrar _MENU_ registros por página",
			zeroRecords: "No se encontraron registros",
			info:
			  "Mostrando la página _PAGE_ de _PAGES_",
			infoEmpty: "No hay registros disponibles",
			infoFiltered: "(filtrado de _MAX_ registros totales)",
			search: "Buscar:",
			paginate: 
			{
			  first: "Primero",
			  last: "Último",
			  next: "Siguiente",
			  previous: "Anterior",
			},
		  },
		});
		 //Código para traer todos los datos seleccionados para el modal de contratista, marca, cantidad, nombre
		$("#btn-todo").click(function () 
		{
		  opcion = 10;
		  var table = $("#tablaUsuarios").DataTable();
		  var datos = table.rows({ selected: true }).data();
		  var numero_registros = datos.count();
		  var html = "";
	  
		  if (numero_registros > 0) {
			html += '<table class="table table-sm">';
			html += '<tr><th>CONTRATISTA</th><th>MARCA</th><th>CANTIDAD</th><th>NOMBRE</th></tr>';
			datos.each(function (value, index) 
			{
			  html += '<tr>';
			  html += '<td>' + value.contratista + '</td>';
			  html += '<td>' + value.marca + '</td>';
			  html += '<td>' + value.cantidad + '</td>';
			  html += '<td>' + value.nombre + '</td>';
			  html += '</tr>';
			});
			html += '</table>';
		  } 
		  else 
		  {
			Swal.fire
			(
			{
			  icon: 'warning',
			  title: 'Ningún elemento seleccionado',
			  text: 'Por favor, selecciona al menos uno.',
			}
			);
			html += '<p>No se ha seleccionado ningún elemento. Por favor, selecciona al menos uno.</p>';
		  }
		  $("#modalCRUD").find(".selected-items").html(html);
		});
	  });
	  $('#tablaUsuarios').DataTable().destroy();
	  //Termina el código para traer todos los datos seleccionados para el modal de contratista, marca, cantidad, nombre

	  $("#btnSave").click(function () {
		// Recuperar los valores de los inputs en la segunda columna
		var supervisor = $("input[type='text']").val();
		var armado = $("button:contains('ARMADO')").text();
		var soldadura = $("button:contains('SOLDADURA')").text();
		var limpieza = $("button:contains('LIMPIEZA')").text();
		var pintura = $("button:contains('PINTURA')").text();
		
		// Actualizar los valores al 100%
		$("input[type='text']").val("");
		$("button:contains('ARMADO')").text("100%");
		$("button:contains('SOLDADURA')").text("100%");
		$("button:contains('LIMPIEZA')").text("100%");
		$("button:contains('PINTURA')").text("100%");
	  
		// Cerrar el modal
		$('#modalSegundo').modal('hide');
	  });
