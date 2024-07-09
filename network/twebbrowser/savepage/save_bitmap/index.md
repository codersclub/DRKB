---
Title: Как сохранить веб-страничку в Bitmap?
Author: John
Date: 01.01.2007
Source: FAQ: <https://blackman.km.ru/myfaq/cont4.phtml>
---


Как сохранить веб-страничку в Bitmap?
=====================================


_Перевод материала с сайта members.home.com/hfournier/webbrowser.htm_

    procedure TForm1.Button1Click(Sender: TObject);
    var
      ViewObject: IViewObject;
      sourceDrawRect: TRect;
    begin
      if EmbeddedWB1.Document < > nil then
      try
        EmbeddedWB1.Document.QueryInterface(IViewObject, ViewObject);
        if ViewObject < > nil then
        try
          sourceDrawRect := Rect(0, 0, Image1.Width, Image1.Height);
          ViewObject.Draw(DVASPECT_CONTENT, 1, nil, nil, Self.Handle,
          image1.Canvas.Handle, @sourceDrawRect, nil, nil, 0);
        finally
          ViewObject._Release;
        end;
      except
      end;
    end;
