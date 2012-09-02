<h1>Как получить строковое значение перечисляемого типа?</h1>
<div class="date">01.01.2007</div>



<pre>
procedure GetEnumNameList(Pti: PTypeInfo; AList: 
                               TStrings; X: Integer);
{(**********************************************************
 Will return in AList string version of an 
enumerated type less the first X characters .
 eg X = 4
 and
          type
            eXORBuySell = (
              XOR_BUY,
              XOR_SELL
            );
 
 GetEnumNameList(TypeInfo(eXORBuySell), ComboBox1.Items, 4);
 
 Now  ComboBox1.Items[0] = 'BUY'
 and  ComboBox1.Items[1] = 'SELL'
************************************************************)}
var
  I: Integer;
begin
  AList.Clear;
  with GetTypeData(pti)^ do
  for I := MinValue to MaxValue do
    AList.Add(Copy(GetEnumName(pti, I), X + 1, 255));
end;
</pre>




<p>Взято с сайта <a href="https://www.torry.net" target="_blank">https://www.torry.net</a></p>
