---
Title: Напечатать миллиметровку
Date: 01.01.2007
---

Напечатать миллиметровку
========================

    program PrnGrid;
     
    uses
      Dialogs,
      Printers,
      Windows,
      Types;
     
    {$R *.res}
     
    function GetPenWidth(I: Integer): Integer;
    begin
      if I mod 100 = 0 then
        Result := 45
      else if I mod 50 = 0 then
        Result := 30
      else if I mod 10 = 0 then
        Result := 20
      else if I mod 5 = 0 then
        Result := 15
      else
        Result := 10;
    end;
     
    var
      PageRect: TRect;
      I, J: Integer;
    begin
      with TPrintDialog.Create(nil) do
      try
        if not Execute then
          Exit;
      finally
        Free;
      end;
     
      PageRect := Rect(0, 0, Printer.PageWidth, Printer.PageHeight);
      Printer.Title := 'Милиметровка';
      Printer.BeginDoc;
      try
        try
          with Printer.Canvas do
          begin
            SetMapMode(Handle, MM_HIMETRIC);
            DPtoLP(Handle, PageRect, 2);
     
            with PageRect do
            begin
             Inc(Left, 1000);
             Dec(Top, 1000);
             Dec(Right, 1000);
             Inc(Bottom, 1000);
            end;
     
            J := 0;
            I := PageRect.Left;
            while I < PageRect.Right  do
            begin
              Pen.Width := GetPenWidth(J);
              MoveTo(I, PageRect.Top);
              LineTo(I, PageRect.Bottom);
              Inc(I, 100);
              Inc(J);
            end;
     
            J := 0;
            I := PageRect.Top;
            while I > PageRect.Bottom do
            begin
              Pen.Width := GetPenWidth(J);
              MoveTo(PageRect.Left, I);
              LineTo(PageRect.Right, I);
              Dec(I, 100);
              Inc(J);
            end;
          end;
        except
          Printer.Abort;
          raise;
        end;
      finally
        Printer.EndDoc;
      end;
    end.
