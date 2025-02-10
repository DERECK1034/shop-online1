<!DOCTYPE html>
<html lang="en">
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
    <!-- Top bar Start -->
    <div class="top-bar">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <i class="fa fa-envelope"></i>
                        support@email.com
                    </div>
                    <div class="col-sm-6">
                        <i class="fa fa-phone-alt"></i>
                        +012-345-6789
                    </div>
                </div>
            </div>
        </div>
        <!-- Top bar End -->
        
        <!-- Nav Bar Start -->
        <div class="nav">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-md bg-dark navbar-dark">
                    <a href="#" class="navbar-brand">MENU</a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto">
                            <a href="{{route('inicio')}}" class="nav-item nav-link">Inicio</a>
                            <a href="{{route('listaproductos')}}" class="nav-item nav-link">Productos</a>
                            <a href="{{route('compradetalle')}}" class="nav-item nav-link">Productos detalle</a>
                            <a href="{{route('carrito')}}" class="nav-item nav-link">Carrito</a>
                            <a href="{{route('verificar')}}" class="nav-item nav-link">Verificar</a>
                            <a href="{{route('micuenta')}}" class="nav-item nav-link">Mi Cuenta</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle active" data-toggle="dropdown">More Pages</a>
                                <div class="dropdown-menu">
                                    <a href="{{route('listadeseos')}}" class="dropdown-item">Wishlist</a>
                                    <a href="{{route('login')}}" class="dropdown-item active">Login & Register</a>
                                    <a href="{{route('contacto')}}" class="dropdown-item">Contact Us</a>
                                </div>
                            </div>
                        </div>
                        <div class="navbar-nav ml-auto">
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">User Account</a>
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
        <!-- Nav Bar End -->      
        
        <!-- Bottom Bar Start -->
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
                        <div class="mb-3">
                            <input type="text" id="search" class="form-control" placeholder="Buscar marca" onkeyup="buscarMarca()">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="user">
                            <a href="wishlist.html" class="btn wishlist">
                                <i class="fa fa-heart"></i>
                                <span>(0)</span>
                            </a>
                            <a href="cart.html" class="btn cart">
                                <i class="fa fa-shopping-cart"></i>
                                <span>(0)</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
    <center><h2>Gestión de Marcass</h2></center>
    <!-- Botón para agregar una nueva marca -->
    <div class="mb-3">
        <button class="btn btn-primary" onclick="mostrarFormulario('add')">Agregar Marca</button>
    </div>

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
            @foreach($marcas as $marca)
                <tr>
                    <td>{{ $marca->idma }}</td>
                    <td>{{ $marca->nombre_marca }}</td>
                    <td>{{ $marca->descripcion }}</td>
                    <td>
                        @if($marca->archivo)
                            <img src="{{ asset('storage/' . $marca->archivo) }}" alt="{{ $marca->nombre_marca }}" width="50">
                        @else
                            <span>No disponible</span>
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-info" onclick="mostrarFormulario('edit', {{ $marca->idma }}, '{{ $marca->nombre_marca }}', '{{ $marca->descripcion }}', '{{ $marca->archivo ?? '' }}')">Editar</button>
                        <form action="{{ route('marcas.destroy', $marca->idma) }}" method="POST" style="display: inline;">
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

    <!-- Formulario para agregar o editar marca -->
    <div id="formMarca" style="display: none;">
        <h3 id="formTitle">Agregar Nueva Marca</h3>
        <form id="marcaForm" action="{{ route('marcas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="marcaId" name="marcaId">
            <div class="mb-3">
                <label for="marcaNombre" class="form-label">Nombre de la Marca</label>
                <input type="text" class="form-control" id="marcaNombre" name="nombre_marca" required>
            </div>
            <div class="mb-3">
                <label for="marcaDescripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="marcaDescripcion" name="descripcion" required></textarea>
            </div>
            <div class="mb-3">
                <label for="marcaLogo" class="form-label">Logo (Imagen)</label>
                <input type="file" class="form-control" id="marcaLogo" name="archivo">
            </div>
            <button type="submit" class="btn btn-success">Guardar</button>
            <button type="button" class="btn btn-secondary" onclick="cancelarFormulario()">Cancelar</button>
        </form>
    </div>

</div>

<script>
    function buscarMarca() {
        let input = document.getElementById("search").value.toLowerCase();
        let filas = document.querySelectorAll("#marcaTable tr");
        filas.forEach(fila => {
            let marca = fila.cells[1].innerText.toLowerCase();
            fila.style.display = marca.includes(input) ? "" : "none";
        });
    }

    function mostrarFormulario(accion, id = '', nombre = '', descripcion = '', archivo = '') {
        // Mostrar el formulario
        document.getElementById("formMarca").style.display = 'block';
        document.getElementById("formTitle").innerText = accion === 'add' ? 'Agregar Nueva Marca' : 'Editar Marca';

        // Rellenar el formulario con los datos de la marca a editar
        document.getElementById("marcaId").value = id;
        document.getElementById("marcaNombre").value = nombre;
        document.getElementById("marcaDescripcion").value = descripcion;
        document.getElementById("marcaLogo").value = archivo ? archivo : '';

        // Cambiar la acción del formulario según el caso
        const form = document.getElementById('marcaForm');
        form.action = accion === 'add' ? "{{ route('marcas.store') }}" : `{{ route('marcas.update', '') }}/${id}`;
        form.method = accion === 'add' ? 'POST' : 'PUT'; // Cambiar a PUT si es editar

        // Asegúrate de agregar el campo _method para PUT en el caso de edición
        if (accion === 'edit') {
            // Verificar si el campo _method ya existe y agregarlo si no
            if (!form.querySelector('input[name="_method"]')) {
                const methodField = document.createElement('input');
                methodField.setAttribute('type', 'hidden');
                methodField.setAttribute('name', '_method');
                methodField.setAttribute('value', 'PUT');
                form.appendChild(methodField);
            }
        } else {
            // Si no es editar, eliminar el campo _method si está presente
            const methodField = form.querySelector('input[name="_method"]');
            if (methodField) {
                methodField.remove();
            }
        }
    }

    function cancelarFormulario() {
        // Ocultar el formulario
        document.getElementById("formMarca").style.display = 'none';
    }
</script>

</body>
</html>
