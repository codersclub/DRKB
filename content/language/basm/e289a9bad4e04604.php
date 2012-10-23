<h1>Программирование ассемблером в Delphi</h1>
<div class="date">01.01.2007</div>

Автор: Александр Баранецкий</p>
<p>Каждый день множество программистов (кроме опытных) в Delphi, используя код высокого уровня, пишут свои программы. Как правило, пренебрегая таким понятием как Assembler, имеется ввиду в строенный в DELPHI. Конечно, тяжело сказать, что на голом &#171;асе&#187; можно сотворить великолепный шедевр имеется ввиду красота - VCL (Visual Component Library). Особенно относительно начинающих программистов, которые только начинают учить IDE. Но зато можно повысить скорость какого нибудь математического или системного алгоритма.</p>
<p>Сегодня я представляю на ваш суд статью по &#171;асу&#187;. Скорее всего, она будет интересна начинающим программерам. Я не мастер, но сеже.</p>
<p>Программирование АССЕМБЛЕРОМ в &#8220;Delphi&#8221;</p>
<p>Для начала несколько основных команд.</p>
<p>MOV - предназначена для занесения в ячейку памяти значения. Например:</p>
<pre>
var
  x: integer;
begin
  Mov X, 10 // Занесение в Х значение 10 // X:=10;
  Mov eax, 45 //Занесение в быстрый регистр
  Mov ebx, eax //Присвоения значения одного регистра другому
  Mov x.edx //Занесение в х значения edx
</pre>
<p>Первый параметр присваивающий объект, второй присеваемое значение.</p>
<p>ADD - Предназначена для прибавления к объекту значения. Значения передаются через запитаю. Например :</p>
<pre>
add eax,2
add x,76 
</pre>

<p>Первый параметр принимающий объект, второй добавляемое значение.</p>
<p>SUB - Предназначена для вычитания от объекта значения. Значения передаются через запитаю. Например :</p>
<pre>
sub eax,18
Sub x,6 
</pre>

<p>Первый параметр объект от которого отнимается , второй отнимаемое значение.</p>
<p>IMUL - команда умножения</p>
<p>IDIV - команда деления</p>
<p>CMP - Команда проверки</p>
<p>JNZ,JMP,JA - команды перехода.</p>
<p>Теперь перейдем к практическим примерам:</p>
<pre>
// 1 Функция сложения.
 
function plus(x, y: integer): integer;
asm
  mov eax,x
  add eax,y
end;
 
{
Функция вернет сумму «x» и «y». Сперва заносим «х» (move eax,x) потом
прибавляем к уже имеющемуся «y» (add eax,y).
}
// 2. Функция умножения
 
function Umnojenie(x, z: integer): integer;
asm
  mov ebx,z
  mov eax,x
  imul ebx
end;
 
{
Заносим в обратном порядке «x» и «z» Отдаем команду на
умножение первого значения на второе «imul ebx ».
}
 
// 3. Функция вычитания
 
function Minus(x, y: integer): integer;
asm
  sub x,y
end;
 
// Просто отнимаем одно от другого
 
// 4 Функция деления
 
function divider(x, y: integer): integer;
asm
  mov ebx,y {1}
  cdq {2}
  idiv ebx {3}
end;
</pre>

<p>Эта функция отличается от остальных методом применения операторов. Занесение значения. 2. Предварительная обработка. 3. Деление.</p>
<p>Это были простейшие математические операторы, теперь мы рассмотрим более сложные операторы цикла и условие</p>
<p>Цикл на &#171;асе&#187; заключается в том что создается контрольный объект и при достижении определенного условия не происходи перехода к начальной контрольной точке отчета цикла.</p>
<pre>
procedure asm_cycle;
label
  lb;
var
  d: integer;
begin
  asm
    mov ebx,0
    mov d,0
    lb:
    add d,1
    inc ebx
    cmp ebx,10
    jnz lb
    mov ebx,0
  end;
  Writeln(d);
end;
</pre>

<p>Метка lb нужна, чтобы назначить контрольную точку начала операторов цикла. Переменная &#171;d:integer&#187; для проверки результатов работы цикла. С зарезервированного слова ASM начинаем анализ. Mov edx,0 &#171;edx&#187; выступает как контрольный регистр в нем фиксируется количество повторений. А с самого начало он указывает с какой величины пойдет отчет Например mov edx,0 = for i := 0 to .. do, mov edx,43 = for i:=43 to ..do Мы установим его в 0 чтобы отчет шел с нуля. Переменную d мы тоже обнулим. Третья строка это метка начала после нее идут операторы цикла. Следующий оператор наш рабочий оператор. У нас он 1 но может быть множество. Inc edx добавляем в регистр 1 шаг пройденного цикла если пропустить то цикл будет идти вечно. cmp ebx,10 Один из основных операторов он проверяет не достиг ли цикл верхний предел. Проверка идет в самом конце. Если вернет FALSE то срабатывает следующий оператор перехода на метку т.е в начало цикла и все повторяется до тех пор пока cmp не вернет TRUE в следствии чего не сработает оператор перехода JNZ. Последними операторами обнуляем счетчик и показываем результат.</p>
<p>Условный оператор IF..THEN..ELSE.</p>
<pre>
procedure if_sample(x: integer);
var
  res: integer;
label
  exit, lb;
begin
  asm
    cmp x,0
    jnz lb
    mov res,45
    jmp exit
    lb:mov res,0
    exit: mov eax,0
  end;
  Writeln(res);
end;
</pre>

<p>На PASCAL этот оператор пишется так if x = 0 then x:=45 else x:=0; Сначала идет проверка не равен ли х нулю если не равен то переход на метку ld, На которой оператор обнуления. А если равен, то оператор перехода на ld не срабатывает. Срабатывает mov res,45. После которого состоится переход на метку EXIT. В &#171;асе&#187; желательно прописывать свою метку (у нас EXIT), которая по необходимости выйдет и процедуры.</p>
<p>И последние. Вызов внешней процедуры. Допустим, надо вызвать внешнюю процедуру.</p>
<p>procedure call_s(x, d: integer; bol: boolean);</p>
<p>Для вызова внешних модулей применяется метод CALL.</p>
<pre>
procedure call_sample;
asm
  mov eax,4
  mov edx,34
  mov cl,0
  call call_s
end;
</pre>

<p>Сперва передаются параметры последовательно а потом сам вызов.</p>
<p>На этом мой маленький туториал окончен. Все примеры вы найдете в приложенном файле pr_asm. Это маленькое консольное приложение, в котором представлены все примеры с комментариями.</p>
<p>P.S. Я не мастер в &#171;асе&#187;, и эта статья не сделает вас гениями она лишь призвана показать некоторые стандартные методы &#171;паса&#187; интерпретированные в &#171;ас&#187;. Мастера &#171;аса&#187; не смейтесь надо мной сильно, так как я уже сказал, что я не мастер, я просто энтузиаст в &#171;асе&#187;.</p>
<p>В следующей статье я продолжу описание более продвинутых операторов и методов а также попробуем написать маленькое &#171;ас&#187; приложение.</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
