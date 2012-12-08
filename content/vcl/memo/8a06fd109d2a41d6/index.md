---
Title: Как нарисовать что-нибудь на TMemo?
Date: 01.01.2007
---


Как нарисовать что-нибудь на TMemo?
===================================

::: {.date}
01.01.2007
:::

Для рисования на поверхности TMemo необходимо создать создать
собственный компонент, наследованный от TMemo и переопределить в нём
рисование. Примерно так:

    type 
      TMyMemo = class(TMemo) 
      protected 
        procedure WMPaint(var Message: TWMPaint); message WM_PAINT; 
      end;

А теперь добавьте реализацию этой процедуры:

    procedure TMyMemo.WMPaint(var Message: TWMPaint); 
    var 
      MCanvas: TControlCanvas; 
      DrawBounds : TRect; 
    Begin 
      inherited; 
      MCanvas:=TControlCanvas.Create; 
      DrawBounds := ClientRect;  // Работаем с временной записью TRect.
      Try 
       MCanvas.Control:=Self; 
       With MCanvas do 
       Begin 
        Brush.Color := clBtnFace; 
        FrameRect( DrawBounds ); 
        InflateRect( DrawBounds, -1, -1); 
        FrameRect( DrawBounds ); 
        FillRect ( DrawBounds ); 
        MoveTo ( 33, 0 ); 
        Brush.Color := clWhite; 
        LineTo ( 33, ClientHeight ); 
        PaintImages; 
       end; 
      finally 
        MCanvas.Free; 
      End; 
    end; 

Процедура PaintImages рисует картинки на канвасе Memo.

    procedure TMyMemo.PaintImages; 
    var 
      MCanvas: TControlCanvas; 
      DrawBounds : TRect; 
      i, j : Integer; 
      OriginalRegion : HRGN; 
      ControlDC : HDC; 
    begin 
      MCanvas:=TControlCanvas.Create; 
      DrawBounds := ClientRect;  // Работаем с временной записью TRect.
      try 
       MCanvas.Control:=Self; 
       ControlDC := GetDC ( Handle ); 
       MCanvas.Draw(0, 1, Application.Icon); 
      finally 
        MCanvas.Free; 
      end; 
    end;

Теперь мы имеем собственноручно нарисованный memo.

Взято из <https://forum.sources.ru>
