import { Component, EventEmitter, Output, OnInit } from '@angular/core';
import { CurrencyPipe } from '@angular/common';
import { ProductosService } from '../../servicios/productos.service';
import { VentasService } from '../../servicios/ventas.service';
import { FormGroup, FormControl, Validators } from '@angular/forms';
@Component({
  selector: 'app-crearventa',
  templateUrl: './crearventa.component.html',
  styleUrl: './crearventa.component.css',
})
export class CrearventaComponent implements OnInit {
  @Output() close = new EventEmitter<void>();
  productos: any[] = [];
  clientes: any[] = [];
  mensajeSinResultados: string = '';
  cantidad: number = 0;
  productoSeleccionado: any;
  clienteSeleccionado: any;
  precioUnitario: number = 0;
  totalPrecio: number = 0;
  precioUnitarioDisplay: string = '';
  totalPrecioDisplay: string = '';
  isPagada: boolean = false;
  ventaForm : any;

  constructor(
    private productoService: ProductosService,
    private ventasService: VentasService,
    private currencyPipe: CurrencyPipe
  ) {}
  ngOnInit(): void {
    this.cargarProductos();
    this.actualizarTotal();
    this.cargarClientes();

    this.ventaForm = new FormGroup({
      nombre_producto : new FormControl('',[Validators.required])
    });
  }

  cargarProductos() {
    this.productoService.obtenerProductos().subscribe(
      (data: any[]) => {
        this.productos = data.map((producto) => {
          // Si 'imagen' es una cadena, la convertimos en un array
          if (typeof producto.imagen === 'string') {
            producto.imagen = JSON.parse(producto.imagen);
          }
          return {
            ...producto,
            activeImageIndex: 0, // Inicializamos el índice de imagen activa
          };
        });
        this.mensajeSinResultados =
          this.productos.length === 0 ? 'No se encontraron productos' : '';
      },
      (error) => {
        console.error('Error al obtener productos', error);
      }
    );
  }

  onSelectProducto(event: Event) {
    const selectElement = event.target as HTMLSelectElement;
    const productoNombre = selectElement.value;

    // Ahora puedes continuar con tu lógica de seleccionar el producto
    const producto = this.productos.find((p) => p.nombre === productoNombre);
    if (producto) {
      this.cantidad = 1; // Setear cantidad a 1 por defecto
      this.precioUnitario = producto.precio_unidad; // Setear el precio unitario del producto
      this.actualizarTotal();
    }
  }

  increment(): void {
    this.cantidad++;
    this.actualizarTotal();
  }

  decrement(): void {
    if (this.cantidad > 1) {
      this.cantidad--;
      this.actualizarTotal();
    }
  }
  onInputChange(): void {
    // Asegurarse de que la cantidad no sea negativa
    if (this.cantidad < 1) {
      this.cantidad = 1;
      this.actualizarTotal();
    }
  }
  onCancel() {
    this.close.emit();
  }

  actualizarTotal(): void {
    this.precioUnitarioDisplay =
      this.currencyPipe.transform(
        this.precioUnitario,
        'USD',
        'symbol',
        '1.2-2'
      ) || '';
    this.totalPrecio = this.cantidad * this.precioUnitario;
    this.totalPrecioDisplay =
      this.currencyPipe.transform(this.totalPrecio, 'USD', 'symbol', '1.2-2') ||
      '';
  }
  // Cuando el campo de precio unitario obtiene el foco, muestra el valor numérico
  onPrecioUnitarioFocus(): void {
    this.precioUnitarioDisplay = this.precioUnitario.toString(); // Elimina el formato
  }

  // Cuando el campo pierde el foco, formatea el valor de nuevo y actualiza el total
  onPrecioUnitarioBlur(event: any): void {
    const input = event.target.value;
    const newValue = parseFloat(input);

    if (!isNaN(newValue)) {
      this.precioUnitario = newValue; // Actualiza el valor numérico real
    }

    this.actualizarTotal(); // Formatea el valor de nuevo y actualiza el total
  }

  toggleStatus(): void {
    console.log(this.isPagada ? 'Pagada' : 'A crédito'); // Verifica el estado del switch
  }

  cargarClientes(){
    this.ventasService.getTotalClientes().subscribe(
      (data: any[]) => {
        this.clientes = data;
        console.log(this.clientes);
      },
      (error: any) => {
        console.error('Error al obtener categorías', error);
      }
    );
  }
}
