---
Title: Как распечатать decision grid?
Date: 01.01.2007
---

Как распечатать decision grid?
==============================

    procedure TForm1.Button2Click(Sender: TObject);
    begin
      Printer.BeginDoc;
      try
        printer.canvas.moveto(100,100);
        SetMapMode( printer.canvas.handle, MM_ANISOTROPIC );
        SetWindowExtEx(printer.canvas.handle,
                       GetDeviceCaps(canvas.handle, LOGPIXELSX),
                       GetDeviceCaps(canvas.handle, LOGPIXELSY),
                       Nil);
        SetViewportExtEx(printer.canvas.handle,
                       GetDeviceCaps(printer.canvas.handle, LOGPIXELSX),
                       GetDeviceCaps(printer.canvas.handle, LOGPIXELSY),
                       Nil);
        grid.PaintTo( printer.canvas.handle, 100, 100 );
      finally
        printer.enddoc;
      end;
    end;

