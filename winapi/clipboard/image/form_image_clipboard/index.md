---
Title: Скопировать изображение формы
Date: 01.01.2007
---


Скопировать изображение формы
=============================

::: {.date}
01.01.2007
:::

    uses clipbrd;
     
    procedure TShowVRML.Kopieren1Click(Sender: TObject);
    var
      bitmap: tbitmap;
    begin
      bitmap := tbitmap.create;
      bitmap.width := clientwidth;
      bitmap.height := clientheight;
      try
        with bitmap.Canvas do
          CopyRect(clientrect, canvas, clientrect);
        clipboard.assign(bitmap);
      finally
        bitmap.free;
      end;
    end;
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
