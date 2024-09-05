import { Component, OnInit, OnDestroy } from '@angular/core';
import { ProductosService } from '../../servicios/productos.service';
import Pusher from 'pusher-js';

@Component({
  selector: 'app-inventario',
  templateUrl: './inventario.component.html',
  styleUrl: './inventario.component.css',
})
export class InventarioComponent implements OnInit, OnDestroy {
  totalProductos: number = 0;
  costoTotal: number = 0;
  private pusher: Pusher;
  private channel: any;
  isCrearCategoriaVisible: boolean = false;
  isCrearProductoVisible: boolean = false;
  isExpInventario: boolean = false;


  constructor(private productoService: ProductosService) {
    this.pusher = new Pusher('1858994', {
      cluster: 'us2',
    });
  }
  ngOnInit(): void {
    this.productoService.obtenerCostoTotal().subscribe((data) => {
      this.costoTotal = data.costo_total;
    });
    this.fetchTotalProductos();
    this.initializePusher();
  }

  ngOnDestroy(): void {
    if (this.channel) {
      this.channel.unbind_all();
      this.channel.unsubscribe();
    }
    if (this.pusher) {
      this.pusher.disconnect();
    }
  }
  fetchTotalProductos() {
    this.productoService.getTotalProductos().subscribe({
      next: (data) => {
        this.totalProductos = data.total;
      },
      error: (error) => {
        console.error('Error al obtener el total de productos', error);
      },
    });
  }

  initializePusher() {
    this.channel = this.pusher.subscribe('productos');
    this.channel.bind('ProductoAgregado', (data: any) => {
      this.fetchTotalProductos();
    });
  }
 /* cerrarCrearProducto() {
    this.mostrarCrearProducto = false;
  }*/
  onCloseCrearProducto() {
    this.isCrearProductoVisible = false;
  }

  onOpenCrearProducto() {
    this.isCrearProductoVisible = true;
  }

  onCloseCrearCategoria() {
    this.isCrearCategoriaVisible = false;
  }

  onOpenCrearCategoria() {
    this.isCrearCategoriaVisible = true;
  }

  onOpenExpInventario() {
    this.isExpInventario = true;
  }
  onCloseExpInventario() {
    this.isExpInventario = false;
  }
}
