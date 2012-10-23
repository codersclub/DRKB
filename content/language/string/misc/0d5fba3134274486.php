<h1>Генерация GUID как строки</h1>
<div class="date">01.01.2007</div>


<p>Как в Run-time сгененрировать строку типа</p>
'{821AB2C7-559D-48E0-A3EE-6DD50E83234C}'</p>
<p>Типа как в среде при нажатии Ctrl-Shift-G. Функция CoCreateGuid выводит значение типа TGUID, я нигде не нашёл функции конвертации TGUID -&gt; String. Может кто знает такую функцию?</p>
<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<p>Есть такая функция. Как ни странно называется она GUIDToString, и живет в SysUtils.</p>
<div class="author">Автор: Fantasist</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr /><p>Можно GUIDToString написать и вручную, будет выглядеть примерно так:</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  G: TGUID;
  S: string;
  i: Integer;
begin
  CoCreateGuid(G);
  S := '{' + IntToHex(G.D1, 8) + '-' + IntToHex(G.D2, 4) + '-' + IntToHex(G.D3, 4) + '-';
  for i := 0 to 7 do
    begin
      S := S + IntToHex(G.D4[i], 2);
      if i = 1 then S := S + '-'
    end;
  S := S + '}';
  ShowMessage(GUIDToString(G) + #13 + S)
end;
</pre>

<div class="author">Автор: Jin X</div>
