import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

//componentes
import { InicioComponent } from './paginas/inicio/inicio.component';
import { RegistroComponent } from './paginas/registro/registro.component';
import { LoginComponent } from './paginas/login/login.component';
import { InventarioComponent } from './paginas/inventario/inventario.component';

export const routes: Routes = [
  {path:'',redirectTo:'/inicio',pathMatch:'full'},
  {path:'inicio', component:InicioComponent},
  {path:'registro', component:RegistroComponent},
  {path:'login', component:LoginComponent},
  {path:'inventario', component:InventarioComponent},
];
@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }