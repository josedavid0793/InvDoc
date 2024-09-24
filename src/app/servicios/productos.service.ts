import { Injectable } from '@angular/core';
import { HttpClient,HttpErrorResponse } from '@angular/common/http';
import { Observable,throwError } from 'rxjs';
import { map } from 'rxjs/operators';
import { catchError } from 'rxjs/operators';


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
  obtenerCategorias():Observable<any[]>{
    return this.http.get<any[]>(`${this.apiUrl}categorias`).pipe(
      map(response => response[0]));
  }
  obtenerProductos():Observable<any[]>{
    return this.http.get<any[]>(`${this.apiUrl}productos`).pipe(
      map(response => response[0]));
  }
  crearProducto(formData: FormData):Observable<any>{
    return this.http.post<any>(`${this.apiUrl}productos/crear`,formData).pipe(
      catchError(this.handleError)
    );
  }
  crearCategoria(categoria:any):Observable<any>{
    return this.http.post<any>(`${this.apiUrl}categorias/crear`,categoria).pipe(
      catchError(this.handleError)
    );
  }
  exportarPdf() {
    return this.http.get(`${this.apiUrl}productos/export/pdf`, {
      responseType: 'blob',
    });
  }
  exportarExcel() {
    return this.http.get(`${this.apiUrl}productos/export/excel`, {
      responseType: 'blob',
    });
  }
  getProductosCategoria(nombreCategoria: string): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}productos/categoria/${nombreCategoria}`);
  }
  private handleError(error: HttpErrorResponse) {
    let errorMessage = 'Ocurrió un error desconocido';
    if (error.error instanceof ErrorEvent) {
      // Error del lado del cliente
      errorMessage = `Error: ${error.error.message}`;
    } else {
      // El backend retornó un código de error
      errorMessage = error.error.error || `Código de error: ${error.status}, mensaje: ${error.message}`;
    }
    console.error(errorMessage);
    return throwError(errorMessage);
  }
  deleteProducto(id: number): Observable<any> {
    return this.http.delete<any>(`${this.apiUrl}productos/${id}`);
  }
  updateProducto(formData: FormData,id: number):Observable<any>{
    formData.append('_method', 'PUT'); // Esto emula una solicitud PUT
    return this.http.post<any>(`${this.apiUrl}productos/${id}`,formData).pipe(
      catchError(this.handleError)
    );
  }
  deleteCategoria(id: number): Observable<any> {
    return this.http.delete<any>(`${this.apiUrl}categorias/${id}`);
  }
}
