<h1>Быстрая функция для разбивки строки на части (слова) в один цикл</h1>
<div class="date">01.01.2007</div>


<pre>
type TDelim=set of Char;
        TArrayOfString=Array of String;
 
 
//*******************
//
// Разбивает строку с разделителями на части
// и возвращает массив частей
//
// fcToParts
//
 
function fcToParts(sString:String;tdDelim:TDelim):TArrayOfString
var iCounter,iBegin:Integer;
begin//fc
if length(sString)&gt;0 then
 begin
  include(tdDelim,#0);iBegin:=1; SetLength(Result,0);
  For iCounter:=1 to Length(sString)+1 do
   begin//for
    if (sString[iCounter] in tdDelim) then
     begin
      SetLength(Result,Length(Result)+1);
      Result[Length(Result)-1]:=Copy(sString,iBegin,iCounter-iBegin);
      iBegin:=iCounter+1;
     end;
  end;//for
 end;//if
end;//fc
</pre>
<p>Пример использования:</p>
<pre>
var
StrArr:TArrayOfString
 
StrArr:=fcToParts('строка1-строка2@строка3',['-','@']):
 
</pre>
<div class="author">Автор: ДЫМ</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

