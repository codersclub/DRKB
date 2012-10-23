<h1>Пример чтения данных по битовой маске из значения</h1>
<div class="date">01.01.2007</div>


<p>Пример чтения данных по битовой маске из значения:</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);

const
  Col: Word = $ABCD;
var
  R,
  G,
  B: Byte;
begin
  R := Byte(Col shr 8) div 8; // первые 5 бит
  G := ((Byte(Col shr 8) and $7) * 8) or (Byte(Col) div $20); // Вторые 6 бит
  B := Byte(Col) and $1F; // третьи 5 бит
end;
</pre>

<div class="author">Автор: Rouse_ </div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
