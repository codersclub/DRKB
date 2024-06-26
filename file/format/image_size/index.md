---
Title: Как узнать размер картинки для JPG, GIF и PNG файлов?
Date: 01.01.2007
---


Как узнать размер картинки для JPG, GIF и PNG файлов?
=====================================================

Вариант 1:

Source: https://www.swissdelphicenter.ch/en/tipsindex.php

    unit ImgSize; 
     
    interface 
     
    uses Classes; 
     
    procedure GetJPGSize(const sFile: string; var wWidth, wHeight: Word); 
    procedure GetPNGSize(const sFile: string; var wWidth, wHeight: Word); 
    procedure GetGIFSize(const sGIFFile: string; var wWidth, wHeight: Word); 
     
     
    implementation 
     
    uses SysUtils; 
     
    function ReadMWord(f: TFileStream): Word; 
    type 
      TMotorolaWord = record 
        case Byte of 
          0: (Value: Word); 
          1: (Byte1, Byte2: Byte); 
      end; 
    var 
      MW: TMotorolaWord; 
    begin 
      { It would probably be better to just read these two bytes in normally } 
      { and then do a small ASM routine to swap them.  But we aren't talking } 
      { about reading entire files, so I doubt the performance gain would be } 
      { worth the trouble. } 
      f.read(MW.Byte2, SizeOf(Byte)); 
      f.read(MW.Byte1, SizeOf(Byte)); 
      Result := MW.Value; 
    end; 
     
    procedure GetJPGSize(const sFile: string; var wWidth, wHeight: Word); 
    const 
      ValidSig: array[0..1] of Byte = ($FF, $D8); 
      Parameterless = [$01, $D0, $D1, $D2, $D3, $D4, $D5, $D6, $D7]; 
    var 
      Sig: array[0..1] of byte; 
      f: TFileStream; 
      x: integer; 
      Seg: byte; 
      Dummy: array[0..15] of byte; 
      Len: word; 
      ReadLen: LongInt; 
    begin 
      FillChar(Sig, SizeOf(Sig), #0); 
      f := TFileStream.Create(sFile, fmOpenRead); 
      try 
        ReadLen := f.read(Sig[0], SizeOf(Sig)); 
     
        for x := Low(Sig) to High(Sig) do 
          if Sig[x] <> ValidSig[x] then ReadLen := 0; 
     
        if ReadLen > 0 then 
        begin 
          ReadLen := f.read(Seg, 1); 
          while (Seg = $FF) and (ReadLen > 0) do 
          begin 
            ReadLen := f.read(Seg, 1); 
            if Seg <> $FF then 
            begin 
              if (Seg = $C0) or (Seg = $C1) then 
              begin 
                ReadLen := f.read(Dummy[0], 3); { don't need these bytes } 
                wHeight := ReadMWord(f); 
                wWidth  := ReadMWord(f); 
              end  
              else  
              begin 
                if not (Seg in Parameterless) then 
                begin 
                  Len := ReadMWord(f); 
                  f.Seek(Len - 2, 1); 
                  f.read(Seg, 1); 
                end  
                else 
                  Seg := $FF; { Fake it to keep looping. } 
              end; 
            end; 
          end; 
        end; 
      finally 
        f.Free; 
      end; 
    end; 
     
    procedure GetPNGSize(const sFile: string; var wWidth, wHeight: Word); 
    type 
      TPNGSig = array[0..7] of Byte; 
    const 
      ValidSig: TPNGSig = (137,80,78,71,13,10,26,10); 
    var 
      Sig: TPNGSig; 
      f: tFileStream; 
      x: integer; 
    begin 
      FillChar(Sig, SizeOf(Sig), #0); 
      f := TFileStream.Create(sFile, fmOpenRead); 
      try 
        f.read(Sig[0], SizeOf(Sig)); 
        for x := Low(Sig) to High(Sig) do 
          if Sig[x] <> ValidSig[x] then Exit; 
        f.Seek(18, 0); 
        wWidth := ReadMWord(f); 
        f.Seek(22, 0); 
        wHeight := ReadMWord(f); 
      finally 
        f.Free; 
      end; 
    end; 
     
     
    procedure GetGIFSize(const sGIFFile: string; var wWidth, wHeight: Word); 
    type 
      TGIFHeader = record 
        Sig: array[0..5] of char; 
        ScreenWidth, ScreenHeight: Word; 
        Flags, Background, Aspect: Byte; 
      end; 
     
      TGIFImageBlock = record 
        Left, Top, Width, Height: Word; 
        Flags: Byte; 
      end; 
    var 
      f: file; 
      Header: TGifHeader; 
      ImageBlock: TGifImageBlock; 
      nResult: integer; 
      x: integer; 
      c: char; 
      DimensionsFound: boolean; 
    begin 
      wWidth  := 0; 
      wHeight := 0; 
     
      if sGifFile = '' then 
        Exit; 
     
      {$I-} 
      FileMode := 0;   { read-only } 
      AssignFile(f, sGifFile); 
      reset(f, 1); 
      if IOResult <> 0 then 
        { Could not open file } 
        Exit; 
     
      { Read header and ensure valid file. } 
      BlockRead(f, Header, SizeOf(TGifHeader), nResult); 
      if (nResult <> SizeOf(TGifHeader)) or (IOResult <> 0) or 
        (StrLComp('GIF', Header.Sig, 3) <> 0) then 
      begin 
        { Image file invalid } 
        Close(f); 
        Exit; 
      end; 
     
      { Skip color map, if there is one } 
      if (Header.Flags and $80) > 0 then 
      begin 
        x := 3 * (1 shl ((Header.Flags and 7) + 1)); 
        Seek(f, x); 
        if IOResult <> 0 then 
        begin 
          { Color map thrashed } 
          Close(f); 
          Exit; 
        end; 
      end; 
     
      DimensionsFound := False; 
      FillChar(ImageBlock, SizeOf(TGIFImageBlock), #0); 
      { Step through blocks. } 
      BlockRead(f, c, 1, nResult); 
      while (not EOF(f)) and (not DimensionsFound) do 
      begin 
        case c of 
          ',': { Found image } 
            begin 
              BlockRead(f, ImageBlock, SizeOf(TGIFImageBlock), nResult); 
              if nResult <> SizeOf(TGIFImageBlock) then  
              begin 
                { Invalid image block encountered } 
                Close(f); 
                Exit; 
              end; 
              wWidth := ImageBlock.Width; 
              wHeight := ImageBlock.Height; 
              DimensionsFound := True; 
            end; 
          'y': { Skip } 
            begin 
              { NOP } 
            end; 
          { nothing else.  just ignore } 
        end; 
        BlockRead(f, c, 1, nResult); 
      end; 
      Close(f); 
      {$I+} 
    end; 
     
    end. 


------------------------------------------------------------------------

Вариант 2:

Source: https://www.swissdelphicenter.ch/en/tipsindex.php

Размер Gif файла:

    type
      TImageSize = record
        Width: Integer;
        Height: Integer;
      end;
     
    function ReadGIFSize(Stream: TStream): TImageSize;
    type
      TGifHeader = record
        Signature: array [0..5] of Char;
        Width, Height: Word;
      end;
    var
      Header: TGifHeader;
    begin
      FillChar(Header, SizeOf(TGifHeader), #0);
      Result.Width := -1;
      Result.Height := -1;
      with Stream do
      begin
        Seek(0, soFromBeginning);
        ReadBuffer(Header, SizeOf(TGifHeader));
      end;
      if (AnsiUpperCase(Header.Signature) = 'GIF89A') or
        (AnsiUpperCase(Header.Signature) = 'GIF87A') then
      begin
        Result.Width  := Header.Width;
        Result.Height := Header.Height;
      end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    const
      FileName = 'D:\test.gif';
    var
      fs: TFileStream;
      gifsize: TImageSize;
    begin
      fs := TFileStream.Create(FileName, fmOpenRead or fmShareDenyWrite);
      try
        gifsize := ReadGIFSize(fs);
        ShowMessage(Format('Breite %d Hohe %d', [gifsize.Width, gifsize.Height]));
      finally
        fs.Free;
      end;
    end;

