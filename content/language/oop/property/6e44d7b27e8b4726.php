<h1>Как скрыть свойства объекта?</h1>
<div class="date">01.01.2007</div>


<p>В иерархии VCL в большинстве случаев существует уровень объектов-"предшественников" (TCustomXXXX), в которых многие свойства скрыты. Для унаследованных от таких "предшественников" объектов можно "открывать" на выбор те или иные свойства. А как можно скрыть свойства, которые объявлены в published-области от Object Inspector'а, но при этом оставить возможность доступа во время работы программы? Решение состоит в объявлении свойства "по новой" в public-области. В примере скрытым будет у объекта TMyControl свойство Height. </p>

<pre>
TMyControl = class(TWinControl)
protected
  procedure SetHeight(Value: Integer);
  function GetHeight: Integer;
public
  property Height: Integer read GetHeight write SetHeight;
end;
 
procedure TMyControl.SetHeight(Value: Integer);
begin
  inherited Height := Value;
end;
 
function TMyControl.GetHeight;
begin
  Result := inherited Height;
end;
</pre>

