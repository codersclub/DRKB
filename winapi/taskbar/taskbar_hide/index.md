---
Title: Как скрыть TaskBar?
Date: 01.01.2007
---

Как скрыть TaskBar?
===================

::: {.date}
01.01.2007
:::

    //Спрятать
    procedure TForm1.Button1Click(Sender: TObject);
    var
      hTaskBar : THandle;
    begin
      hTaskbar := FindWindow('Shell_TrayWnd', Nil);
      ShowWindow(hTaskBar, SW_HIDE);
    end;
     
     
    //Показать
    procedure TForm1.Button2Click(Sender: TObject);
    var
      hTaskBar : THandle;
    begin
      hTaskbar := FindWindow('Shell_TrayWnd', Nil);
      ShowWindow(hTaskBar, SW_SHOWNORMAL);
    end;

Взято из <https://forum.sources.ru>

------------------------------------------------------------------------

    ShowWindow(FindWindow('Shell_TrayWnd', nil), sw_hide);

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
