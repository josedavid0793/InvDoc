import { Component,Output,EventEmitter, Input } from '@angular/core';
import { ProductosService } from '../../servicios/productos.service';

@Component({
  selector: 'app-eliminarcategoria',
  templateUrl: './eliminarcategoria.component.html',
  styleUrl: './eliminarcategoria.component.css'
})
export class EliminarcategoriaComponent {
  @Input()idCategoria!: number;
  @Input() nombreCategoria!: string;
  @Output() close = new EventEmitter<void>();
  @Output() eliminacionCompleta = new EventEmitter<void>();
  mensaje: string = '';
  error: string = '';

  constructor(private productoService: ProductosService) {}
  eliminarCategoria() {
    this.productoService.deleteCategoria(this.idCategoria).subscribe(
      response => {
        this.mensaje = response.mensaje;
        console.log('Categoría eliminada:', response.data);
        this.eliminacionCompleta.emit();
      },
      error => {
        this.error = error.error.mensaje || 'Ocurrió un error al eliminar la categoría';
        console.error('Error:', error);
      }
    );
  }
  onCancel() {
    this.close.emit();
  }

}
