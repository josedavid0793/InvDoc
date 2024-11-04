import { Component, Output, EventEmitter, OnInit } from '@angular/core';
import { FormGroup, FormControl, Validators } from '@angular/forms';
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
  selectedFiles: File[] = [];
  previewUrl: string | null = null;
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
      //imagen: new FormControl(''),
      imagen: new FormControl(null),
      categoria: new FormControl(''),
    });
  }

  onSubmit() {
    if (this.productoForm.valid) {
      const formData = new FormData();

      // Agregar los campos del formulario al FormData
      Object.keys(this.productoForm.value).forEach((key) => {
        formData.append(key, this.productoForm.get(key).value);
      });

      // Agregar los archivos seleccionados al FormData
      this.selectedFiles.forEach((file, index) => {
        formData.append(`imagen[]`, file, file.name);
        console.log('no se cargo la imagen');
      });

      this.productoService.crearProducto(formData).subscribe(
        (response) => {
          this.successMessage = response.mensaje;
          this.errorMessage = '';
          console.log('Producto creado:', response);
          this.close.emit();
        },
        (error) => {
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

  onFileChange(event: Event): void {
    const input = event.target as HTMLInputElement;
    if (input.files && input.files.length > 0) {
      this.selectedFiles = Array.from(input.files);

      // Mostrar vista previa de la primera imagen
      const firstFile = this.selectedFiles[0];
      const reader = new FileReader();

      reader.onload = (e: any) => {
        this.previewUrl = `url('${e.target.result}')`;
      };

      reader.readAsDataURL(firstFile);
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
  onClose() {
    this.close.emit();
  }
}
