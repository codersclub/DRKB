---
Title: Стеганография (вшивание информации в рисунки)
Date: 01.01.2007
---


Стеганография (вшивание информации в рисунки)
=============================================

::: {.date}
01.01.2007
:::

    // Do the actual encryption of the message inside the picture. 
    procedure TForm1.btnEncryptClick(Sender: TObject);
     var
       x, y, i, j: Integer;
       PixelData: TColor;
       CharMask, CharData: Byte;
     begin
       // Assign the original picture to both the target encrypted image 
      // and delta image. Also make sure thier resolution is sufficient to 
      // indicate the change in the LSB. 
      imgTarget.Picture.Assign(imgOrig.Picture);
       imgDelta.Picture.Assign(imgOrig.Picture);
       imgTarget.Picture.Bitmap.PixelFormat := pf32bit;
       imgDelta.Picture.Bitmap.PixelFormat := pf32bit;
       x := 0;
       y := 0;
       // The letter 'c' is identified by the binary representation of '10000011' 
      // for each '1' in this number change the current pixel's LSB value. 
      with imgTarget.Picture.Bitmap do
         for i := 1 to Length(sourceMessage.Text) do
         begin
           CharMask := $80;
           // 8 bytes for every letter to be encrypted. 
          for j := 1 to 8 do
           begin
             // See if the current byte in the character is either '1' or '0'. 
            CharData := Byte(sourceMessage.Text[i]) and CharMask;
             //Data is not zero - change the LSB of the current pixel. 
            if (CharData <> 0) then
             begin
               // Xor the LSB value - hence change its value. 
              PixelData := Canvas.Pixels[x, y] xor $1;
               // Store the changed pixel color back in the Pixels array. 
              Canvas.Pixels[x, y] := PixelData;
             end;
     
             // Move to the next pixel. 
            x := (x + 1) mod Width;
             if (x = 0) then
             begin
               Inc(y);
             end;
             // Move the mask to be applied to the current character to the 
            // right, hence will now examine the next bit in the binary 
            // representation of the current letter to be encrypted. 
            CharMask := CharMask shr 1;
           end;
         end;
       // Show the difference in the Delta image. 
      for y := 0 to imgOrig.Picture.Bitmap.Height -1 do
         for x := 0 to imgOrig.Picture.Bitmap.Width -1 do
           // Check for difference, the difference will show in the LSB of every 
          // pixel in the original and target images. 
          if (imgOrig.Picture.Bitmap.Canvas.Pixels[x, y] <>
             imgTarget.Picture.Bitmap.Canvas.Pixels[x, y]) then
             imgDelta.Picture.Bitmap.Canvas.Pixels[x, y] := clYellow;
     end;
     
     
     // Decryption ( by Lemy ) 
    procedure TForm1.btnDecryptClick(Sender: TObject);
     Var
       x, y: integer;
       mask, ch: byte;
     begin
       sourceMessage.Clear;
       mask := $80;
       ch := 0;
       for y := 0 to imgOrig.Picture.Bitmap.Height -1 do
       begin
         for x := 0 to imgOrig.Picture.Bitmap.Width -1 do
         begin
           // if the pixel is different then set related bit 
          if (imgOrig.Picture.Bitmap.Canvas.Pixels[x, y] <>
           imgTarget.Picture.Bitmap.Canvas.Pixels[x, y]) then
             ch := ch or mask;
           // shift the bit to the rigtht 
          mask := mask shr 1;
           // if the mask is 0 then the dexryption of a char is completed 
          // so add to the Text and rest the highest bit 
          if mask = 0 Then
           begin
             sourceMessage.Text := sourceMessage.Text + char(ch);
             mask := $80;
             ch := 0;
           end;
         end;
       end;
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>
