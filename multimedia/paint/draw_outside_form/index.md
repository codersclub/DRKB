---
Title: Как рисовать за пределами формы?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как рисовать за пределами формы?
================================

Создайте обработчик сообщения для WM\_NCPAINT.

Следующий пример рисует
красную расмку вокруг формы шириной в один пиксель.

    type 
      TForm1 = class(TForm) 
      private 
        { Private declarations } 
        procedure WMNCPaint(var Msg : TWMNCPaint); message WM_NCPAINT; 
      public 
        { Public declarations } 
      end; 
     
    var 
      Form1: TForm1; 
     
    implementation 
     
    {$R *.DFM} 
     
    procedure TForm1.WMNCPaint(var Msg: TWMNCPaint); 
    var 
      dc : hDc; 
      Pen : hPen; 
      OldPen : hPen; 
      OldBrush : hBrush; 
    begin 
      inherited; 
      dc := GetWindowDC(Handle); 
      msg.Result := 1; 
      Pen := CreatePen(PS_SOLID, 1, RGB(255, 0, 0)); 
      OldPen := SelectObject(dc, Pen); 
      OldBrush := SelectObject(dc, GetStockObject(NULL_BRUSH)); 
      Rectangle(dc, 0,0, Form1.Width, Form1.Height); 
      SelectObject(dc, OldBrush); 
      SelectObject(dc, OldPen); 
      DeleteObject(Pen); 
      ReleaseDC(Handle, Canvas.Handle); 
    end;

