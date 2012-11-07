<h1>Изменить шрифт TStatusBar</h1>
<div class="date">01.01.2007</div>


<pre>
{ 
  To use this example, you need a TStatusBar and at least one Panel. 
  Then change the style of StatusBar1.Panels[0] to 
  psOwnerDraw and add the code below to the OnDrawPanel handler. 
}
 
 procedure TForm1.StatusBar1DrawPanel(StatusBar: TStatusBar;
   Panel: TStatusPanel; const Rect: TRect);
 var
   SomeText: string;
 begin
   if Panel = StatusBar1.Panels[0] then
   begin
     SomeText    := 'Hello!';
     Panel.Width := Trunc(StatusBar1.Canvas.TextWidth(SomeText) * 1.5);
     with StatusBar.Canvas do
      begin
       Brush.Color := clWhite;
       FillRect(Rect);
       Font.Name  := 'Arial';
       Font.Color := clRed;
       Font.Style := Font.Style + [fsItalic, fsBold];
       TextRect(Rect, Rect.Left + 1, Rect.Top, SomeText);
     end;
   end;
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
</p>
