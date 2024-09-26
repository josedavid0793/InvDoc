<?php

namespace App\Exports;

use App\Models\Ventas;
use App\Models\Gastos;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Style\Style;
use Box\Spout\Writer\XLSX\Writer;

class ReportExport
{
    protected $ventas;
    protected $gastos;

    public function __construct($ventas, $gastos)
    {
        $this->ventas = $ventas;
        $this->gastos = $gastos;
    }

    public function export()
    {
        $filePath = storage_path('balance-reporte.xlsx');

        // Crear el escritor de Excel
        $writer = WriterEntityFactory::createXLSXWriter();
        $writer->openToFile($filePath);

        // Crear estilo para el encabezado
        $style = (new Style())->setFontBold();

        // === HOJA DE VENTAS ===
        $writer->addNewSheetAndMakeItCurrent(); // Crea una nueva hoja
        $writer->getCurrentSheet()->setName('Ventas'); // Asigna el nombre de la hoja

        // Crear encabezado de ventas
        $ventasHeaderRow = WriterEntityFactory::createRowFromArray(
            ['Fecha', 'Valor', 'IVA', 'Total', 'Concepto', 'Producto', 'Cantidad', 'Modalidad', 'Metodo'],
            $style
        );
        $writer->addRow($ventasHeaderRow);

        // Añadir datos de ventas
        foreach ($this->ventas as $venta) {
            $row = WriterEntityFactory::createRowFromArray([
                $venta->fecha,
                $venta->valor,
                $venta->iva,
                $venta->valor_total,
                $venta->concepto,
                $venta->nombre_producto,
                $venta->cantidad,
                $venta->modalidad_pago,
                $venta->metodo_pago,
            ]);
            $writer->addRow($row);
        }

        // === HOJA DE GASTOS ===
        $writer->addNewSheetAndMakeItCurrent(); // Crear una nueva hoja para gastos
        $writer->getCurrentSheet()->setName('Gastos'); // Asignar el nombre de la hoja

        // Crear encabezado de gastos
        $gastosHeaderRow = WriterEntityFactory::createRowFromArray(
            ['Fecha', 'Valor', 'Concepto', 'Modalidad', 'Método','Proveedor','Categoría'],
            $style
        );
        $writer->addRow($gastosHeaderRow);

        // Añadir datos de gastos
        foreach ($this->gastos as $gasto) {
            $row = WriterEntityFactory::createRowFromArray([
                $gasto->fecha,
                $gasto->valor,
                $gasto->concepto,
                $gasto->modalidad_pago,
                $gasto->metodo_pago,
                $gasto->proveedor,
                $gasto->categoria_gasto,
            ]);
            $writer->addRow($row);
        }

        // Cerrar el escritor
        $writer->close();

        return $filePath;
    }
}
