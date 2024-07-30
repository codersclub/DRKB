---
Title: Синхронизация двух компонентов TScrollBox
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Синхронизация двух компонентов TScrollBox
=========================================

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

