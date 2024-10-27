---
Title: Как скрыть TaskBar?
Date: 01.01.2007
---

Как скрыть TaskBar?
===================

Вариант 1:

Source: <https://forum.sources.ru>

    // Спрятать
    procedure TForm1.Button1Click(Sender: TObject);
    var
      hTaskBar : THandle;
    begin
      hTaskbar := FindWindow('Shell_TrayWnd', Nil);
      ShowWindow(hTaskBar, SW_HIDE);
    end;
     
     
    // Показать
    procedure TForm1.Button2Click(Sender: TObject);
    var
      hTaskBar : THandle;
    begin
      hTaskbar := FindWindow('Shell_TrayWnd', Nil);
      ShowWindow(hTaskBar, SW_SHOWNORMAL);
    end;

------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    ShowWindow(FindWindow('Shell_TrayWnd', nil), sw_hide);

