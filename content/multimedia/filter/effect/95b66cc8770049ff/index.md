---
Title: Подсветить изображение
Date: 01.01.2007
---


Подсветить изображение
======================

::: {.date}
01.01.2007
:::

    { 
    Question: 
      Does anyone know of a way that I can achieve the same effect on a bitmap 
      that windows achieves when you single click on an icon on the desktop?  In 
      other words, I want to "sorta highlight" a bitmap and let the user know that 
      it's selected. 
     
    Answer: 
     
      To me it appears as if the icons on my desktop are highlighted by overlaying 
      them with a certain color, so I guess the following routine is of use. 
    }
     
     
     procedure Highlight(aSource, ATarget: TBitmap; AColor: TColor);
     //alters ASource to ATarget by making it appear as if 
    //looked through 
    //colored glass as given by AColor 
    //ASource, ATarget must have been created. 
    //Isn't as slow as it looks. 
    //Physics courtesy of a post by K.H. Brenner 
    var i, j: Integer;
       s, t: pRGBTriple;
       r, g, b: byte;
       cl: TColor;
     begin
       cl := ColorToRGB(AColor);
       r := GetRValue(cl);
       g := GetGValue(cl);
       b := GetBValue(cl);
       aSource.PixelFormat := pf24bit;
       ATarget.PixelFormat := pf24bit;
       ATarget.Width := aSource.Width;
       ATarget.Height := aSource.Height;
       for i := 0 to aSource.Height - 1 do
       begin
         s := ASource.Scanline[i];
         t := ATarget.Scanline[i];
         for j := 0 to aSource.Width - 1 do
         begin
           t^.rgbtBlue := (b * s^.rgbtBlue) div 255;
           t^.rgbtGreen := (g * s^.rgbtGreen) div 255;
           t^.rgbtRed := (r * s^.rgbtRed) div 255;
           inc(s);
           inc(t);
         end;
       end;
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>
