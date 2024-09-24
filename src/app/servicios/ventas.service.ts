import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class VentasService {
  apiUrl = 'http://127.0.0.1:8000/api/';
  constructor(private http: HttpClient) { }

    // Método para obtener el total de ventas
    getTotalVentas(): Observable<{ total: number }> {
      return this.http.get<{ total: number }>(`${this.apiUrl}ventas/suma-total`);
    }

    // Método para obtener el total de gastos
    getTotalGastos(): Observable<{ total: number }> {
      return this.http.get<{ total: number }>(`${this.apiUrl}gastos/suma-total`);
    }
    exportarPdfReport() {
      return this.http.get(`${this.apiUrl}balance-reporte/pdf?fecha_inicio=2023-09-01&fecha_fin=2024-09-30`, {
        responseType: 'blob',
      });
    }
    exportarExcelReport() {
      return this.http.get(`${this.apiUrl}balance-reporte/excel?fecha_inicio=2023-09-01&fecha_fin=2024-09-30`, {
        responseType: 'blob',
      });
    }
}
