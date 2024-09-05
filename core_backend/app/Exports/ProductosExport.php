<?php

namespace App\Exports;

use App\Models\Producto;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Style\Style;
use Box\Spout\Writer\XLSX\Writer;

class ProductosExport
{
    public function export()
    {
        $filePath = storage_path('app/public/productos.xlsx');

        // Crear el escritor de Excel
        $writer = WriterEntityFactory::createXLSXWriter();
        $writer->openToFile($filePath);

        // Crear estilo para el encabezado
        $style = (new Style())
            ->setFontBold();

        // Crear el encabezado
        $headerRow = WriterEntityFactory::createRowFromArray(
            ['ID', 'Nombre','Descripción','Costo','Precio','Cantidad', 'Codigo','Categoría'],
            $style
        );
        $writer->addRow($headerRow);

        // Obtener los productos
        $productos = Producto::all();

        // Añadir los datos
        foreach ($productos as $producto) {
            $row = WriterEntityFactory::createRowFromArray([
                $producto->id,
                $producto->nombre,
                $producto->descripcion,
                $producto->costo_unidad,
                $producto->precio_unidad,
                $producto->cantidad_disponible,
                $producto->codigo,
                $producto->categoria
            ]);
            $writer->addRow($row);
        }

        // Cerrar el escritor
        $writer->close();

        return $filePath;
    }
}
