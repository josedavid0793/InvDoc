import { Component, Output, EventEmitter, OnInit } from '@angular/core';
import {
  FormGroup,
  FormControl,
  Validators,
  ValidatorFn,
  AbstractControl,
} from '@angular/forms';
import { ProductosService } from '../../servicios/productos.service';
@Component({
  selector: 'app-crearproducto',
  templateUrl: './crearproducto.component.html',
  styleUrl: './crearproducto.component.css',
})
export class CrearproductoComponent implements OnInit {
  @Output() close = new EventEmitter<void>();
  productoForm: any;
  successMessage: string = '';
  errorMessage: string = '';
  cantidad: number = 0;
  categorias: any[] = [];
  constructor(private productoService: ProductosService) {}

  ngOnInit(): void {
    this.productoService.obtenerCategorias().subscribe(
      (data: any[]) => {
        this.categorias = data;
      },
      (error) => {
        console.error('Error al obtener categorías', error);
      }
    );

    this.productoForm = new FormGroup({
      nombre: new FormControl('', [
        Validators.required,
        Validators.minLength(2),
      ]),
      descripcion: new FormControl(''),
      precio_unidad: new FormControl(''),
      costo_unidad: new FormControl(''),
      codigo: new FormControl(''),
      cantidad_disponible: new FormControl(''),
      imagen: new FormControl(''),
      categoria: new FormControl(''),
    });
  }

  onSubmit() {
    if (this.productoForm.valid) {
      this.productoService.crearProducto(this.productoForm.value).subscribe(
        response => {
          this.successMessage = response.mensaje;
            this.errorMessage = '';
          console.log('Producto creado:', response);
          // Emitir el evento cuando el formulario se envíe correctamente
    this.close.emit();
        },
        error => {
          this.errorMessage = error;
            this.successMessage = '';
          console.error('Error al crear Producto:', error);
        }
      );
    } else {
      this.errorMessage = 'Por favor, completa todos los campos correctamente.';
      this.successMessage = '';
      console.log('Formulario inválido');
    }
  }
  onFileSelected(event: Event): void {
    const input = event.target as HTMLInputElement;
    if (input.files && input.files[0]) {
      const file = input.files[0];
      const reader = new FileReader();

      reader.onload = (e: any) => {
        const label = document.querySelector(
          '.camera-label'
        ) as HTMLLabelElement;
        label.style.backgroundImage = `url('${e.target.result}')`;
        label.style.backgroundSize = 'cover'; // Ajusta el tamaño de la imagen para cubrir el área del botón
      };

      reader.readAsDataURL(file);
    }
  }

  increment(): void {
    this.cantidad++;
  }

  decrement(): void {
    if (this.cantidad > 0) {
      this.cantidad--;
    }
  }
  onInputChange(): void {
    // Asegurarse de que la cantidad no sea negativa
    if (this.cantidad < 0) {
      this.cantidad = 0;
    }
  }
  onCancel() {
    this.close.emit();
  }
}
