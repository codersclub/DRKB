---
Title: Копирование потока компонент в буфер обмена
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Копирование потока компонент в буфер обмена
===========================================

    { 
      Clipboard has  methods  GetComponent and SetComponent but we need 
      to stream multiple components to the clipboard to include copy paste type 
      of feature. 
    }
     
     
    procedure CopyStreamToClipboard(fmt: Cardinal; S: TStream);
    var
      hMem: THandle;
      pMem: Pointer;
    begin
      S.Position := 0;
      hMem       := GlobalAlloc(GHND or GMEM_DDESHARE, S.Size);
      if hMem <> 0 then
      begin
        pMem := GlobalLock(hMem);
        if pMem <> nil then
        begin
          S.Read(pMem^, S.Size);
          S.Position := 0;
          GlobalUnlock(hMem);
          Clipboard.Open;
          try
            Clipboard.SetAsHandle(fmt, hMem);
          finally
            Clipboard.Close;
          end;
        end { If }
        else
        begin
          GlobalFree(hMem);
          OutOfMemoryError;
        end;
      end { If }
      else
        OutOfMemoryError;
    end; { CopyStreamToClipboard }

    procedure CopyStreamFromClipboard(fmt: Cardinal; S: TStream);
    var
      hMem: THandle;
      pMem: Pointer;
    begin
      hMem := Clipboard.GetAsHandle(fmt);
      if hMem <> 0 then
      begin
        pMem := GlobalLock(hMem);
        if pMem <> nil then
        begin
          S.Write(pMem^, GlobalSize(hMem));
          S.Position := 0;
          GlobalUnlock(hMem);
        end { If }
        else
          raise Exception.Create('CopyStreamFromClipboard: could not lock global handle ' +
            'obtained from clipboard!');
      end; { If }
    end; { CopyStreamFromClipboard }

