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
  selector: 'app-crearcategoria',
  templateUrl: './crearcategoria.component.html',
  styleUrl: './crearcategoria.component.css'
})
export class CrearcategoriaComponent implements OnInit {
  @Output() close = new EventEmitter<void>();
  categoriaForm: any;
  successMessage: string = '';
  errorMessage: string = '';

  constructor(private productoService: ProductosService) {}

  ngOnInit(): void {
    this.categoriaForm = new FormGroup({
      nombre: new FormControl('', [
        Validators.required,
        Validators.minLength(2),
      ]),
      descripcion: new FormControl(''),
    });
  }

  onSubmit() {
    if (this.categoriaForm.valid) {
      this.productoService.crearCategoria(this.categoriaForm.value).subscribe(
        response => {
          this.successMessage = response.mensaje;
            this.errorMessage = '';
          console.log('Categoría creado:', response);
          // Emitir el evento cuando el formulario se envíe correctamente
    this.close.emit();
        },
        error => {
          this.errorMessage = error;
            this.successMessage = '';
          console.error('Error al crear Categoría:', error);
        }
      );
    } else {
      this.errorMessage = 'Por favor, completa todos los campos correctamente.';
      this.successMessage = '';
      console.log('Formulario inválido');
    }
  }
  onCancel() {
    this.close.emit();
  }
}
