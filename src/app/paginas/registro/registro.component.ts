import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators,FormControl } from '@angular/forms';



@Component({
  selector: 'app-registro',
  templateUrl: './registro.component.html',
  styleUrl: './registro.component.css',
})
export class RegistroComponent {
  usuarioForm!: FormGroup;

  constructor(private fb: FormBuilder) {
    this.usuarioForm = this.fb.group({
      nombres: ['', [Validators.required]],
      apellidos: ['', [Validators.required]],
      email: ['', [Validators.required, Validators.email]],
      contraseña: ['', [Validators.required, Validators.minLength(6)]],
      confirmar_contraseña: ['', [Validators.required]],
      tipo_documento: ['', [Validators.required]],
      numero_documento: ['', [Validators.required]],
      telefono: ['', [Validators.required]]
    });
  }


  /*checkPasswords(group: FormGroup) {
    let pass = group.get('contraseña').value;
    let confirmPass = group.get('confirmar_contraseña').value;
    return pass === confirmPass ? null : { notSame: true }
  }*/

  onSubmit() {
    if (this.usuarioForm.valid) {
      console.log(this.usuarioForm.value);
      // Aquí puedes enviar los datos al servidor
    } else {
      console.log('Formulario inválido');
    }
  }
}
