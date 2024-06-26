---
Title: Сделать картинке 2D свертку
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Сделать картинке 2D свертку
===========================

    {
     This function performs a 2D convolution on an image. 
     It can be used for a very wide range of image processing operations 
     such as image smoothing, anti-aliasing, edge detection, 
     detail enhancment, etc. It is very fast. 
    }
     
    uses
      Graphics, Windows;
    
    type
      TRGBTripleArray = array[0..10000] of TRGBTriple;
      PRGBTripleArray = ^TRGBTripleArray;
    
      T3x3FloatArray = array[0..2] of array[0..2] of Extended;
    
    implementation
    
    function Convolve(ABitmap: TBitmap; AMask: T3x3FloatArray;
      ABias: Integer): TBitmap;
    var
      LRow1, LRow2, LRow3, LRowOut: PRGBTripleArray;
      LRow, LCol: integer;
      LNewBlue, LNewGreen, LNewRed: Extended;
      LCoef: Extended;
    begin
      LCoef := 0;
      for LRow := 0 to 2 do
        for LCol := 0 to 2 do
          LCoef := LCoef + AMask[LCol, LRow];
      if LCoef = 0 then LCoef := 1;
    
      Result := TBitmap.Create;
    
      Result.Width := ABitmap.Width - 2;
      Result.Height := ABitmap.Height - 2;
      Result.PixelFormat := pf24bit;
    
      LRow2 := ABitmap.ScanLine[0];
      LRow3 := ABitmap.ScanLine[1];
    
      for LRow := 1 to ABitmap.Height - 2 do
       begin
        LRow1 := LRow2;
        LRow2 := LRow3;
        LRow3 := ABitmap.ScanLine[LRow + 1];
    
        LRowOut := Result.ScanLine[LRow - 1];
    
        for LCol := 1 to ABitmap.Width - 2 do
         begin
          LNewBlue :=
            (LRow1[LCol - 1].rgbtBlue * AMask[0,0]) + (LRow1[LCol].rgbtBlue * AMask[1,0]) +
            (LRow1[LCol + 1].rgbtBlue * AMask[2,0]) +
            (LRow2[LCol - 1].rgbtBlue * AMask[0,1]) + (LRow2[LCol].rgbtBlue * AMask[1,1]) +
            (LRow2[LCol + 1].rgbtBlue * AMask[2,1]) +
            (LRow3[LCol - 1].rgbtBlue * AMask[0,2]) + (LRow3[LCol].rgbtBlue * AMask[1,2]) +
            (LRow3[LCol + 1].rgbtBlue * AMask[2,2]);
          LNewBlue := (LNewBlue / LCoef) + ABias;
          if LNewBlue > 255 then
            LNewBlue := 255;
          if LNewBlue < 0 then
            LNewBlue := 0;
    
          LNewGreen :=
            (LRow1[LCol - 1].rgbtGreen * AMask[0,0]) + (LRow1[LCol].rgbtGreen * AMask[1,0]) +
            (LRow1[LCol + 1].rgbtGreen * AMask[2,0]) +
            (LRow2[LCol - 1].rgbtGreen * AMask[0,1]) + (LRow2[LCol].rgbtGreen * AMask[1,1]) +
            (LRow2[LCol + 1].rgbtGreen * AMask[2,1]) +
            (LRow3[LCol - 1].rgbtGreen * AMask[0,2]) + (LRow3[LCol].rgbtGreen * AMask[1,2]) +
            (LRow3[LCol + 1].rgbtGreen * AMask[2,2]);
          LNewGreen := (LNewGreen / LCoef) + ABias;
          if LNewGreen > 255 then
            LNewGreen := 255;
          if LNewGreen < 0 then
            LNewGreen := 0;
    
          LNewRed :=
            (LRow1[LCol - 1].rgbtRed * AMask[0,0]) + (LRow1[LCol].rgbtRed * AMask[1,0])
            + (LRow1[LCol + 1].rgbtRed * AMask[2,0]) +
            (LRow2[LCol - 1].rgbtRed * AMask[0,1]) + (LRow2[LCol].rgbtRed * AMask[1,1])
            + (LRow2[LCol + 1].rgbtRed * AMask[2,1]) +
            (LRow3[LCol - 1].rgbtRed * AMask[0,2]) + (LRow3[LCol].rgbtRed * AMask[1,2])
            + (LRow3[LCol + 1].rgbtRed * AMask[2,2]);
          LNewRed := (LNewRed / LCoef) + ABias;
          if LNewRed > 255 then
            LNewRed := 255;
          if LNewRed < 0 then
            LNewRed := 0;
    
          LRowOut[LCol - 1].rgbtBlue  := trunc(LNewBlue);
          LRowOut[LCol - 1].rgbtGreen := trunc(LNewGreen);
          LRowOut[LCol - 1].rgbtRed   := trunc(LNewRed);
        end;
      end;
    end;
     
    // example use 
    // edge detection 
    procedure TForm1.Button1Click(Sender: TObject);
    var
      LMask: T3x3FloatArray;
    begin
      LMask[0,0] := -1;
      LMask[1,0] := -1;
      LMask[2,0] := -1;
      LMask[0,1] := -1;
      LMask[1,1] := 8;
      LMask[2,1] := -1;
      LMask[0,2] := -1;
      LMask[1,2] := -1;
      LMask[2,2] := -1;
      Image1.Picture.Bitmap := Convolve(Image1.Picture.Bitmap, LMask, 0);
    end;

