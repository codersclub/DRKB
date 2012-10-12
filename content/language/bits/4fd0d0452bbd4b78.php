<h1>Переключение состояния бита с единицы на ноль и наоборот</h1>
<div class="date">01.01.2007</div>


<p>Переключение состояния бита с единицы на ноль и наоборот</p>
<pre>
function BitToggle(const val: longint; const TheBit: byte): LongInt;

begin
  Result := val xor (1 shl TheeBit);
end;
</pre>

<p class="author">Автор: s-mike </p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<hr />
<pre>
procedure ToggleBit(SetWord, BitNum: Word);
begin
  SetWord := SetWord xor BitNum; { Переключаем бит   }
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
