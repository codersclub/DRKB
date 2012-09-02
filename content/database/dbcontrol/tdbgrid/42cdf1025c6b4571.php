<h1>Как выделить цветом текущую строку в TDBGrid?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.DBGrid1DrawDataCell(Sender: TObject; const Rect:
 TRect;
   Field: TField; State: TGridDrawState);
 begin
   if gdFocused in State then
   with (Sender as TDBGrid).Canvas do
   begin
     Brush.Color := clRed;
     FillRect(Rect);
     TextOut(Rect.Left, Rect.Top, Field.AsString);
   end;
 end;
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
