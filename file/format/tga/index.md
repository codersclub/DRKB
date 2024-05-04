---
Title: Работа с TGA файлами
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Работа с TGA файлами
====================

    const
      FERRORMSG2 = 'Sorry, Unsupported Compressed(RLE) File Format';
      FERRORMSG3 = 'Sorry, Unsupported More Than 256 Colours File Format';
     
    type
      TArrBuff = array[1..512] of Byte;
      TPalette_Cell = record
        b2, g2, r2: byte;
      end;
      TPal = array[0..255] of TPalette_Cell;
      TPPal = ^TPal;
      TTGA_Header = record // Targa(TGA) HEADER //
        IDLength, ColorMap, ImageType: byte;
        ClrMapSpes: array[1..5] of byte;
        XAwal, YAwal, Width, Height: SmallInt;
        BpPixel, ImageDescription: byte;
      end;
     
    var
      pal: TPPal;
      pFile: file;
      buffer: TArrBuff;
      FTgaHeader: TTGA_Header;
     
    procedure THPTGA.ReadImageData2Bitmap;
    var
      i, j, idx: integer;
    begin
      Seek(pFile, sizeof(FtgaHeader) + FtgaHeader.IDLength + 768);
      for i := FtgaHeader.Height - 1 downto FtgaHeader.YAwal do
      begin
        BlockRead(pFile, buffer, FtgaHeader.Width);
        for j := FtgaHeader.XAwal to FtgaHeader.Width - 1 do
        begin
          idx := j - FtgaHeader.XAwal + 1;
          SetPixel(Bitmap.Canvas.Handle, j, i, rgb(pal^[buffer[idx]].r2,
            pal^[buffer[idx]].g2, pal^[buffer[idx]].b2));
        end;
      end;
    end;
     
    procedure THPTGA.LoadFromFile(const FileName: string);
    begin
      AssignFile(pFile, FileName);
    {$I-}Reset(pFile, 1);
    {$I+}
      if (IOResult = 0) then
      begin
        try
          BlockRead(pFile, FtgaHeader, SizeOf(FtgaHeader));
          // checking unsupported features here
          if (FtgaHeader.ImageType > 3) then
          begin
            MessageBox(Application.Handle, FERRORMSG2, 'TGA Viewer Error', MB_ICONHAND);
            exit;
          end;
          if (FtgaHeader.BpPixel > 8) then
          begin
            MessageBox(Application.Handle, FERRORMSG3, 'TGA Viewer Error', MB_ICONHAND);
            exit;
          end;
          GetMem(pal, 768);
          try
            Bitmap.Width := FtgaHeader.Width;
            Bitmap.Height := FtgaHeader.Height;
            // if use Color-Map and Uncompressed then read it
            if (FtgaHeader.ImageType = 1) then
              BlockRead(pFile, pal^, 768);
            ReadImageData2Bitmap;
          finally
            FreeMem(pal);
          end;
        finally
          CloseFile(pFile);
        end;
      end
      else
        MessageBox(Application.Handle, 'Error Opening File', 'TGA Viewer Error',
          MB_ICONHAND);
    end;

