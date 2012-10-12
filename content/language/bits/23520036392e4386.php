<h1>Установка бита в ноль</h1>
<div class="date">01.01.2007</div>


<p>Установка бита в ноль</p>
<pre>
function BitOff(const val: longint; const TheBit: byte): LongInt;

begin
  Result := val and ((1 shl TheBit) xor $FFFFFFFF);
end;
</pre>

<p class="author">Автор: s-mike </p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<hr />
<pre>
function BitOff(const val: longint; const TheBit: byte): LongInt; 

begin
  Result := val and not (1 shl TheBit); 
end; 
</pre>

<p class="author">Автор: Yanis</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

<hr />
<pre>
procedure ClearBit(SetWord, BitNum: Word);
begin
  SetWord := SetWord or BitNum; { Устанавливаем бит }
  SetWord := SetWord xor BitNum; { Переключаем бит   }
end;
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>

