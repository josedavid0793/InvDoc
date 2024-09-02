import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ProductosService {
 apiUrl = 'http://127.0.0.1:8000/api/';
  constructor(private http: HttpClient) { }
  getTotalProductos(): Observable<any> {
    return this.http.get<any>(`${this.apiUrl}productos/contar`);
  }
  obtenerCostoTotal(): Observable<any> {
    return this.http.get<any>(`${this.apiUrl}productos/costo-total`);
  }
}
