---
Title: Как удалить вертикальную полосу прокрутки (скроллбар) из TDBGrid?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как удалить вертикальную полосу прокрутки (скроллбар) из TDBGrid?
=================================================================

Для этого необходимо переопределить метод Paint. Внутри метода Paint Вы
должны вызвать API процедуру SetScrollRange для установки минимального и
максимального значений скроллирования в ноль (тем самым запретив
скроллбар), а затем вызвать inherited. Следующий код, это unit
содержащий новый компонент под названием TNoScrollBarDBGrid, который
делает это.

    type 
      TNoScrollBarDBGrid = class(TDBGrid) 
      private 
      protected 
        procedure Paint; override; 
      public 
      published 
      end; 
     
    procedure Register; 
     
    implementation 
     
    procedure Register; 
    begin 
      RegisterComponents('Samples', [TNoScrollBarDBGrid]); 
    end; 
     
    { TNoScrollBarDBGrid } 
     
    procedure TNoScrollBarDBGrid.Paint; 
    begin 
      SetScrollRange(Handle, SB_VERT, 0, 0, false); 
      inherited; 
    end;

