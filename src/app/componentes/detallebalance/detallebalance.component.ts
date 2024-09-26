import {
  AfterViewInit,
  Component,
  ElementRef,
  EventEmitter,
  Output,
  ViewChild,
} from '@angular/core';
import { VentasService } from '../../servicios/ventas.service';
import Pusher from 'pusher-js';
import { forkJoin } from 'rxjs';

@Component({
  selector: 'app-detallebalance',
  templateUrl: './detallebalance.component.html',
  styleUrl: './detallebalance.component.css',
})
export class DetallebalanceComponent implements AfterViewInit {
  @Output() close = new EventEmitter<void>();
  @Output() initialized = new EventEmitter<void>();
  @ViewChild('scrollableElement') scrollableElement!: ElementRef;
  totalVentas: number = 0; // Variable para almacenar el total de ventas
  totalGastos: number = 0; // Variable para almacenar el total de gastos
  totalBalance: number = 0; // Variable para almacenar el balance calculado
  numeroVentas: number = 0;
  numeroGastos: number = 0;
  numeroEfecVentas: number = 0;
  numeroNoEfecVentas: number = 0;
  numeroEfecGastos: number = 0;
  numeroNoEfecGastos: number = 0;
  numeroVentasAbonos: number = 0;
  numeroEfecVentasCredito: number = 0;
  numeroNoEfecVentasCredito: number = 0;
  numeroEfecGastosCred: number = 0;
  numeroNoEfecGastosCred: number = 0;
  numTotalVentas: number = 0;
  totalPrecioProd: number = 0;
  totalCostoProd: number = 0;
  totalGanancia: number = 0;

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
    this.numeroTotalVentas();
    this.numeroTotalVentasAbonos();
    this.numeroTotalGastos();
    this.totalEfectivoVentas();
    this.totalNoEfectivoVentas();
    this.totalEfectivoVentasCredito();
    this.totalNoEfectivoVentasCredito();
    this.totalEfectivoGastos();
    this.totalNoEfectivoGastos();
    this.totalEfectivoGastosCredito();
    this.totalNoEfectivoGastosCredito();
    this.totalVentasMostrar();
    this.totalCostosPreciosVentas();
    this.totalGanancias();
  }

  ngAfterViewInit() {
    this.initialized.emit();
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

  onCancel() {
    this.close.emit();
  }
  numeroTotalVentas() {
    this.ventasService.getContarVentas().subscribe((response) => {
      this.numeroVentas = response.total;
    });
  }
  numeroTotalVentasAbonos() {
    this.ventasService.getContarVentasAbonos().subscribe((response) => {
      this.numeroVentasAbonos = response.total;
    });
  }
  numeroTotalGastos() {
    this.ventasService.getContarGastos().subscribe((response) => {
      this.numeroGastos = response.total;
    });
  }
  totalEfectivoVentas() {
    this.ventasService.getEfectivoVentas().subscribe((response) => {
      this.numeroEfecVentas = response.total;
    });
  }
  totalNoEfectivoVentas() {
    this.ventasService.getNoEfectivoVentas().subscribe((response) => {
      this.numeroNoEfecVentas = response.total;
    });
  }

  totalEfectivoVentasCredito() {
    this.ventasService.getEfectivoVentasCredito().subscribe((response) => {
      this.numeroEfecVentasCredito = response.total;
    });
  }

  totalNoEfectivoVentasCredito() {
    this.ventasService.getNoEfectivoVentasCredito().subscribe((response) => {
      this.numeroNoEfecVentasCredito = response.total;
    });
  }
  totalEfectivoGastos() {
    this.ventasService.getEfectivoGastos().subscribe((response) => {
      this.numeroEfecGastos = response.total;
    });
  }
  totalNoEfectivoGastos() {
    this.ventasService.getNoEfectivoGastos().subscribe((response) => {
      this.numeroNoEfecGastos = response.total;
    });
  }
  totalEfectivoGastosCredito() {
    this.ventasService.getEfectivoCreditoGastos().subscribe((response) => {
      this.numeroEfecGastosCred = response.total;
    });
  }
  totalNoEfectivoGastosCredito() {
    this.ventasService.getNoEfectivoCreditoGastos().subscribe((response) => {
      this.numeroNoEfecGastosCred = response.total;
    });
  }
  totalVentasMostrar() {
    forkJoin({
      ventas: this.ventasService.getContarVentas(),
      abonos: this.ventasService.getContarVentasAbonos(),
    }).subscribe((result) => {
      this.numeroVentas = result.ventas.total;
      this.numeroVentasAbonos = result.abonos.total;
      this.numTotalVentas = this.numeroVentas + this.numeroVentasAbonos;
    });
  }
  totalCostosPreciosVentas() {
    this.ventasService.getTotalCostosPrecios().subscribe((response) => {
      this.totalPrecioProd = response.total_precios;
      this.totalCostoProd = response.total_costos;
    });
  }
  totalGanancias() {
    forkJoin({
      total : this.ventasService.getTotalCostosPrecios(),
    }).subscribe((result)=>{
      this.totalPrecioProd = result.total.total_precios;
      this.totalCostoProd = result.total.total_costos;
      this.totalGanancia = this.totalPrecioProd - this.totalCostoProd;
    });
  }
}
