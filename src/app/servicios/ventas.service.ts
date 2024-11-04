import { Injectable } from '@angular/core';
import { HttpClient,HttpErrorResponse } from '@angular/common/http';
import { Observable,throwError } from 'rxjs';
import { map } from 'rxjs/operators';
import { catchError } from 'rxjs/operators';

@Injectable({
  providedIn: 'root',
})
export class VentasService {
  apiUrl = 'http://127.0.0.1:8000/api/';
  constructor(private http: HttpClient) {}

  // Método para obtener el total de ventas
  getTotalVentas(): Observable<{ total: number }> {
    return this.http.get<{ total: number }>(`${this.apiUrl}ventas/suma-total`);
  }

  // Método para obtener el total de gastos
  getTotalGastos(): Observable<{ total: number }> {
    return this.http.get<{ total: number }>(`${this.apiUrl}gastos/suma-total`);
  }
  exportarPdfReport() {
    return this.http.get(
      `${this.apiUrl}balance-reporte/pdf?fecha_inicio=2023-09-01&fecha_fin=2024-09-30`,
      {
        responseType: 'blob',
      }
    );
  }
  exportarExcelReport() {
    return this.http.get(
      `${this.apiUrl}balance-reporte/excel?fecha_inicio=2023-09-01&fecha_fin=2024-09-30`,
      {
        responseType: 'blob',
      }
    );
  }

  getContarVentas(): Observable<{ total: number }> {
    return this.http.get<{ total: number }>(`${this.apiUrl}ventas/total?fecha_inicio=2023-09-01&fecha_fin=2024-09-30`);
  }
  getContarVentasAbonos(): Observable<{ total: number }> {
    return this.http.get<{ total: number }>(`${this.apiUrl}ventas/total-abonos?fecha_inicio=2023-09-01&fecha_fin=2024-09-30`);
  }
  getContarGastos(): Observable<{ total: number }> {
    return this.http.get<{ total: number }>(`${this.apiUrl}gastos/total`);
  }
  getEfectivoVentas(): Observable<{ total: number }> {
    return this.http.get<{ total: number }>(`${this.apiUrl}ventas/efectivo-total?fecha_inicio=2023-09-01&fecha_fin=2024-09-30`);
  }
  getNoEfectivoVentas(): Observable<{ total: number }> {
    return this.http.get<{ total: number }>(`${this.apiUrl}ventas/no-efectivo-total?fecha_inicio=2023-09-01&fecha_fin=2024-09-30`);
  }
  getEfectivoVentasCredito(): Observable<{ total: number }> {
    return this.http.get<{ total: number }>(`${this.apiUrl}ventas/credito/efectivo-total?fecha_inicio=2023-09-01&fecha_fin=2024-09-30`);
  }
  getNoEfectivoVentasCredito(): Observable<{ total: number }> {
    return this.http.get<{ total: number }>(`${this.apiUrl}ventas/credito/no-efectivo-total?fecha_inicio=2023-09-01&fecha_fin=2024-09-30`);
  }
  getEfectivoGastos(): Observable<{ total: number }> {
    return this.http.get<{ total: number }>(`${this.apiUrl}gastos/efectivo-total?fecha_inicio=2023-09-01&fecha_fin=2024-09-30`);
  }
  getNoEfectivoGastos(): Observable<{ total: number }> {
    return this.http.get<{ total: number }>(`${this.apiUrl}gastos/no-efectivo-total?fecha_inicio=2023-09-01&fecha_fin=2024-09-30`);
  }
  getEfectivoCreditoGastos(): Observable<{ total: number }> {
    return this.http.get<{ total: number }>(`${this.apiUrl}gastos/credito/efectivo-total?fecha_inicio=2023-09-01&fecha_fin=2024-09-30`);
  }
  getNoEfectivoCreditoGastos(): Observable<{ total: number }> {
    return this.http.get<{ total: number }>(`${this.apiUrl}gastos/credito/no-efectivo-total?fecha_inicio=2023-09-01&fecha_fin=2024-09-30`);
  }
  getTotalCostosPrecios():Observable<{total_costos:number,total_precios:number}>{
    return this.http.get<{ total_costos: number,total_precios:number }>(`${this.apiUrl}ventas/totales`);

  }
  getTotalVentasFull(): Observable<any[]>{
    return this.http.get<any>(`${this.apiUrl}ventas`);
  }
  getTotalGastosFull(): Observable<any>{
    return this.http.get<any>(`${this.apiUrl}gastos`);
  }
  getTotalClientes(): Observable<any>{
    return this.http.get<any[]>(`${this.apiUrl}clientes`).pipe(
      map(response => response[0]));;
  }
}
