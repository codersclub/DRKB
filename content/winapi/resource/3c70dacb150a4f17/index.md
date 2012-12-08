---
Title: Как загрузить BMP файл из DLL?
Author: Baa
Date: 01.01.2007
---

Как загрузить BMP файл из DLL?
==============================

::: {.date}
01.01.2007
:::

    procedure TForm1.Button1Click(Sender: TObject);

    var
      AModule: THandle;
    begin
      AModule := LoadLibrary('Images.dll');
      image1.Picture.BitMap.LoadFromResourceName(AModule, 'StartMine');
      FreeLibrary(AModule);
    end;

Автор: Baa

Взято с Vingrad.ru <https://forum.vingrad.ru>
