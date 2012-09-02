<h1>Функция проверки корректности ввода</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Функция проверки корректности ввода
 
Результат истина в случае если во входной строке нет недопустимых
символов
Rej - флаг режима
если Rej:=true, то Conf - строка недопустимых символов
если Rej:=false, то Conf - строка допустимых символов
Input - входная строка
 
Зависимости: Стандартные модули
Автор:       Ru, DiVo_Ru@rambler.ru, Одесса
Copyright:   DiVo 2002, creator Ru
Дата:        28 декабря 2002 г.
***************************************************** }
 
function ConformStr(Input, Conf: string; Rej: boolean): boolean;
var
  i: integer;
begin
  result := true;
  if Rej then
  begin
    for i := 1 to length(Conf) do
    begin
      if pos(Conf[i], Input) &lt;&gt; 0 then
      begin
        result := false;
        break;
      end
    end;
  end
  else
  begin
    for i := 1 to length(Input) do
    begin
      if pos(Input[i], Conf) = 0 then
      begin
        result := false;
        break;
      end;
    end;
  end;
end;
Пример использования: 
 
s := 'Приве6т!';
if not ConformStr(s, '0123456789') then
  s := Strtst(s, '0123456789');
//после этого s='Привет!'
</pre>

