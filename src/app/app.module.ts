import { NgModule } from '@angular/core';
import { BrowserModule, provideClientHydration } from '@angular/platform-browser';
import { ReactiveFormsModule, FormBuilder, FormGroup, Validators } from '@angular/forms';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { HeaderComponent } from './componentes/header/header.component';
import { TerminosComponent } from './componentes/terminos/terminos.component';
import { FooterComponent } from './componentes/footer/footer.component';
import { InicioComponent } from './paginas/inicio/inicio.component';
import { RegistroComponent } from './paginas/registro/registro.component';
import { LoginComponent } from './paginas/login/login.component';

@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    TerminosComponent,
    FooterComponent,
    InicioComponent,
    RegistroComponent,
    LoginComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    ReactiveFormsModule,
    FormBuilder,
    FormGroup,
    Validators
  ],
  providers: [
    provideClientHydration()
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
