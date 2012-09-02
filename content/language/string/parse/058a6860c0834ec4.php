<h1>Функция для разворачивания строк</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Функция для "разворачивания" строк
 
 
Входные параметры:
Input - входная строка, которую необходимо представить в "развернутом виде"
 
на входе: 1,3,5-10,15
на выходе: 1,3,5,6,7,8,9,10,15 
 
 
Зависимости: стандартный набор включаемых модулей
Автор:       Ru, DiVo_Ru@rambler.ru, Одесса
Copyright:   DiVo 2002, creator Ru
Дата:        12 ноября 2002 г.
***************************************************** }
 
function DecStr(Input: string): string;
var
  i, j, t: integer;
  s: string;
begin
  if pos('-', Input) &lt;&gt; 0 then
  begin
    while length(Input) &lt;&gt; 0 do
    begin
      if Input[1] = ',' then
      begin
        i := strtoint(s);
        delete(Input, 1, 1);
        result := result + s + ',';
        s := '';
      end
      else
      begin
        if Input[1] = '-' then
        begin
          i := strtoint(s);
          delete(Input, 1, 1);
          t := pos(',', Input);
          result := result + s + ',';
          s := '';
          if t = 0 then
          begin
            j := strtoint(Input);
            Input := '';
          end
          else
          begin
            j := strtoint(copy(Input, 1, t - 1));
            delete(Input, 1, t);
          end;
          inc(i);
          while i &lt; j + 1 do
          begin
            result := result + inttostr(i) + ',';
            inc(i);
          end;
        end
        else
        begin
          s := s + Input[1];
          delete(Input, 1, 1);
        end;
      end;
    end;
  end
  else
    result := Input;
  if s &lt;&gt; '' then
    result := result + s;
end;
 
 
</pre>

