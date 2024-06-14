---
Title: Размер bitmap
Author: Rouse\_
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Размер bitmap
=============

    function PictureSize: TSize;
    var
      ResHandle: HWND;
      ResData: HWND;
      BMI: PBitmapInfo;
    begin
      Result.cx := 0;
      Result.cy := 0;
      ResHandle := FindResource(HInstance,
        MAKEINTRESOURCE(200), RT_BITMAP);
      if ResHandle <> 0 then
      begin
        ResData := LoadResource(HInstance, ResHandle);
        if ResData <> 0 then
        try
          BMI := LockResource(ResData);
          if Assigned(BMI) then
          try
            Result.cx := BMI.bmiHeader.biWidth;
            Result.cy := BMI.bmiHeader.biHeight;
            // размер картинки вот тут: BMI.bmiHeader.biSizeImage
          finally
            UnlockResource(ResData);
          end;
        finally
          FreeResource(ResData);
        end;
      end;
    end;

