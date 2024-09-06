import {
  Component,
  OnInit,
  OnDestroy,
  ElementRef,
  ViewChild,
} from '@angular/core';
import { ProductosService } from '../../servicios/productos.service';
import Pusher from 'pusher-js';
import { error } from 'console';

@Component({
  selector: 'app-inventario',
  templateUrl: './inventario.component.html',
  styleUrl: './inventario.component.css',
})
export class InventarioComponent implements OnInit, OnDestroy {
  @ViewChild('slider')
  slider!: ElementRef;
  totalProductos: number = 0;
  costoTotal: number = 0;
  private pusher: Pusher;
  private channel: any;
  categorias: any[] = [];
  productos: any[] = [];
  isCrearCategoriaVisible: boolean = false;
  isCrearProductoVisible: boolean = false;
  isExpInventario: boolean = false;
  isGetCategoria: boolean = false;

  constructor(private productoService: ProductosService) {
    this.pusher = new Pusher('1858994', {
      cluster: 'us2',
    });
  }
  ngOnInit(): void {
    this.cargarCategorias();
    this.cargarProductos();
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

  ngAfterViewInit() {
    this.addSwipeListener();
  }

  moveNext() {
    this.slider.nativeElement.scrollBy({
      left: 200, // Ajusta según el tamaño de los botones
      behavior: 'smooth',
    });
  }

  movePrev() {
    this.slider.nativeElement.scrollBy({
      left: -200, // Ajusta según el tamaño de los botones
      behavior: 'smooth',
    });
  }

  addSwipeListener() {
    const slider = this.slider.nativeElement;
    let startX = 0;

    slider.addEventListener('touchstart', (e: TouchEvent) => {
      startX = e.touches[0].clientX;
    });

    slider.addEventListener('touchmove', (e: TouchEvent) => {
      const touch = e.touches[0];
      const diffX = startX - touch.clientX;

      slider.scrollBy({
        left: diffX,
        behavior: 'smooth',
      });

      startX = touch.clientX;
    });
  }

  cargarCategorias() {
    this.productoService.obtenerCategorias().subscribe(
      (data: any[]) => {
        this.categorias = data;
      },
      (error) => {
        console.error('Error al obtener categorías', error);
      }
    );
  }
  cargarProductos(){
    this.productoService.obtenerProductos().subscribe(
      (data:any[]) =>{
        this.productos = data
      },
      (error) => {
        console.error('Error al obtener productos', error);

      }
  );
  }
  // Filtra los productos por nombre de la categoría
  filtrarProductos(nombreCategoria: string): void {
    this.productoService.getProductosCategoria(nombreCategoria).subscribe(
      (data: any[]) => {
        this.productos = data; // Actualiza la lista de productos con los filtrados
      },
      (error) => {
        console.error('Error al filtrar productos', error);
      }
    );
  }

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
  onOpenGetCategoria() {
    this.isGetCategoria = true;
  }
  onCloseGetCategoria() {
    this.isGetCategoria = false;
  }
}
