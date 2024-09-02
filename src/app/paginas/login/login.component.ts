import { Component, OnInit } from '@angular/core';
import {FormGroup, FormControl, Validators, ValidatorFn, AbstractControl} from '@angular/forms';
import { UsuariosService } from '../../servicios/usuarios.service';
@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrl: './login.component.css'
})
export class LoginComponent {
  usuarioForm: any;
  successMessage: string = '';
  errorMessage: string = '';
  constructor(private usuarioService: UsuariosService) { }
  ngOnInit(){
    this.usuarioForm = new FormGroup({
      nombres: new FormControl('', [Validators.required, Validators.minLength(2)]),
      apellidos: new FormControl(''),
      email: new FormControl('', [Validators.required, Validators.email]),
      contraseña: new FormControl('', [Validators.required, Validators.minLength(6)]),
      confirmar_contraseña: new FormControl('', [Validators.required, Validators.minLength(6)]),
      tipo_documento: new FormControl('', [Validators.required]),
      numero_documento: new FormControl('', [Validators.required, Validators.maxLength(10)]),
      telefono: new FormControl('', [Validators.required, Validators.maxLength(13)]),
    }, { validators: this.contraseñaMatchValidator });
  }

// Método personalizado para validar que las contraseñas coincidan
contraseñaMatchValidator: ValidatorFn = (form: AbstractControl): { [key: string]: boolean } | null => {
  const passwordControl = form.get('contraseña');
  const confirmPasswordControl = form.get('confirmar_contraseña');

  if (!passwordControl || !confirmPasswordControl) {
    return null; // Si no se encuentran los controles, no se realiza ninguna validación
  }

  const password = passwordControl.value;
  const confirmPassword = confirmPasswordControl.value;

  return password === confirmPassword ? null : { mismatch: true };
};

onSubmit() {
  if (this.usuarioForm.valid) {
    this.usuarioService.crearUsuario(this.usuarioForm.value).subscribe(
      response => {
        this.successMessage = response.message;
          this.errorMessage = '';
        console.log('Usuario creado:', response);
      },
      error => {
        this.errorMessage = error;
          this.successMessage = '';
        console.error('Error al crear usuario:', error);
      }
    );
  } else {
    this.errorMessage = 'Por favor, completa todos los campos correctamente.';
    this.successMessage = '';
    console.log('Formulario inválido');
  }
}
}
