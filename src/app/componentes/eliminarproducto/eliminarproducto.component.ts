import { Component,Output,EventEmitter, Input } from '@angular/core';
import { ProductosService } from '../../servicios/productos.service';
import { response } from 'express';

@Component({
  selector: 'app-eliminarproducto',
  templateUrl: './eliminarproducto.component.html',
  styleUrl: './eliminarproducto.component.css'
})
export class EliminarproductoComponent {
  @Input()idProducto!: number;
  @Input() nombreProducto!: string;
  @Output() close = new EventEmitter<void>();
  @Output() eliminacionCompleta = new EventEmitter<void>();
  productos: any[] = []; // Lista de productos
  mensaje: string = '';
  error: string = '';

  constructor(private productoService: ProductosService) {}
  eliminarProducto() {
    this.productoService.deleteProducto(this.idProducto).subscribe(
      response => {
        this.mensaje = response.mensaje;
        console.log('Producto eliminado:', response.data);
        this.eliminacionCompleta.emit();
      },
      error => {
        this.error = error.error.mensaje || 'Ocurrió un error al eliminar el producto';
        console.error('Error:', error);
      }
    );
  }
  onCancel() {
    this.close.emit();
  }
}
