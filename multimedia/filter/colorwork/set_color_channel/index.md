---
Title: Изменить цветовые каналы битового изображения
Date: 07.09.2002
Source: <https://www.swissdelphicenter.ch>
---


Изменить цветовые каналы битового изображения
=============================================

    {+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
     Mit dem folgenden Code kann die Werte der einzelnen Farbkanale 
     (Rot, Grun, Blau) verandern. 
     So lassen sich leicht fantastische Effekte erzielen. 
     
     Parameter: 
       - Bitmap: TBitmap 
          Erwartet ein TBitmap auf dem die Anderungen 
          vollzogen werden sollen. 
     
       - Red: Integer 
          Erwartet einen Integer der den neuen Farbwert bestimmt. 
          Der Wert wird zu dem alten Farbwert addiert. 
          Betragt der Wert 0, wird keine Anderung am Farbkanal 
          vorgenommen. 
     
        - Green: Integer; 
           Erwartet einen Integer der den neuen Farbwert bestimmt. 
           Der Wert wird zu dem alten Farbwert addiert. 
           Betragt der Wert 0, wird keine Anderung am Farbkanal 
           vorgenommen. 
     
         - Blue: Integer; 
            Erwartet einen Integer der den neuen Farbwert bestimmt. 
            Der Wert wird zu dem alten Farbwert addiert. 
            Betragt der Wert 0, wird keine Anderung am Farbkanal 
            vorgenommen. 
     
    ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
     
     The following Code allows you to change the value of the 
     RGB-Colorchannels (Red, Green, Blue). 
     So you can simply create fantastic effects on your pictures. 
     
     Parameters: 
       - Bitmap: TBitmap 
          Needs a TBitmap with a picture to read the old values 
          and draw the changes. 
     
       - Red: Integer 
          A Integer which set the new value of the Color-channel. 
          The value will be add to the old value. 
          If the value is 0, there will be no change in the 
          Color-channel. 
     
        - Green: Integer; 
           A Integer which set the new value of the Color-channel. 
           The value will be add to the old value. 
           If the value is 0, there will be no change in the 
           Color-channel. 
     
         - Blue: integer; 
            A Integer which set the new value of the Color-channel. 
            The value will be add to the old value. 
            If the value is 0, there will be no change in the 
            Color-channel. 
     
     ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
     Saturday, 2002-09-07 
     ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
    }
     
     
    function SetRGBChannelValue(Bitmap: TBitmap; Red, Green, Blue: Integer): Boolean;
    var
       i, j: Integer;
      rgbc: array[0..2] of Byte;
      c: TColor;
      r, g, b: Byte;
    begin
      //Wenn keine Anderungen vorgenommen werden, Vorgang beenden: 
     //If there is no change, exit: 
     if (Red = 0) and (Green = 0) and (Blue = 0) then
       begin
        Result := False;
        Exit;
      end;
    
      for i := 0 to Bitmap.Height do
       begin
        for j := 0 to Bitmap.Width do
         begin
          // Get the old Color 
         c := Bitmap.Canvas.Pixels[j, i];
          // Splitt the old color into the different colors: 
         rgbc[0] := GetRValue(c);
          rgbc[1] := GetGValue(c);
          rgbc[2] := GetBValue(c);
    
          //Check that there is no "new" color while the addition 
         //of the values: 
         if not (rgbc[0] + Red < 0) and not (rgbc[0] + Red > 255) then
            rgbc[0] := rgbc[0] + Red;
          if not (rgbc[1] + Green < 0) and not (rgbc[1] + Green > 255) then
            rgbc[1] := rgbc[1] + Green;
          if not (rgbc[2] + Blue < 0) and not (rgbc[2] + Blue > 255) then
            rgbc[2] := rgbc[2] + Blue;
    
          r := rgbc[0];
          g := rgbc[1];
          b := rgbc[2];
    
          //set the new color back to the picture: 
         Bitmap.Canvas.Pixels[j, i] := RGB(r, g, b);
        end;
      end;
    
      Result := True;
    end;
     
    //Beispiel, wie man die Funktion benutzen kann: 
    //Example, how to use it: 
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      SetColorValue(Image1.picture.Bitmap, Spinedit1.Value, Spinedit2.Value,
        Spinedit3.Value);
    end;

