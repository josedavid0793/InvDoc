import { Component } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { group } from 'console';

@Component({
  selector: 'app-registro',
  templateUrl: './registro.component.html',
  styleUrl: './registro.component.css',
})
export class RegistroComponent {
  usuarioForm!: FormGroup;

  constructor(private fb: FormBuilder) {
    this.usuarioForm = this.fb.group({
      nombres: ['', [Validators.required, Validators.minLength(3)]],
      apellidos: ['', [Validators.required, Validators.minLength(3)]],
      email: ['', [Validators.required, Validators.email]],
      contraseña: ['', [Validators.required, Validators.minLength(8)]],
      confirmar_contraseña: [
        '',
        [Validators.required, Validators.minLength(8)],
      ],
      tipo_documento: ['', [Validators.required, Validators.minLength(8)]],
      numero_documento: ['', [Validators.required, Validators.minLength(8)]],
      telefono: ['', [Validators.required, Validators.minLength(8)]],
    });
  }
  onSubmit() {
    if (this.usuarioForm.valid) {
      console.log(this.usuarioForm.value);
    }
  }
}
