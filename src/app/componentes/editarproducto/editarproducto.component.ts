import { Component, Output, EventEmitter, OnInit, Input } from '@angular/core';
import {
  FormGroup,
  FormControl,
  Validators,
  ValidatorFn,
  AbstractControl,
} from '@angular/forms';
import { ProductosService } from '../../servicios/productos.service';
@Component({
  selector: 'app-editarproducto',
  templateUrl: './editarproducto.component.html',
  styleUrl: './editarproducto.component.css',
})
export class EditarproductoComponent implements OnInit {
  @Output() close = new EventEmitter<void>();
  @Input() idProducto!: number;
  @Input() nombreProducto!: string;
  @Input() descripcionProducto!: string;
  @Input() precioUnidadProducto!: string;
  @Input() costoUnidadProducto!: number;
  @Input() codigoProducto!: string;
  @Input() cantidadProducto!: number;
  @Input() imagenProducto!: any[];
  @Input() categoriaProducto!: any[];
  successMessage: string = '';
  errorMessage: string = '';
  cantidad: number = 0;
  categorias: any[] = [];
  formularioProducto!: any;
  selectedFiles: File[] = [];
  previewUrl: string | ArrayBuffer = '';

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
    this.formularioProducto = new FormGroup({
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
      categoria: new FormControl(''),
      // Not including formControl for file input
    });
    this.cargarProducto();
    this.mostrarPrimeraImagen();
  }
  cargarProducto() {
    // Llenar el formulario con los valores o usar valores por defecto si son null o undefined
  this.formularioProducto.patchValue({
    nombre: this.nombreProducto || '',  // Si nombreProducto es null o undefined, usa ''
    descripcion: this.descripcionProducto || '',
    precio_unidad: this.precioUnidadProducto !== null && this.precioUnidadProducto !== undefined ? this.precioUnidadProducto : '', // Si es null/undefined, usa ''
    costo_unidad: this.costoUnidadProducto !== null && this.costoUnidadProducto !== undefined ? this.costoUnidadProducto : '',
    codigo: this.codigoProducto || '',
    cantidad_disponible: this.cantidadProducto !== null && this.cantidadProducto !== undefined ? this.cantidadProducto : '',
    //imagen:this.imagenProducto || '',
    categoria: this.categoriaProducto || '',
  });
  if (this.imagenProducto && this.imagenProducto.length > 0) {
    this.mostrarPrimeraImagen();
  }
  }

  onFileChange(event: Event): void {
    const input = event.target as HTMLInputElement;
    if (input.files && input.files.length > 0) {
      // Añadir nuevos archivos a los existentes
      this.selectedFiles = [...this.selectedFiles, ...Array.from(input.files)];
  
      // Mostrar vista previa de la primera imagen
      const firstFile = this.selectedFiles[0];
      const reader = new FileReader();
  
      reader.onload = (e: any) => {
        this.previewUrl = `url('${e.target.result}')`;
      };
  
      reader.readAsDataURL(firstFile);
    }
  }
  mostrarPrimeraImagen() {
    if (this.imagenProducto && this.imagenProducto.length > 0) {
      let url = this.imagenProducto[0].url || this.imagenProducto[0];
      
      // Verificar si la URL ya contiene '/storage/' y añadirlo si no está presente
      if (!url.includes('/storage/')) {
        const baseUrl = 'http://localhost:4200';
        url = `${baseUrl}/storage${url.startsWith('/') ? '' : '/'}${url}`;
      }
      
      this.previewUrl = `url('${url}')`;
    }
  }

  // Método para guardar el producto editado
  onGuardarProducto() {
    if (this.formularioProducto.valid) {
      const formData = new FormData();
  
      // Agregar los campos del formulario al FormData
      Object.keys(this.formularioProducto.controls).forEach((key) => {
        const control = this.formularioProducto.get(key);
        if (control.value !== null && control.value !== undefined) {
          formData.append(key, control.value);
        }
      });
  
      // Agregar los archivos seleccionados al FormData
      this.selectedFiles.forEach((file, index) => {
        formData.append(`imagen[]`, file, file.name);
      });
  
      this.productoService.updateProducto(formData, this.idProducto).subscribe(
        response => {
          this.successMessage = response.mensaje;
          this.errorMessage = '';
          console.log('Producto actualizado:', response);
          this.close.emit();
        },
        error => {
          if (error.error && error.error.mensaje) {
            this.errorMessage = Object.values(error.error.mensaje).join(', ');
          } else {
            this.errorMessage = 'Error al actualizar el producto';
          }
          this.successMessage = '';
          console.error('Error al actualizar Producto:', error);
        }
      );
    } else {
      this.errorMessage = 'Por favor, completa todos los campos requeridos correctamente.';
      this.successMessage = '';
      console.log('Formulario inválido');
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
    // Resetear formulario y previsualización
    this.formularioProducto.reset();
    this.selectedFiles = [];
    this.previewUrl = '';
    this.close.emit();
  }
}
