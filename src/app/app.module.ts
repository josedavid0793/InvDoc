import { NgModule } from '@angular/core';
import { BrowserModule, provideClientHydration } from '@angular/platform-browser';
import { HttpClientModule } from '@angular/common/http';
import { provideHttpClient } from  '@angular/common/http' ; 

import { ReactiveFormsModule,FormsModule } from '@angular/forms';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { HeaderComponent } from './componentes/header/header.component';
import { TerminosComponent } from './componentes/terminos/terminos.component';
import { FooterComponent } from './componentes/footer/footer.component';
import { InicioComponent } from './paginas/inicio/inicio.component';
import { RegistroComponent } from './paginas/registro/registro.component';
import { LoginComponent } from './paginas/login/login.component';
import { NavbarComponent } from './componentes/navbar/navbar.component';
import { InventarioComponent } from './paginas/inventario/inventario.component';
import { CrearproductoComponent } from './componentes/crearproducto/crearproducto.component';
import { CrearcategoriaComponent } from './componentes/crearcategoria/crearcategoria.component';
import { ExpinventarioComponent } from './componentes/expinventario/expinventario.component';
import { GetcategoriaComponent } from './componentes/getcategoria/getcategoria.component';

@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    TerminosComponent,
    FooterComponent,
    InicioComponent,
    RegistroComponent,
    LoginComponent,
    NavbarComponent,
    InventarioComponent,
    CrearproductoComponent,
    CrearcategoriaComponent,
    ExpinventarioComponent,
    GetcategoriaComponent
  ],
  imports: [
    ReactiveFormsModule,
    FormsModule,
    BrowserModule,
    HttpClientModule,
    AppRoutingModule
    ],
  providers: [
    provideClientHydration()
  ],
  bootstrap: [AppComponent],
 // schemas: [CUSTOM_ELEMENTS_SCHEMA]
})
export class AppModule { }
