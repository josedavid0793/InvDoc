import { Component,Output,EventEmitter } from '@angular/core';

@Component({
  selector: 'app-eliminarcategoria',
  templateUrl: './eliminarcategoria.component.html',
  styleUrl: './eliminarcategoria.component.css'
})
export class EliminarcategoriaComponent {
  @Output() close = new EventEmitter<void>();


  onCancel() {
    this.close.emit();
  }
}
