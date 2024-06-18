---
Title: Как записать содержимое окна OpenGL в bmp файл?
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Как записать содержимое окна OpenGL в bmp файл?
===============================================

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


