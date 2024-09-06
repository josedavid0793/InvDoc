import { ComponentFixture, TestBed } from '@angular/core/testing';

import { GetcategoriaComponent } from './getcategoria.component';

describe('GetcategoriaComponent', () => {
  let component: GetcategoriaComponent;
  let fixture: ComponentFixture<GetcategoriaComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [GetcategoriaComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(GetcategoriaComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
