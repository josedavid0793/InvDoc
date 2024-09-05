import { Component,Output, EventEmitter } from '@angular/core';
import { ProductosService } from '../../servicios/productos.service';
import { saveAs } from 'file-saver';
@Component({
  selector: 'app-expinventario',
  templateUrl: './expinventario.component.html',
  styleUrl: './expinventario.component.css',
})
export class ExpinventarioComponent {
  @Output() close = new EventEmitter<void>();
  constructor(private productoService: ProductosService) {}

  exportarPdf() {
    this.productoService.exportarPdf().subscribe((response) => {
      saveAs(response, 'productos.pdf');
    });
  }
  exportarExcel() {
    this.productoService.exportarExcel().subscribe((response) => {
      saveAs(response, 'productos.xlsx');
    });
  }
  onCancel() {
    this.close.emit();
  }
}
