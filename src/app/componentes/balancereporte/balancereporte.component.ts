import { Component,Output,EventEmitter } from '@angular/core';
import { VentasService } from '../../servicios/ventas.service';
import { saveAs } from 'file-saver';

@Component({
  selector: 'app-balancereporte',
  templateUrl: './balancereporte.component.html',
  styleUrl: './balancereporte.component.css'
})
export class BalancereporteComponent {
  @Output() close = new EventEmitter<void>();
  constructor(private ventasService: VentasService) {}

  exportarPdf() {
    this.ventasService.exportarPdfReport().subscribe((response) => {
      saveAs(response, 'balance-reporte.pdf');
    });
  }
  exportarExcel() {
    this.ventasService.exportarExcelReport().subscribe((response) => {
      saveAs(response, 'balance-reporte.xlsx');
    });
  }
  onCancel() {
    this.close.emit();
  }
}
