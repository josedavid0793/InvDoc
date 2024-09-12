import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EliminarproductoComponent } from './eliminarproducto.component';

describe('EliminarproductoComponent', () => {
  let component: EliminarproductoComponent;
  let fixture: ComponentFixture<EliminarproductoComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [EliminarproductoComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(EliminarproductoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
