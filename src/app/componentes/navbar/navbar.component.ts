import { Component } from '@angular/core';

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrl: './navbar.component.css'
})
export class NavbarComponent {
  menuVisible: boolean = false;

  toggleMenu(event: MouseEvent) {
    this.menuVisible = !this.menuVisible;
    event.stopPropagation(); // Para evitar que el evento se propague al hacer clic
  }
}
