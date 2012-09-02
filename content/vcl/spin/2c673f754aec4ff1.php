<h1>Как очистить все окошки редактирования на форме?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure ClearEdits;
 var i : Integer;
begin
for i := 0 to ComponentCount-1 do
  if (Components[i] is TEdit) then
    (Components[i] as TEdit).Text := '';
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

