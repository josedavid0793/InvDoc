import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ButtoncancelarComponent } from './buttoncancelar.component';

describe('ButtoncancelarComponent', () => {
  let component: ButtoncancelarComponent;
  let fixture: ComponentFixture<ButtoncancelarComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ButtoncancelarComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ButtoncancelarComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
