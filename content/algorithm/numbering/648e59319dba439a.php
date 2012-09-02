<h1>Разбиение шестнадцатиричной величины</h1>
<div class="date">01.01.2007</div>


<pre>
Function LoNibble ( X : Byte ) : Byte;
Begin
  Result := X And $F;
End;
 
Function HiNibble ( X : Byte ) : Byte;
Begin
  Result := X Shr 4;
End;
</pre>

<p>Приведенные функции разделят ваше число на две половинки, нижнюю и верхнюю. Если вам необходимо отображать их с ведущим нулем, то используйте IntToHex подобным образом: </p>
<pre>
Label1.Caption := 'Верхняя часть - ' + IntToHex ( HiNibble ( $2E ), 2 );
Label2.Caption := 'Нижняя часть - ' + IntToHex ( LoNibble ( $2E ), 2 ); 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

