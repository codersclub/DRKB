---
Title: Как сохранить веб-страничку в JPG?
Author: Donall Burns
Date: 01.01.2007
Source: FAQ: <https://blackman.km.ru/myfaq/cont4.phtml>
---


Как сохранить веб-страничку в JPG?
==================================


_Перевод материала с сайта members.home.com/hfournier/webbrowser.htm_

    procedure generateJPEGfromBrowser(browser: iWebBrowser2; jpegFQFilename: String;
      srcHeight: Integer; srcWidth: Integer; tarHeight: Integer; tarWidth: Integer);
    var
      sourceDrawRect : TRect;
      targetDrawRect: TRect;
      sourceBitmap: TBitmap;
      targetBitmap: TBitmap;
      jpeg: TJPEGImage;
      viewObject: IViewObject;
    begin
      sourceBitmap := TBitmap.Create ;
      targetBitmap := TBitmap.Create ;
      jpeg := TJPEGImage.Create ;
      try
        try
          sourceDrawRect := Rect(0,0, srcWidth, srcHeight );
          sourceBitmap.Width := srcWidth ;
          sourceBitmap.Height := srcHeight ;
          viewObject := browser as IViewObject;
          if viewObject = nil then
            Exit;
          // Изменяем размер исходного битмапа для конечного битмапа
          OleCheck(viewObject.Draw(DVASPECT_CONTENT, 1, nil, nil, self.Handle,
            sourceBitmap.Canvas.Handle, @sourceDrawRect, nil, nil, 0));
          targetDrawRect := Rect(0,0, tarWidth, tarHeight);
          targetBitmap.Height := tarHeight;
          targetBitmap.Width := tarWidth;
          targetBitmap.Canvas.StretchDraw(targetDrawRect, sourceBitmap);
          // Создаём JPEG из Bitmap и сохраняем его
          jpeg.Assign(targetBitmap) ;
          makeFileWriteable(jpegFQFilename);
          jpeg.SaveToFile (jpegFQFilename);
        finally
          jpeg.free;
          sourceBitmap.free ;
          targetBitmap.free;
        end;
      except
      // Обработка ошибок
      end;
    end;

