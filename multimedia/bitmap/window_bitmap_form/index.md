---
Title: Форма окна по bitmap
Date: 01.01.2007
---


Форма окна по bitmap
====================

    unit Unit1;
     
    interface
    
    uses
      Windows, Classes, SysUtils, Graphics, Forms;
    
    type
      TRGBArray = array[0..32767] of TRGBTriple;
      PRGBArray = ^TRGBArray;
    
    type
      TForm1 = class(TForm)
        procedure FormCreate(Sender: TObject);
        procedure FormDestroy(Sender: TObject);
      private
        { Private declarations }
        FRegion: THandle;
        function CreateRegion(Bmp: TBitmap): THandle;
      end;
    
    var
      Form1: TForm1;
    
    implementation
    
    {$R *.dfm}
    
    function TForm1.CreateRegion(Bmp: TBitmap): THandle;
    var
      X, Y, StartX: Integer;
      Excl: THandle;
      Row: PRGBArray;
      TransparentColor: TRGBTriple;
    begin
      Bmp.PixelFormat := pf24Bit;
    
      Result := CreateRectRGN(0, 0, Bmp.Width, Bmp.Height);
    
      for Y := 0 to Bmp.Height - 1 do
      begin
        Row := Bmp.Scanline[Y];
    
        StartX := -1;
    
        if Y = 0 then
          TransparentColor := Row[0];
    
        for X := 0 to Bmp.Width - 1 do
        begin
          if (Row[X].rgbtRed = TransparentColor.rgbtRed) and
            (Row[X].rgbtGreen = TransparentColor.rgbtGreen) and
            (Row[X].rgbtBlue = TransparentColor.rgbtBlue) then
          begin
            if StartX = -1 then StartX := X;
          end
          else
          begin
            if StartX > -1 then
            begin
              Excl := CreateRectRGN(StartX, Y, X + 1, Y + 1);
              try
                CombineRGN(Result, Result, Excl, RGN_DIFF);
                StartX := -1;
              finally
                DeleteObject(Excl);
              end;
            end;
          end;
        end;
    
        if StartX > -1 then
        begin
          Excl := CreateRectRGN(StartX, Y, Bmp.Width, Y + 1);
          try
            CombineRGN(Result, Result, Excl, RGN_DIFF);
          finally
            DeleteObject(Excl);
          end;
        end;
      end;
    end;
    
    procedure TForm1.FormCreate(Sender: TObject);
    var
      Bmp: TBitmap;
    begin
      Bmp := TBitmap.Create;
      try
        Bmp.LoadFromFile('C:\YourBitmap.bmp');
        FRegion := CreateRegion(Bmp);
        SetWindowRGN(Handle, FRegion, True);
      finally
        Bmp.Free;
      end;
    end;
    
    procedure TForm1.FormDestroy(Sender: TObject);
    begin
      DeleteObject(FRegion);
    end;
    
    end.
