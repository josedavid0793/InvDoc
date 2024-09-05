import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ExpinventarioComponent } from './expinventario.component';

describe('ExpinventarioComponent', () => {
  let component: ExpinventarioComponent;
  let fixture: ComponentFixture<ExpinventarioComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ExpinventarioComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ExpinventarioComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
