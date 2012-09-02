<h1>Функция для удаления из строки лишних символов</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Функция для удаления из строки "лишних" символов.
 
Функция для удаления из строки "лишних" символов.
Входные параметры:
Input - входная строка, которую необходимо очистить от лишних символов
EArray - строка, содержащая набор разрешенных или запрещеных символов
в зависимости от Action
Action - указывает на то, что из себя представляет массив EArray.
 
Action может принимать следующие значения:
1 - массив EArray представляет собой строку разрешенных символов
2 - EArray - массив запрещенных символов.
 
Зависимости: делал в Д5, 6 под Win9x
Автор:       Ru, DiVo_Ru@rambler.ru, Одесса
Copyright:   DiVo 2002, creator Ru
Дата:        11 ноября 2002 г.
***************************************************** }
 
function strtst(var Input: string; EArray: string; Action: integer): string;
begin
  case Action of
    1:
      begin
        while length(Input) &lt;&gt; 0 do
        begin
          if pos(Input[1], EArray) = 0 then
            delete(Input, 1, 1)
          else
          begin
            result := result + Input[1];
            delete(Input, 1, 1);
          end;
        end;
      end;
    2:
      begin
        while length(Input) &lt;&gt; 0 do
        begin
          if pos(Input[1], EArray) &lt;&gt; 0 then
            delete(Input, 1, 1)
          else
          begin
            result := result + Input[1];
            delete(Input, 1, 1);
          end;
        end;
      end;
  else
    messagebox(0, 'Не корректный вызов функции.', '', mb_ok);
  end;
end;
Пример использования: 
 
// 1.
s := edit1.text;
s := strtst(s, '0123456789.', 1);
edit1.text := s;
 
// например на входе: 0.16+
// на выходе будет: 0.16
 
// 2.
s := edit1.text;
s := strtst(s, '/*-+,', 2);
edit1.text := s;
 
// на входе: 0.16+
// на выходе будет: 0.16
</pre>

