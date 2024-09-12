import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EliminarcategoriaComponent } from './eliminarcategoria.component';

describe('EliminarcategoriaComponent', () => {
  let component: EliminarcategoriaComponent;
  let fixture: ComponentFixture<EliminarcategoriaComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [EliminarcategoriaComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(EliminarcategoriaComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
