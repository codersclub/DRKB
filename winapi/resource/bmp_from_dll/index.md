---
Title: Как загрузить BMP файл из DLL?
Author: Baa
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---

Как загрузить BMP файл из DLL?
==============================

    procedure TForm1.Button1Click(Sender: TObject);
    var
      AModule: THandle;
    begin
      AModule := LoadLibrary('Images.dll');
      image1.Picture.BitMap.LoadFromResourceName(AModule, 'StartMine');
      FreeLibrary(AModule);
    end;

