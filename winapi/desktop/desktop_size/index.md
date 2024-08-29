---
Title: Определить размера рабочей области Desktop\'а
Author: Даниил Карапетян (delphi4all@narod.ru)
Date: 01.01.2007
---


Определить размера рабочей области Desktop\'а
=============================================

Вариант 1:

Author: Даниил Карапетян (delphi4all@narod.ru)

Иногда важно знать, какую часть экрана можно занимать, не перекрывая тем
самым такие окна, как TaskBar. Эта программа разворачивает окно на всю
рабочую область Desktop\'а.

    procedure TForm1.Button1Click(Sender: TObject);
    var
      r : TRect;
    begin
      SystemParametersInfo(SPI_GETWORKAREA, 0, Addr(r), 0);
      Form1.Left := r.Left;
      Form1.Top := r.Top;
      Form1.Width := r.Right - r.Left;
      Form1.Height := r.Bottom - r.Top;
    end;


Автор справки: Алексей Денисов (aleksey@sch103.krasnoyarsk.su)

------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Воспользуйтесь функцией SystemParametersInfo(), переслав ей в качестве
параметров - SPI\_GETWORKAREA и адрес структуры типа TRect, куда будут
передан полученный результат:

    procedure TForm1.Button1Click(Sender: TObject);
    var
      r: TRect;
    begin
      SystemParametersInfo(SPI_GETWORKAREA, 0, @r, 0);
      Memo1.Lines.Add(IntToStr(r.Top));
      Memo1.Lines.Add(IntToStr(r.Left));
      Memo1.Lines.Add(IntToStr(r.Bottom));
      Memo1.Lines.Add(IntToStr(r.Right));
    end; 

 

------------------------------------------------------------------------

Вариант 3:

Author: Dimka Maslov, mainbox@endimus.ru

Date: 04.11.2002

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Получение координат области Рабочего стола, не скрытой Панелью задач
     
    Зависимости: Windows
    Автор:       Dimka Maslov, mainbox@endimus.ru, ICQ:148442121, Санкт-Петербург
    Copyright:   Dimka Maslov
    Дата:        4 ноября 2002 г.
    ***************************************************** }
     
    function GetDesktopRect: TRect;
    var
      RgnDesktop, RgnTrayWnd: HRGN;
     
    function CreateWindowRgn(Handle: HWND): HRGN;
    var
      R: TRect;
    begin
      GetWindowRect(Handle, R);
      with R do
        Result := CreateRectRgn(Left, Top, Right, Bottom);
    end;
     
    begin
      RgnDesktop := CreateWindowRgn(GetDesktopWindow);
      try
        RgnTrayWnd := CreateWindowRgn(FindWindow('Shell_TrayWnd', ''));
        try
          CombineRgn(RgnDesktop, RgnDesktop, RgnTrayWnd, RGN_DIFF);
          GetRgnBox(RgnDesktop, Result);
        finally
          DeleteObject(RgnTrayWnd);
        end;
      finally
        DeleteObject(RgnDesktop);
      end;
    end;
