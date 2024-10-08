---
Title: Копировать буфер в поток и обратно
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Копировать буфер в поток и обратно
==================================

    uses
       clipbrd;
     
    procedure CopyStreamToClipboard(fmt: Cardinal; S: TStream);
    var
      hMem: THandle;
      pMem: Pointer;
    begin
      Assert(Assigned(S));
      S.Position := 0;
      hMem       := GlobalAlloc(GHND or GMEM_DDESHARE, S.Size);
      if hMem <> 0 then
      begin
        pMem := GlobalLock(hMem);
        if pMem <> nil then
        begin
          try
            S.Read(pMem^, S.Size);
            S.Position := 0;
          finally
            GlobalUnlock(hMem);
          end;
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
      Assert(Assigned(S));
      hMem := Clipboard.GetAsHandle(fmt);
      if hMem <> 0 then
      begin
        pMem := GlobalLock(hMem);
        if pMem <> nil then
        begin
          try
            S.Write(pMem^, GlobalSize(hMem));
            S.Position := 0;
          finally
            GlobalUnlock(hMem);
          end;
        end { If }
        else
          raise Exception.Create('CopyStreamFromClipboard: could not lock global handle ' +
            'obtained from clipboard!');
      end; { If }
    end; { CopyStreamFromClipboard }
    
    procedure SaveClipboardFormat(fmt: Word; writer: TWriter);
    var
      fmtname: array[0..128] of Char;
      ms: TMemoryStream;
    begin
      Assert(Assigned(writer));
      if 0 = GetClipboardFormatName(fmt, fmtname, SizeOf(fmtname)) then
        fmtname[0] := #0;
      ms := TMemoryStream.Create;
      try
        CopyStreamFromClipboard(fmt, ms);
        if ms.Size > 0 then
        begin
          writer.WriteInteger(fmt);
          writer.WriteString(fmtname);
          writer.WriteInteger(ms.Size);
          writer.Write(ms.Memory^, ms.Size);
        end; { If }
      finally
        ms.Free
      end; { Finally }
    end; { SaveClipboardFormat }
    
    procedure LoadClipboardFormat(reader: TReader);
    var
      fmt: Integer;
      fmtname: string;
      Size: Integer;
      ms: TMemoryStream;
    begin
      Assert(Assigned(reader));
      fmt     := reader.ReadInteger;
      fmtname := reader.ReadString;
      Size    := reader.ReadInteger;
      ms      := TMemoryStream.Create;
      try
        ms.Size := Size;
        reader.Read(ms.memory^, Size);
        if Length(fmtname) > 0 then
          fmt := RegisterCLipboardFormat(PChar(fmtname));
        if fmt <> 0 then
          CopyStreamToClipboard(fmt, ms);
      finally
        ms.Free;
      end; { Finally }
    end; { LoadClipboardFormat }
    
    procedure SaveClipboard(S: TStream);
    var
      writer: TWriter;
      i: Integer;
    begin
      Assert(Assigned(S));
      writer := TWriter.Create(S, 4096);
      try
        Clipboard.Open;
        try
          writer.WriteListBegin;
          for i := 0 to Clipboard.formatcount - 1 do
            SaveClipboardFormat(Clipboard.Formats[i], writer);
          writer.WriteListEnd;
        finally
          Clipboard.Close;
        end; { Finally }
      finally
        writer.Free
      end; { Finally }
    end; { SaveClipboard }
    
    procedure LoadClipboard(S: TStream);
    var
      reader: TReader;
    begin
      Assert(Assigned(S));
      reader := TReader.Create(S, 4096);
      try
        Clipboard.Open;
        try
          clipboard.Clear;
          reader.ReadListBegin;
          while not reader.EndOfList do
            LoadClipboardFormat(reader);
          reader.ReadListEnd;
        finally
          Clipboard.Close;
        end; { Finally }
      finally
        reader.Free
      end; { Finally }
    end; { LoadClipboard }
    
    
    
    // Examples: 
     
    { Save Clipboard }
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      ms: TMemoryStream;
    begin
      ms := TMemoryStream.Create;
      try
        SaveClipboard(ms);
        ms.SaveToFile('c:\temp\ClipBrdSaved.dat');
      finally
        ms.Free;
      end; { Finally }
    end;
    
    { Clear Clipboard }
    
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      clipboard.Clear;
    end;
    
    { Restore Clipboard }
    
    procedure TForm1.Button3Click(Sender: TObject);
    var
      fs: TfileStream;
    begin
      fs := TFilestream.Create('c:\temp\ClipBrdSaved.dat',
        fmopenread or fmsharedenynone);
      try
        LoadClipboard(fs);
      finally
        fs.Free;
      end; { Finally }
    end;

