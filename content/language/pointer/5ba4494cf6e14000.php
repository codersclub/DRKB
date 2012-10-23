<h1>Динамическое распределение памяти</h1>
<div class="date">01.01.2007</div>


<pre>
uses WinCRT;
 
procedure TForm1.Button1Click(Sender: TObject);
var
  MyArray: array[0..30] of char;
  b: ^char;
  i: integer;
begin
  StrCopy(MyArray, 'Delphi World - это круто!!!');
  b := @MyArray;
  for i := StrLen(MyArray) downto 0 do
  begin
    write(b^);
    inc(b, sizeof(char));
  end;
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
<hr />
<p>Как мне уменьшить количество занимаемой мной памяти в сегменте данных? (или как мне распределять память динамически?)</p>
<p>Скажем, ваша структура данных выглядит похожей на эту:</p>
<pre>
type
  TMyStructure = record
    Name: String[40];
    Data: array[0..4095] of Integer;
end;
</pre>
<p>Она слишком большая для глобального распределения, так что вместо объявления глобальной переменной,</p>
<p>var</p>
<p>  MyData: TMyStructure;</p>
<p>объявляете указательный тип,</p>
<p>type</p>
<p>  PMyStructure = ^TMyStructure;</p>
<p>и переменную этого типа,</p>
<p>var</p>
<p>  MyDataPtr: PMyStructure;</p>
<p>Такой указатель занимает всего лишь четыре байта сегмента данных.</p>
<p>Прежде, чем вы сможете использовать структуру данных, вы должны распределить ее в куче:</p>
<p>New(MyDataPtr);</p>
<p>и получить к ней доступ через глобальные данные любым удобным для вас способом. Единственное отличие от традиционного способа заключается в необходимости использования символа "^" для обозначения указателя на данные:</p>
<pre>
MyDataPtr^.Name := 'Советы по Delphi';
MyDataPtr^.Data[0] := 12345;
</pre>
<p>И, наконец, после использования памяти, освободите ее:</p>
<p>Dispose(MyDataPtr);</p>
<p class="note">Примечание от Vit: статья актуальна в основном для 16 разрядных систем</p>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>
