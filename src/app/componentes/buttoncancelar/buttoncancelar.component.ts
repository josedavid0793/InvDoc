import { Component, EventEmitter, Output } from '@angular/core';

@Component({
  selector: 'app-buttoncancelar',
  templateUrl: './buttoncancelar.component.html',
  styleUrl: './buttoncancelar.component.css'
})
export class ButtoncancelarComponent {
  @Output() close = new EventEmitter<void>();

  onCancel() {
    this.close.emit();
  }
}
