---
Title: Как записать содержимое окна OpenGL в bmp файл?
Date: 01.01.2007
---


Как записать содержимое окна OpenGL в bmp файл?
===============================================

::: {.date}
01.01.2007
:::

gr - объект, в канве которого я рисую с помощью OpenGL

    bt := TBitmap.Create;
    with bt do
    begin
      Width := gr.Width;
      Height := gr.Height;
      Canvas.CopyRect(ClientRect, gr.Canvas, gr.ClientRect);
      SaveToFile('e:\bt.bmp');
      Free;
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
