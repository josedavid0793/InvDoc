import { Component, EventEmitter, Input, Output, OnInit } from '@angular/core';

@Component({
  selector: 'app-getcategoria',
  templateUrl: './getcategoria.component.html',
  styleUrls: ['./getcategoria.component.css']
})
export class GetcategoriaComponent implements OnInit {
  @Input() categorias: any[] = []; // Recibe las categorías desde el componente padre
  @Output() close = new EventEmitter<void>(); // Evento para notificar al padre que debe cerrarse
  categoriaAEliminar: any = null;
  isEliminarCategoria: boolean = false;

  currentPage: number = 1;  // Página actual
  itemsPerPage: number = 4; // Categorías por página
  paginatedCategorias: any[] = []; // Categorías visibles en la página actual

  // Función que se llama al inicializar el componente
  ngOnInit() {
    this.setPaginatedCategorias(); // Cargar categorías de la primera página al iniciar
  }

  // Función para cerrar el modal
  onClose() {
    this.close.emit(); // Emite el evento para cerrar el componente
  }

  // Función para actualizar las categorías visibles según la página actual
  setPaginatedCategorias() {
    const startIndex = (this.currentPage - 1) * this.itemsPerPage;
    const endIndex = startIndex + this.itemsPerPage;
    this.paginatedCategorias = this.categorias.slice(startIndex, endIndex);
  }

  // Obtiene el número total de páginas basado en el número de categorías
  get totalPages() {
    return Math.ceil(this.categorias.length / this.itemsPerPage);
  }

  // Cambiar página y actualizar las categorías visibles
  changePage(page: number) {
    if (page > 0 && page <= this.totalPages) {
      this.currentPage = page;
      this.setPaginatedCategorias();
    }
  }
  onOpenEliminarCategoria(categoria: any) {
    this.categoriaAEliminar = categoria;
    this.isEliminarCategoria = true;
  }
  onCloseEliminarCategoria() {
    this.isEliminarCategoria = false;
    this.categoriaAEliminar = null;
  }
  onCategoriaEliminado() {
    this.setPaginatedCategorias(); // Recargar la lista de productos
    this.onCloseEliminarCategoria();
  }
}
