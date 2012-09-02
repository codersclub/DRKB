<h1>Создать неактивные пиктограммы для TSpeedButton и TBitBtn во время выполнения</h1>
<div class="date">01.01.2007</div>


<pre>
procedure AddDisableBMP(SB : array of TObject);
 var
    BM, SBM : TBitmap;
   w, x, y, NewColor, i : integer;
   PixelColor : TColor;
 begin
   BM := TBitmap.Create;
   SBM := TBitmap.Create;
   try
     for i := 0 to High(SB) do
      begin
       if (SB[i] is TSpeedButton) then
         BM.Assign((SB[i] as TSpeedButton).Glyph)
       else if (SB[i] is TBitBtn) then
         BM.Assign((SB[i] as TBitBtn).Glyph)
       else
          Exit;
 
       if not Assigned(BM) or (BM.Width &lt;&gt; BM.Height) then Exit;
 
       w := BM.Width;
       SBM.Width := w * 2;
       SBM.Height := w;
       SBM.Canvas.Draw(0, 0, BM);
 
       for x := 0 to w - 1 do
         for y := 0 to w - 1 do
          begin
           PixelColor := ColorToRGB(BM.Canvas.Pixels[x, y]);
           NewColor := Round((((PixelColor shr 16) + ((PixelColor shr 8) and $00FF) +
             (PixelColor and $0000FF)) div 3)) div 2 + 96;
           BM.Canvas.Pixels[x, y] := RGB(NewColor, NewColor, NewColor);
         end;
 
 
       SBM.Canvas.Draw(w, 0, BM);
 
       if (SB[i] is TSpeedButton) then with (SB[i] as TSpeedButton) do
          begin
           Glyph.Assign(SBM);
           NumGlyphs := 2;
         end
       else
          with (SB[i] as TBitBtn) do
          begin
           Glyph.Assign(SBM);
           NumGlyphs := 2;
         end;
       BM := TBitmap.Create;
       SBM := TBitmap.Create;
     end;
   finally
     BM.Free;
     SBM.Free;
   end;
 end;
</pre>

<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
