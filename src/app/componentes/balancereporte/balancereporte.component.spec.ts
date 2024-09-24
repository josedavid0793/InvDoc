import { ComponentFixture, TestBed } from '@angular/core/testing';

import { BalancereporteComponent } from './balancereporte.component';

describe('BalancereporteComponent', () => {
  let component: BalancereporteComponent;
  let fixture: ComponentFixture<BalancereporteComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [BalancereporteComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(BalancereporteComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
