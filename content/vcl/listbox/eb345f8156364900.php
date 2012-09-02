<h1>Как перетащить целую колонку из TStringGrid в TListBox?</h1>
<div class="date">01.01.2007</div>


<p>После того, как поместите TListBox на форму, необходимо изменить свойство Style в TListBox на lbOwnerDrawFixed. Если не изменить свойство Style, то событие OnDrawItem никогда не вызовется. Теперь поместите следующий код в обработчик события OnDrawItem Вашего TListBox:</p>
<pre>
procedure TForm1.ListBox1DrawItem
  (Control: TWinControl; Index: Integer;
  Rect: TRect; State: TOwnerDrawState);
var
    myColor: TColor;
    myBrush: TBrush;      
begin
  myBrush := TBrush.Create;  
  with (Control as TListBox).Canvas do
  begin
    if not Odd(Index) then
      myColor := clSilver
    else
      myColor := clYellow;
 
    myBrush.Style := bsSolid; 
    myBrush.Color := myColor; 
    Windows.FillRect(handle, Rect, myBrush.Handle); 
    Brush.Style := bsClear;  
    TextOut(Rect.Left, Rect.Top, 
            (Control as TListBox).Items[Index]);  
    MyBrush.Free;
  end;
end;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

