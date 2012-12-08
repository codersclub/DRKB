---
Title: Копирование большого файла в буфер обмена
Date: 01.01.2007
---


Копирование большого файла в буфер обмена
=========================================

::: {.date}
01.01.2007
:::

Вот общее решение, которое будет работать, даже если у вас размер файла
превышает 64Кб:

    function _hread(FileHandle: word; BufPtr: pointer;
      ByteCount: longint): longint; far;
      external 'KERNEL' index 349;
     
    procedure CopyFileToClipboard(const fname: string);
    var
      hmem, hFile: THandle;
      size: LongInt;
      p: Pointer;
    begin
      hFile := FileOpen(fname, fmOpenRead);
      try
        size := FileSeek(hFile, 0, 2);
        FileSeek(hfile, 0, 0);
        if size > 0 then
        begin
          hmem := GlobalAlloc(GHND, size);
          if hMem <> 0 then
          begin
            p := GlobalLock(hMem);
            if p <> nil then
            begin
              _hread(hFile, p, size);
              GlobalUnlock(hMem);
              Clipboard.SetAsHandle(CF_TEXT, hMem);
            end
            else
              GlobalFree(hMem);
          end;
        end;
      finally
        FileClose(hFile);
      end;
    end;
     
    procedure TForm1.SpeedButton2Click(Sender: TObject);
    var
      fname: string[128];
    begin
      if OpenDialog1.Execute then
      begin
        fname := OpenDialog1.Filename;
        CopyFileToClipboard(fname);
      end;
    end;
     
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

Примечание Vit

Похоже это актуально только для Windows 3x
