import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DetallebalanceComponent } from './detallebalance.component';

describe('DetallebalanceComponent', () => {
  let component: DetallebalanceComponent;
  let fixture: ComponentFixture<DetallebalanceComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [DetallebalanceComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(DetallebalanceComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
