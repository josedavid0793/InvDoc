import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EditarproductoComponent } from './editarproducto.component';

describe('EditarproductoComponent', () => {
  let component: EditarproductoComponent;
  let fixture: ComponentFixture<EditarproductoComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [EditarproductoComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(EditarproductoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
