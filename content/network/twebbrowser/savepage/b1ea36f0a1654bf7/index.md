---
Title: Как сохранить веб-страничку в Bitmap?
Author: John
Date: 01.01.2007
---


Как сохранить веб-страничку в Bitmap?
=====================================

::: {.date}
01.01.2007
:::

Взято из FAQ:<https://blackman.km.ru/myfaq/cont4.phtml>

Перевод материала с сайта members.home.com/hfournier/webbrowser.htm

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

Автор: John
