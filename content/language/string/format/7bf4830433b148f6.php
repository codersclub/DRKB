<h1>Дополнение строки пробелами</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Дополнение строки пробелами слева
 
Дополненяет строку слева пробелами до указанной длины
 
Зависимости: нет
Автор:       Anatoly Podgoretsky, anatoly@podgoretsky.com, Johvi
Copyright:
Дата:        26 апреля 2002 г.
***************************************************** }
 
function PADL(Src: string; Lg: Integer): string;
begin
  Result := Src;
  while Length(Result) &lt; Lg do
    Result := ' ' + Result;
end;
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Дополнение строки пробелами справа
 
Дополняет строку пробелами справа до указанной длины.
 
Зависимости: нет
Автор:       Anatoly Podgoretsky, anatoly@podgoretsky.com, Johvi
Copyright:   Anatoly Podgoretsky
Дата:        26 апреля 2002 г.
***************************************************** }
 
function PADR(Src: string; Lg: Integer): string;
begin
  Result := Src;
  while Length(Result) &lt; Lg do
    Result := Result + ' ';
end;
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Дополнение строки пробелами с обоих сторон
 
Дополнение строки пробелами с обоих сторон до указанной длины
 
Зависимости: нет
Автор:       Anatoly Podgoretsky, anatoly@podgoretsky.com, Johvi
Copyright:
Дата:        26 апреля 2002 г.
***************************************************** }
 
function PADC(Src: string; Lg: Integer): string;
begin
  Result := Src;
  while Length(Result) &lt; Lg do
  begin
    Result := Result + ' ';
    if Length(Result) &lt; Lg then
    begin
      Result := ' ' + Result;
    end;
  end;
end;
 
//Пример использования: 
 
S := PADL(S,32); 
 
</pre>

