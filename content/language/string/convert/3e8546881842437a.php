<h1>Как преобразовать значение любого типа в строку?</h1>
<div class="date">01.01.2007</div>

<p>Более подробно ищите в хелпе Delphi по словам "Variant" и "TVarData"...</p>
<pre>
 
function ToString(Value: Variant): String;
begin
  case TVarData(Value).VType of
    varSmallInt,
    varInteger   : Result := IntToStr(Value);
    varSingle,
    varDouble,
    varCurrency  : Result := FloatToStr(Value);
    varDate      : Result := FormatDateTime('dd/mm/yyyy', Value);
    varBoolean   : if Value then Result := 'T' else Result := 'F';
    varString    : Result := Value;
    else            Result := '';
  end;
end;
</pre>
<p>Использование:</p>
<pre>
ShowMessage(ToString(10.87));
ShowMessage(ToString(10));
</pre>
<p>или</p>
<pre>
var
  V1 : Double;
  V2 : Integer;
  V3 : TDateTime;
  V4 : Boolean;
 
begin
  ...
 
  ShowMessage(ToString(V1));  // Double a String
  ShowMessage(ToString(V2));  // Integer a String
  ShowMessage(ToString(V3));  // DateTime a String
  ShowMessage(ToString(V4));  // Boolean a String
end;
 
</pre>
<p>Так же можно пользоваться другими вариантами, например:</p>
<p>varCurrency  : Result := CurrToStrF(Value ,ffFixed,CurrencyDecimals);</p>
<p>и</p>
<p>varDate: Result := DateToStr(Value);</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
