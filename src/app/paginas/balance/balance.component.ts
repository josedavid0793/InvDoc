import {
  Component,
  OnInit,
  OnDestroy,
  AfterViewChecked ,
  ViewChild,
} from '@angular/core';
import { VentasService } from '../../servicios/ventas.service';
import { DetallebalanceComponent } from '../../componentes/detallebalance/detallebalance.component';
import Pusher from 'pusher-js';

@Component({
  selector: 'app-balance',
  templateUrl: './balance.component.html',
  styleUrl: './balance.component.css',
})
export class BalanceComponent implements OnInit, OnDestroy  {
  @ViewChild(DetallebalanceComponent)
  detallebalanceComponent!: DetallebalanceComponent;
  totalVentas: number = 0; // Variable para almacenar el total de ventas
  totalGastos: number = 0; // Variable para almacenar el total de gastos
  totalBalance: number = 0; // Variable para almacenar el balance calculado
  private pusher: Pusher;
  private channel: any;
  isExpBalance: boolean = false;
  isDetBalance: boolean = false;

  constructor(private ventasService: VentasService) {
    this.pusher = new Pusher('1858994', {
      cluster: 'us2',
    });
  }

  ngOnInit(): void {
    this.obtenerTotalVentas();
    this.initializePusher();
    this.obtenerTotalGastos();
    this.initializePusher2();
  }
 // Método que se llamará cuando el componente hijo esté listo
 onChildInitialized() {
  if (this.detallebalanceComponent.scrollableElement) {
    const scrollableDiv = this.detallebalanceComponent.scrollableElement.nativeElement;
    scrollableDiv.scrollTop = scrollableDiv.scrollHeight; // Mueve el scroll al final
  }
}



  ngOnDestroy(): void {
    if (this.channel) {
      this.channel.unbind_all();
      this.channel.unsubscribe();
    }
    if (this.pusher) {
      this.pusher.disconnect();
    }
  }

  obtenerTotalVentas() {
    // Llamar al servicio para obtener el total de ventas
    this.ventasService.getTotalVentas().subscribe((response) => {
      this.totalVentas = response.total;
      this.calcularBalance(); // Recalcular el balance cada vez que cambien las ventas
    });
  }

  initializePusher() {
    this.channel = this.pusher.subscribe('ventas-channel');
    this.channel.bind('VentasAgregada', (data: any) => {
      this.obtenerTotalVentas();
    });
  }
  obtenerTotalGastos() {
    // Llamar al servicio para obtener el total de ventas
    this.ventasService.getTotalGastos().subscribe((response) => {
      this.totalGastos = response.total;
      this.calcularBalance(); // Recalcular el balance cada vez que cambien los gastos
    });
  }
  initializePusher2() {
    this.channel = this.pusher.subscribe('gastos-channel');
    this.channel.bind('GastosAgregado', (data: any) => {
      this.obtenerTotalGastos();
    });
  }
  // Función para recalcular el balance
  calcularBalance() {
    this.totalBalance = this.totalVentas - this.totalGastos;
  }
  onOpenExpBalance() {
    this.isExpBalance = true;
  }
  onCloseExpBalance() {
    this.isExpBalance = false;
  }

  onOpenDetBalance() {
    this.isDetBalance = true;
  }
  onCloseDetBalance() {
    this.isDetBalance = false;
  }
}
