<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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

    <h2>Reporte de Ventas</h2>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Valor</th>
                <th>IVA</th>
                <th>Total</th>
                <th>Concepto</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Mod Pago</th>
                <th>Met Pago</th>
                <!--<th>Cliente</th>-->
            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $venta)
            <tr>
                <td>{{ $venta->fecha }}</td>
                <td>{{ $venta->valor }}</td>
                <td>{{ $venta->iva }}</td>
                <td>{{ $venta->valor_total }}</td>
                <td>{{ $venta->concepto }}</td>
                <td>{{ $venta->nombre_producto }}</td>
                <td>{{ $venta->cantidad }}</td>
                <td>{{ $venta->modalidad_pago }}</td>
                <td>{{ $venta->metodo_pago }}</td>
                <!--<td>{{ $venta->nombre_cliente }}</td>-->
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Reporte de Gastos</h2>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Valor</th>
                <th>Concepto</th>
                <th>Modalidad Pago</th>
                <th>Metodo Pago</th>
                <th>Proveedor</th>
                <th>Categoria Gasto</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gastos as $gasto)
            <tr>
                <td>{{ $gasto->fecha }}</td>
                <td>{{ $gasto->valor }}</td>
                <td>{{ $gasto->concepto }}</td>
                <td>{{ $gasto->modalidad_pago }}</td>
                <td>{{ $gasto->metodo_pago }}</td>
                <td>{{ $gasto->proveedor }}</td>
                <td>{{ $gasto->categoria_gasto }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
