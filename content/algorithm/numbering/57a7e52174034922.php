<h1>Преобразование числа в двоичную запись</h1>
<div class="date">01.01.2007</div>

<p>Для преобразования числа в двоичную запись удобно использовать функции shl и and. Эта функция преобразует число в строку из единиц и нулей. Количество цифр определяется параметром Digits. </p>
<pre>
function IntToBin(Value: integer; Digits: integer): string;
var
  i: integer;
begin
  result := '';
  for i := 0 to Digits - 1 do
    if Value and (1 shl i) &gt; 0 then
      result := '1' + result
    else
      result := '0' + result;
end;
</pre>
<p>Вот пример использования этой функции: </p>
<pre>
procedure TForm1.Edit1Change(Sender: TObject);
begin
  Form1.Caption := IntToBin(StrToIntDef(Edit1.Text, 0), 128);
end;
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
