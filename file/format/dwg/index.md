---
Title: Как работать с DWG файлами (AutoCAD)?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как работать с DWG файлами (AutoCAD)?
=====================================

> **Vit:**  
> Примечания в коде были на каком-то не то китайском, не то японском
> языке - поэтому удалены!

    unit DWGView;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      ExtCtrls;
     
    type
      BITMAPINFO256 = record
        bmiHeader: BITMAPINFOHEADER;
        bmiColors: array[0..255] of RGBQUAD;
      end;
     
    type
      TNoPreviewEvent = procedure(Sender: TOBject) of object;
      TFileErrorEvent = procedure(Sender: TOBject; DWGName: string) of object;
     
      TDWGView = class(TImage)
      private
        FDWGVersion: string;
        FDWGFile: string;
        FNoPreviewEvent: TNoPreviewEvent;
        FOnFileError: TFileErrorEvent;
        FImage: TImage;
        procedure SetDWGFile(const Value: string);
        procedure SetFImage(const Value: TImage);
      protected
        procedure ReadDWG;
        constructor TDWGView;
      public
      published
        property Image: TImage read FImage write SetFImage;
        property DWGFile: string read FDWGFile write SetDWGFile;
        property DWGVersion: string read FDWGVersion;
        property OnNoPreview: TNoPreviewEvent read FNoPreviewEvent write FNoPreviewEvent;
        property OnFileError: TFileErrorEvent read FOnFileError write FOnFileError;
      end;
     
    procedure Register;
     
    implementation
     
    procedure Register;
    begin
      RegisterComponents('Voice', [TDWGView]);
    end;
     
    procedure TDWGView.ReadDWG;
    var
      DWGF: TFileStream; 
      MemF: TMemoryStream; 
      BMPF: TMemoryStream; 
      SentinelF: TMemoryStream;
      bif: BITMAPINFO256; 
      bfh: BITMAPFILEHEADER;
      PosSentinel: LongInt; 
      LenPreview: Integer; 
      RasterPreview: ShortInt; 
      PosBMP: Integer; 
      LenBMP: Integer; 
      IndexPreview: Integer;
      TypePreview: Shortint; 
    begin
      if Assigned(FOnFileError) then
        FOnFileError(Self, FDWGFile);
      DWGF := TFileStream.Create(FDWGFile, fmOpenRead);
      BMPF := TMemoryStream.Create;
      MemF := TMemoryStream.Create;
      SentinelF := TMemoryStream.Create;
      try
        SetLength(FDWGVersion, 6);
        DWGF.ReadBuffer(FDWGVersion[1], 6);
        DWGF.Position := 13; 
        DWGF.Read(PosSentinel, 4);
        DWGF.Position := PosSentinel;
        SentinelF.CopyFrom(DWGF, 16); 
        DWGF.Read(LenPreview, 4);
        DWGF.Read(RasterPreview, 1); 
        for IndexPreview := RasterPreview - 1 downto 0 do
        begin
          MemF.Position := 0;
          MemF.CopyFrom(DWGF, 9); 
          MemF.Position := 0;
          MemF.Read(TypePreview, 1); 
          case TypePreview of
            1: ; 
            2:
              begin
                MemF.Position := 1;
                MemF.Read(PosBMP, 4); 
                MemF.Read(LenBMP, 4); 
                DWGF.Position := PosBMP;
                DWGF.ReadBuffer(bif, sizeof(bif));
     
                with bif do
                begin
                  bmiColors[0].rgbBlue := 0;
                  bmiColors[0].rgbGreen := 0;
                  bmiColors[0].rgbRed := 0;
     
                  bmiColors[225].rgbBlue := 255;
                  bmiColors[225].rgbGreen := 255;
                  bmiColors[225].rgbRed := 255;
                end;
     
                bfh.bfType := $4D42;
                bfh.bfSize := LenBMP + sizeof(bfh); 
                bfh.bfReserved1 := 0;
                bfh.bfReserved2 := 0;
                bfh.bfOffBits := 14 + $28 + 1024;
     
                BMPF.Position := 0;
                BMPF.Write(bfh, sizeof(bfh));
                BMPF.WriteBuffer(bif, sizeof(bif));
                BMPF.CopyFrom(DWGF, LenBMP - 1064);
                BMPF.Position := 0;
                Picture.Bitmap.LoadFromStream(BMPF);
              end;
            3: ;
          end;
     
        end;
      finally
        SentinelF.Free;
        MemF.Free;
        DWGF.Free;
        BMPF.Free;
      end;
     
    end;
     
    procedure TDWGView.SetDWGFile(const Value: string);
    begin
      FDWGFile := Value;
      ReadDWG;
    end;
     
    procedure TDWGView.SetFImage(const Value: TImage);
    begin
      FImage := Value;
    end;
     
    constructor TDWGView.TDWGView;
    begin
      //TODO: Add your source code here
      FDWGFile := '';
      FDWGVersion := '';
    end;
     
    end.

