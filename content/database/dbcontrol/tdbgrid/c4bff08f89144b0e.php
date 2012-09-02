<h1>Как узнать значения, которые пользователь вводит в TDBGrid?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.DBGrid1KeyUp(Sender: TObject; 
                              var Key: Word; Shift: TShiftState); 
var 
  B: byte; 
 
begin 
  for B := 0 to DBGrid1.ControlCount - 1 do 
  if DBGrid1.Controls[B] is TInPlaceEdit then 
  begin 
    with DBGrid1.Controls[B] as TInPlaceEdit do 
    begin 
      Label1.Caption := 'Text = ' + Text; 
    end; 
  end; 
end; 
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

