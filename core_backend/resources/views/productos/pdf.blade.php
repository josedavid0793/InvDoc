<!DOCTYPE html>
<html>
<head>
    <title>Lista de Productos</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Lista de Productos</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Costo</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Codigo</th>
                <th>Categoría</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
                <tr>
                    <td>{{ $producto->id }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->descripcion }}</td>
                    <td>{{ $producto->costo_unidad }}</td>
                    <td>{{ $producto->precio_unidad }}</td>
                    <td>{{ $producto->cantidad_disponible }}</td>
                    <td>{{ $producto->codigo }}</td>
                    <td>{{ $producto->categoria }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
