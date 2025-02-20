<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Marcas - Administrador</title>
    <link href="{{ asset('img/favicon.ico') }}" rel="icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400|Source+Code+Pro:700,900&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #FF6F61;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><i class="fa fa-envelope"></i> support@email.com</div>
                <div class="col-sm-6"><i class="fa fa-phone-alt"></i> +012-345-6789</div>
            </div>
        </div>
    </div>
    
    <!-- Nav Bar -->
    <div class="nav">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-md bg-dark navbar-dark">
                <a href="#" class="navbar-brand">MENU</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto">
                        <a href="{{ route('inicio') }}" class="nav-item nav-link">Inicio</a>
                        <a href="{{ route('listaproductos') }}" class="nav-item nav-link">Productos</a>
                        <a href="{{ route('compradetalle') }}" class="nav-item nav-link">Productos detalle</a>
                        <a href="{{ route('carrito') }}" class="nav-item nav-link">Carrito</a>
                        <a href="{{ route('verificar') }}" class="nav-item nav-link">Verificar</a>
                        <a href="{{ route('micuenta') }}" class="nav-item nav-link">Mi Cuenta</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle active" data-toggle="dropdown">Más Páginas</a>
                            <div class="dropdown-menu">
                                <a href="{{ route('listadeseos') }}" class="dropdown-item">Wishlist</a>
                                <a href="{{ route('login') }}" class="dropdown-item active">Login & Register</a>
                                <a href="{{ route('contacto') }}" class="dropdown-item">Contact Us</a>
                            </div>
                        </div>
                    </div>
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
    
    <!-- Bottom Bar -->
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
                    <input type="text" id="search" class="form-control" placeholder="Buscar marca" onkeyup="buscarMarca()">
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <center><h2>Catalogar Marcas</h2></center>
        <div class="mb-3">
            <!-- Botón para agregar nueva marca -->
            <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarMarca" onclick="limpiarFormulario()">Agregar Marca</button>
        </div>
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="successMessage">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
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
                @foreach($marcas as $marca)
                    <tr>
                        <td>{{ $marca->idma }}</td>
                        <td>{{ $marca->nombre_marca }}</td>
                        <td>{{ $marca->descripcion }}</td>
                        <td>
                            @if($marca->archivo)
                                <img src="{{ asset('archivos/' . $marca->archivo) }}" alt="Logo de {{ $marca->nombre_marca }}" width="50">
                            @else
                                <span>Sin imagen</span>
                            @endif
                        </td>
                        <td>
                            <!-- Botón para editar -->
                            <button class="btn btn-info" data-toggle="modal" data-target="#modalEditarMarca" onclick="llenarFormulario({{ $marca->idma }}, '{{ $marca->nombre_marca }}', '{{ $marca->descripcion }}', '{{ $marca->archivo ?? '' }}')">Editar</button>
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
        <!-- Paginación -->
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

    <!-- Modal para agregar marca -->
    <div class="modal fade" id="modalAgregarMarca" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Nueva Marca</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="marcaForm" action="{{ route('marcas.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="marcaNombre">Nombre de la Marca</label>
                            <input type="text" class="form-control" id="marcaNombre" name="nombre_marca" required>
                        </div>
                        <div class="mb-3">
                            <label for="marcaDescripcion">Descripción</label>
                            <textarea class="form-control" id="marcaDescripcion" name="descripcion" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="marcaLogo">Logo (Imagen)</label>
                            <input type="file" class="form-control" id="marcaLogo" name="archivo">
                        </div>
                        <button type="submit" class="btn btn-success">Guardar</button>
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
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="marcaFormEdit" action="{{ route('marcas.update', ':id') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="marcaId" name="marcaId">
                        <div class="mb-3">
                            <label for="marcaNombreEdit">Nombre de la Marca</label>
                            <input type="text" class="form-control" id="marcaNombreEdit" name="nombre_marca" required>
                        </div>
                        <div class="mb-3">
                            <label for="marcaDescripcionEdit">Descripción</label>
                            <textarea class="form-control" id="marcaDescripcionEdit" name="descripcion" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="marcaLogoEdit">Logo (Imagen)</label>
                            <input type="file" class="form-control" id="marcaLogoEdit" name="archivo">
                        </div>
                        <button type="submit" class="btn btn-success">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para manejar formulario de edición -->
    <script>
        function buscarMarca() {
        let input = document.getElementById("search").value.toLowerCase();
        let filas = document.querySelectorAll("#marcaTable tr");
        filas.forEach(fila => {
            let marca = fila.cells[1].innerText.toLowerCase();
            fila.style.display = marca.includes(input) ? "" : "none";
        });
        }
        function limpiarFormulario() {
            document.getElementById("marcaForm").reset();
        }

        function llenarFormulario(id, nombre, descripcion, archivo) {
            document.getElementById("marcaId").value = id;
            document.getElementById("marcaNombreEdit").value = nombre;
            document.getElementById("marcaDescripcionEdit").value = descripcion;
            let formAction = document.getElementById("marcaFormEdit").action;
            document.getElementById("marcaFormEdit").action = formAction.replace(':id', id);
        }

        @if(session('success'))
        setTimeout(function() {
            document.getElementById('successMessage').style.display = 'none';
        }, 3000); // 3000ms = 3 segundos
        @endif
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>
