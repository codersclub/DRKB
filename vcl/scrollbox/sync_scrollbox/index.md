---
Title: Синхронизация двух компонентов TScrollBox
Date: 01.01.2007
---


Синхронизация двух компонентов TScrollBox
=========================================

::: {.date}
01.01.2007
:::

Решить задачу помогут обработчики событий OnScroll (в данном примере два
компонента ScrollBox (ScrollBar1 и ScrollBar2) расположены на форме
TMainForm):

    procedure TMainForm.ScrollBar1Scroll(Sender: TObject;
    ScrollCode: TScrollCode; var ScrollPos: Integer);
    begin
      ScrollBar2.Position:=ScrollPos;
    end;
     
    procedure TMainForm.ScrollBar2Scroll(Sender: TObject;
    ScrollCode: TScrollCode; var ScrollPos: Integer);
    begin
      ScrollBar1.Position := ScrollPos;
    end;

Взято с <https://delphiworld.narod.ru>
