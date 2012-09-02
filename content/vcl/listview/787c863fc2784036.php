<h1>Цветные строки для TListView</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.ListView1CustomDrawItem(Sender: TCustomListView;
   Item: TListItem; State: TCustomDrawState; var DefaultDraw: Boolean);
 begin
   with ListView1.Canvas.Brush do
   begin
     case Item.Index of
       0: Color := clYellow;
       1: Color := clGreen;
       2: Color := clRed;
     end;
   end;
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
