<!DOCTYPE html>
<html lang="es-MX">
<head>
    <!-- Metadatos de la página -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Marcas - Administrador</title>
    <link href="{{ asset('img/favicon.ico') }}" rel="icon"> <!-- Favicon de la página -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400|Source+Code+Pro:700,900&display=swap" rel="stylesheet"> <!-- Fuentes externas -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet"> <!-- Bootstrap para diseño responsivo -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet"> <!-- Iconos de FontAwesome -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet"> <!-- Estilo personalizado -->
    
    <!-- Estilos adicionales -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4; /* Color de fondo del cuerpo */
        }
        .container {
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Estilo para el contenedor */
        }
        table {
            width: 100%;
            border-collapse: collapse; /* Estilo para las tablas */
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left; /* Estilo para celdas de tabla */
        }
        th {
            background-color: #FF6F61;
            color: white; /* Estilo para los encabezados de la tabla */
        }
    </style>
</head>
<body>

    <!-- Barra superior con información de contacto -->
    <div class="top-bar">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><i class="fa fa-envelope"></i> support@email.com</div> <!-- Correo de soporte -->
                <div class="col-sm-6"><i class="fa fa-phone-alt"></i> +012-345-6789</div> <!-- Teléfono de soporte -->
            </div>
        </div>
    </div>
    
    <!-- Barra de navegación -->
    <div class="nav">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-md bg-dark navbar-dark">
                <a href="#" class="navbar-brand">MENU</a> <!-- Nombre del menú -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <!-- Enlaces de navegación -->
                    <div class="navbar-nav mr-auto">
                        <a href="{{ route('inicio') }}" class="nav-item nav-link">Inicio</a>
                        <a href="{{ route('listaproductos') }}" class="nav-item nav-link">Productos</a>
                        <a href="{{ route('compradetalle') }}" class="nav-item nav-link">Productos detalle</a>
                        <a href="{{ route('carrito') }}" class="nav-item nav-link">Carrito</a>
                        <a href="{{ route('verificar') }}" class="nav-item nav-link">Verificar</a>
                        <a href="{{ route('micuenta') }}" class="nav-item nav-link">Mi Cuenta</a>
                        <!-- Dropdown para más páginas -->
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle active" data-toggle="dropdown">Más Páginas</a>
                            <div class="dropdown-menu">
                                <a href="{{ route('listadeseos') }}" class="dropdown-item">Wishlist</a>
                                <a href="{{ route('login') }}" class="dropdown-item active">Login & Register</a>
                                <a href="{{ route('contacto') }}" class="dropdown-item">Contact Us</a>
                            </div>
                        </div>
                    </div>
                    <!-- Menú de cuenta de usuario -->
                    <div class="navbar-nav ml-auto">
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Cuenta de Usuario</a>
                            <div class="dropdown-menu">
                                <a href="#" class="dropdown-item">Login</a>
                                <a href="#" class="dropdown-item">Register</a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    
    <!-- Barra inferior con logo y campo de búsqueda -->
    <div class="bottom-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <div class="logo">
                        <a href="index.html">
                            <img src="img/logo.png" alt="Logo">
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <input type="text" id="search" class="form-control" placeholder="Buscar marca" onkeyup="buscarMarca()"> <!-- Campo de búsqueda -->
                </div>
            </div>
        </div>
    </div>

    <!-- Contenedor principal con lista de marcas -->
    <div class="container">
        <center><h2>Catalogar Marcas</h2></center> <!-- Título de la sección -->
        <div class="mb-3">
            <!-- Botón para abrir modal de agregar marca -->
            <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarMarca" onclick="limpiarFormulario()">Agregar Marca</button>
        </div>
        
        <!-- Mensaje de éxito (si existe) -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="successMessage">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Tabla de marcas -->
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Marca</th>
                    <th>Descripción</th>
                    <th>Logo</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody id="marcaTable">
                @foreach($marcas as $marca) <!-- Bucle para listar todas las marcas -->
                    <tr>
                        <td>{{ $marca->idma }}</td> <!-- ID de la marca -->
                        <td>{{ $marca->nombre_marca }}</td> <!-- Nombre de la marca -->
                        <td>{{ $marca->descripcion }}</td> <!-- Descripción de la marca -->
                        <td>
                            <!-- Mostrar logo si existe -->
                            @if($marca->archivo)
                                <img src="{{ asset('archivos/' . $marca->archivo) }}" alt="Logo de {{ $marca->nombre_marca }}" width="50">
                            @else
                                <span>Sin imagen</span> <!-- Si no hay logo -->
                            @endif
                        </td>
                        <td>
                            <!-- Botón para editar la marca -->
                            <button class="btn btn-info" data-toggle="modal" data-target="#modalEditarMarca" onclick="llenarFormulario({{ $marca->idma }}, '{{ $marca->nombre_marca }}', '{{ $marca->descripcion }}', '{{ $marca->archivo ?? '' }}')">Editar</button>
                            <!-- Formulario para eliminar la marca -->
                            <form action="{{ route('marcas.destroy', $marca->idma) }}" method="POST" style="display: inline;" enctype='multipart/form-data'>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Paginación para la lista de marcas -->
        <div class="pagination">
            {{-- Botón de "Anterior" --}}
            @if ($marcas->currentPage() > 1)
                <a href="{{ $marcas->previousPageUrl() }}" class="btn btn-secondary">Anterior</a>
            @endif

            {{-- Botón de "Siguiente" --}}
            @if ($marcas->hasMorePages())
                <a href="{{ $marcas->nextPageUrl() }}" class="btn btn-secondary">Siguiente</a>
            @endif
        </div>
    </div>

    <!-- Modal para agregar nueva marca -->
    <div class="modal fade" id="modalAgregarMarca" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Nueva Marca</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button> <!-- Cerrar modal -->
                </div>
                <div class="modal-body">
                    <form id="marcaForm" action="{{ route('marcas.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="marcaNombre">Nombre de la Marca</label>
                            <input type="text" class="form-control" id="marcaNombre" name="nombre_marca" required> <!-- Campo para nombre de marca -->
                        </div>
                        <div class="mb-3">
                            <label for="marcaDescripcion">Descripción</label>
                            <textarea class="form-control" id="marcaDescripcion" name="descripcion" required></textarea> <!-- Campo para descripción -->
                        </div>
                        <div class="mb-3">
                            <label for="marcaLogo">Logo (Imagen)</label>
                            <input type="file" class="form-control" id="marcaLogo" name="archivo"> <!-- Campo para logo -->
                        </div>
                        <button type="submit" class="btn btn-success">Guardar</button> <!-- Botón para guardar marca -->
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar marca -->
    <div class="modal fade" id="modalEditarMarca" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Marca</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button> <!-- Cerrar modal -->
                </div>
                <div class="modal-body">
                    <form id="marcaFormEdit" action="{{ route('marcas.update', ':id') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="marcaId" name="marcaId"> <!-- Campo oculto para ID -->
                        <div class="mb-3">
                            <label for="marcaNombreEdit">Nombre de la Marca</label>
                            <input type="text" class="form-control" id="marcaNombreEdit" name="nombre_marca" required> <!-- Campo de nombre -->
                        </div>
                        <div class="mb-3">
                            <label for="marcaDescripcionEdit">Descripción</label>
                            <textarea class="form-control" id="marcaDescripcionEdit" name="descripcion" required></textarea> <!-- Campo de descripción -->
                        </div>
                        <div class="mb-3">
                            <label for="marcaLogoEdit">Logo (Imagen)</label>
                            <input type="file" class="form-control" id="marcaLogoEdit" name="archivo"> <!-- Campo de logo -->
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button> <!-- Botón para guardar cambios -->
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts JS necesarios para Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <!-- Funciones JS -->
    <script>
        function buscarMarca() {
            let input = document.getElementById('search').value.toLowerCase(); // Obtener el valor de búsqueda
            let table = document.getElementById('marcaTable'); // Obtener la tabla
            let rows = table.getElementsByTagName('tr'); // Obtener todas las filas de la tabla

            // Iterar sobre las filas de la tabla y ocultar las que no coincidan
            for (let i = 0; i < rows.length; i++) {
                let td = rows[i].getElementsByTagName('td')[1]; // Obtener la columna de nombre de marca
                if (td) {
                    let txtValue = td.textContent || td.innerText;
                    rows[i].style.display = txtValue.toLowerCase().indexOf(input) > -1 ? '' : 'none'; // Filtrar
                }
            }
        }

        function limpiarFormulario() {
            // Limpiar campos del formulario de agregar marca
            document.getElementById('marcaForm').reset();
        }

        function llenarFormulario(id, nombre, descripcion, archivo) {
            // Rellenar el formulario de edición con los datos de la marca
            document.getElementById('marcaId').value = id;
            document.getElementById('marcaNombreEdit').value = nombre;
            document.getElementById('marcaDescripcionEdit').value = descripcion;
            if (archivo) {
                document.getElementById('marcaLogoEdit').value = archivo;
            }
            // Cambiar la acción del formulario para incluir el ID de la marca
            let action = document.getElementById('marcaFormEdit').action;
            document.getElementById('marcaFormEdit').action = action.replace(':id', id);
        }
    </script>
</body>
</html>
