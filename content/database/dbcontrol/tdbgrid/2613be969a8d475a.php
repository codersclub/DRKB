<h1>Как отобразить выбранную строку TDBGrid различными цветами?</h1>
<div class="date">01.01.2007</div>


<p>Если Вы хотите раскрасить выбранную строку DBGrid, но не хотите использовать опцию dgRowSelect, так как хотели бы редактировать данные, то можно воспользоваться следующей технологией в событии DBGrid.OnDrawColumnCell:</p>

<pre>
type 
  TCustomDBGridCracker = class(TCustomDBGrid); 
 
procedure TForm1.DBGrid1DrawColumnCell(Sender: TObject; 
  const Rect: TRect; DataCol: Integer; Column: TColumn; 
  State: TGridDrawState); 
begin 
  with Cracker(Sender) do 
    if DataLink.ActiveRecord = Row - 1 then 
      Canvas.Brush.Color := clRed 
    else 
      Canvas.Brush.Color := clWhite; 
  DefaultDrawColumnCell(Rect, DataCol, Column, State); 
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

