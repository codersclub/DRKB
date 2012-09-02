<h1>Синтаксический анализ выражений</h1>
<div class="date">01.01.2007</div>


<p>2. Синтаксический анализ выражений</p>
     НАЧАЛО </p>
Если вы прочитали введение, то вы уже в курсе дела. Вы также скопировали программу Cradle в Turbo Pascal и откомпилировали ее. Итак, вы готовы. </p>
Целью этой главы является обучение синтаксическому анализу и трансляции математических выражений. В результате мы хотели бы видеть серию команд на ассемблере, выполняющую необходимые действия. Выражение &#8211; правая сторона уравнения, например: </p>
     x = 2*y + 3/(4*z)</p>
В самом начале я буду двигаться очень маленькими шагами для того, чтобы начинающие из вас совсем не заблудились. Вы также получите несколько хороших уроков, которые хорошо послужат нам позднее. Для более опытных читателей: потерпите. Скоро мы двинемся вперед. </p>
ОДИНОЧНЫЕ ЦИФРЫ </p>
В соответствии с общей темой этой серии (KISS-принцип, помнишь?), начнем с самого простого случая, который можно себе представить. Это выражение, состоящее из одной цифры. </p>
Перед тем как начать, удостоверьтесь, что у вас есть базовая копия Cradle. Мы будем использовать ее для других экспериментов. Затем добавьте следующие строки: </p>
<pre>
{ Parse and Translate a Math Expression } 
procedure Expression; 
begin 
   EmitLn('MOVE #' + GetNum + ',D0') 
end;
</pre>
&nbsp;</p>
И добавьте строку “Expression;” в основную программу, которая должна выглядеть так: </p>
<pre>
begin 
   Init; 
   Expression; 
end.
</pre>
Теперь запустите программу. Попробуйте ввести любую одиночную цифру. Вы получите  результат в виде одной строчки на ассемблере. Затем попробуйте ввести любой другой символ и вы увидите, что синтаксический анализатор правильно сообщает об ошибке. </p>
Поздравляю! Вы только что написали работающий транслятор! </p>
Конечно, я понимаю, что он очень ограничен. Но не отмахивайтесь от него. Этот маленький «компилятор» в ограниченных масштабах делает точно то же, что делает любой большой компилятор: он корректно распознает допустимые утверждения на входном «языке», который мы для него определили, и производит корректный, выполнимый ассемблерный код, пригодный для перевода в объектный формат. И, что важно, корректно распознает недопустимые утверждения, выдавая сообщение об ошибке. Кому требовалось больше? </p>
Имеются некоторые другие особенности этой маленькой программы, заслуживающие внимания. В первых, вы видите, что мы не отделяем генерацию кода от синтаксического анализа… как только анализатор узнает что нам нужно, он непосредственно генерирует объектный код. В настоящих компиляторах, конечно, чтение в GetChar должно происходить из файла и затем выполняться запись в другой файл, но этот способ намного проще пока мы экспериментируем. </p>
Также обратите внимание, что выражение должно где-то сохранить результат. Я выбрал регистр D0 процессора 68000. Я мог бы выбрать другой регистр, но в данном случае это имеет смысл. </p>
ВЫРАЖЕНИЯ С ДВУМЯ ЦИФРАМИ </p>
     Теперь, давайте немного улучшим то, что у нас есть. По общему признанию, выражение, состоящее только из одного символа, не удовлетворит наших потребностей надолго, так что давайте посмотрим, как мы можем расширить возможности компилятора. Предположим, что мы хотим обрабатывать выражения вида: </p>
1+2 </p>
или</p>
4-3</p>
или в общем  &lt;term&gt; +/- &lt;term&gt;  (это часть формы Бэкуса-Наура или БНФ.)</p>
Для того, чтобы сделать это, нам нужна процедура, распознающая термы и сохраняющая результат, и другая процедура, которая распознает и различает «+» и «-»  и генерирует соответствующий код. Но если процедура Expression  сохраняет свои результаты в регистре D0, то где процедура Term сохранит свои результаты? Ответ:  на том же месте. Мы окажемся перед необходимостью сохранять первый результат процедуры Term где-нибудь, прежде чем мы получим следующий.</p>
В основном, что нам необходимо сделать &#8211; создать процедуру Term, выполняющую то что раннее выполняла процедура Expression. Поэтому просто переименуйте процедуру Expression в Term и наберите новую версию Expression: </p>
<pre>
{ Parse and Translate an Expression } 
procedure Expression; 
begin 
   Term; 
   EmitLn('MOVE D0,D1'); 
   case Look of 
    '+': Add; 
    '-': Subtract; 
   else Expected('Addop'); 
   end; 
end; 
 
Затем выше Expression наберите следующие две процедуры: 
 
{ Recognize and Translate an Add } 
procedure Add; 
begin 
   Match('+'); 
   Term; 
   EmitLn('ADD D1,D0'); 
end; 
 
{ Recognize and Translate a Subtract } 
procedure Subtract; 
begin 
   Match('-'); 
   Term; 
   EmitLn('SUB D1,D0'); 
end;
</pre>
<p>     Когда вы закончите, порядок подпрограмм должен быть следующий: </p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>Term (старая версия Expression) </td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>Add </td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>Subtract </td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>Expression</td></tr></table>
Теперь запустите программу. Испробуйте любую комбинацию, которую вы только можете придумать, из двух одиночных цифр, разделенных  «+» или  «-». Вы должны получить ряд из четырех инструкций на ассемблере. Затем испытайте выражения с заведомыми ошибками в них. Перехватывает анализатор ошибки?</p>
Посмотрите на полученный объектный код. Можно сделать два замечания. Во-первых, сгенерированный код не такой, какой бы написали мы. Последовательность</p>
MOVE #n,D0</p>
MOVE D0,D1 </p>
неэффективна. Если бы мы писали этот код вручную, то, возможно, просто загрузили бы данные напрямую в D1.</p>
Вывод: код, генерируемый нашим синтаксическим анализатором, менее эффективный, чем код, написанный вручную. Привыкните к этому. Это в известной мере относится ко всем компиляторам. Ученые посвятили целые жизни вопросу оптимизации кода и существуют методы, призванные улучшить качество генерируемого кода. Некоторые компиляторы выполняют оптимизацию достаточно хорошо, но за это приходится платить сложностью и в любом случае это проигранная битва… возможно никогда не придет время, когда хороший программист на ассемблере не смог бы превзойти компилятор. Прежде чем закончится этот урок, я кратко упомяну некоторые способы, которые мы можем применить для небольшой оптимизации, просто, чтобы показать вам, что мы на самом деле сможем сделать некоторые улучшения без излишних проблем. Но запомните, мы здесь для того, чтобы учиться, а не для того, чтобы узнать насколько компактным мы можем сделать код. А сейчас и на протяжении всей этой серии мы старательно будем игнорировать оптимизацию и сконцентрируемся на получении работающего кода.</p>
Но наш код не работает! В коде есть ошибка! Команда вычитания вычитает D1 (первый аргумент) из D0 (второй аргумент). Но это неправильный способ, так как мы получаем неправильный знак результата. Поэтому исправим процедуру Subtract с помощью замены знака следующим образом:</p>
<pre>
{ Recognize and Translate a Subtract } 
procedure Subtract; 
begin 
   Match('-'); 
   Term; 
   EmitLn('SUB D1,D0'); 
   EmitLn('NEG D0'); 
end;
</pre>
Теперь наш код даже еще менее эффективен, но по крайней мере выдает правильный ответ! К сожалению, правила, которые определяют значение математических выражений, требуют, чтобы условия в выражении следовали в неудобном для нас порядке. Опять, это только один из фактов жизни, с которыми вы учитесь жить. Все это возвратится снова, чтобы преследовать нас, когда мы примемся за деление</p>
Итак, на данном этапе мы имеем синтаксический анализатор, который может распознавать сумму или разность двух цифр. Ранее мы могли распознавать только одиночные цифры. Но настоящие выражения могут иметь любую форму (или бесконечность других). Вернитесь и запустите программу с единственным входным символом  “1”.</p>
Не работает? А почему должен работать? Мы только указали анализатору, что единственным правильными видами выражений являются выражения с двумя термами. Мы должны переписать процедуру Expression так, чтобы она была намного более универсальной и с этого начать создание настоящего синтаксического анализатора. </p>
ОБЩАЯ ФОРМА ВЫРАЖЕНИЯ </p>
В реальном мире выражение может состоять из одного или более термов, разделенных "addops" ('+'  или  '-'). В БНФ это может быть записано как:</p>
&lt;expression&gt; ::= &lt;term&gt; [&lt;addop&gt; &lt;term&gt;]* </p>
Мы можем применить это определение выражения, добавив простой цикл к процедуре Expression: </p>
<pre>
{ Parse and Translate an Expression } 
procedure Expression; 
begin 
   Term; 
   while Look in ['+', '-'] do begin 
      EmitLn('MOVE D0,D1'); 
      case Look of 
       '+': Add; 
       '-': Subtract; 
      else Expected('Addop'); 
      end; 
   end; 
end;
</pre>
Эта версия поддерживает любое число термов, и это стоило нам только двух дополнительных строк кода. По мере изучения, вы обнаружите, что это характерно для нисходящих синтаксических анализаторов… необходимо только несколько дополнительных строк кода чтобы добавить расширения языка. Это как раз то, что делает наш пошаговый метод возможным. Заметьте также, как хорошо код процедуры Expression соответствует определению БНФ. Это также одна из характеристик метода. Когда вы станете специалистом этого метода, вы сможете превращать БНФ в код синтаксического анализатора примерно с такой же скоростью, с какой вы можете набирать текст на клавиатуре! </p>
ОК, откомпилируйте новую версию анализатора и испытайте его. Как обычно, проверьте что «компилятор» обрабатывает любое допустимое выражение и выдает осмысленное сообщение об ошибке для запрещенных. Четко, да? Вы можете заметить, что в нашей тестовой версии любое сообщение об ошибке выводится вместе с генерируемым кодом. Но запомните, это только потому, что мы используем экран как «выходной файл» в этих экспериментах. В рабочей версии вывод будет разделен… один в выходной файл, другой на экран. </p>
ИСПОЛЬЗОВАНИЕ СТЕКА </p>
В этом месте я собираюсь нарушить свое правило, что я не представлю что-либо сложное, пока это не будет абсолютно необходимо. Прошло достаточно много времени, чтобы не отметить проблему с генерируемым кодом. В настоящее время синтаксический анализатор использует D0 как «основной» регистр, и D1 для хранения частичной суммы. Эта схема работает отлично потому что мы имеем дело только с "addops" (“+” и “-”) и новое число прибавляется по мере появления. Но в общем форме  это не так. Рассмотрим, например выражение </p>
     1+(2-(3+(4-5))) </p>
Если мы поместим «1» в D1, то где мы разместим «2»? Так как выражение в общей форме может иметь любую степень сложности, то мы очень быстро используем все регистры!</p>
К счастью есть простое решение. Как и все современные микропроцессоры, 68000 имеет стек, который является отличным местом для хранения переменного числа элементов. Поэтому вместо того, чтобы помещать термы в D0 и D1 давайте затолкнем их в стек. Для тех кто незнаком с ассемблером 68000 &#8211; помещение в стек пишется как </p>
-(SP) </p>
и извлечение  (SP)+. </p>
Итак, изменим  EmitLn  в процедуре Expression на </p>
EmitLn('MOVE D0,-(SP)'); </p>
и  две строки в Add и Subtract: </p>
EmitLn('ADD (SP)+,D0')  </p>
и</p>
EmitLn('SUB (SP)+,D0') </p>
соответственно. Теперь испытаем компилятор снова и удостоверимся что он работает. </p>
И снова, полученный код менее эффективен, чем был до этого, но это необходимый шаг, как вы увидите. </p>
УМНОЖЕНИЕ И ДЕЛЕНИЕ </p>
Теперь давайте возьмемся за действительно серьезные дела. Как вы знаете, кроме операторов  "addops" существуют и другие… выражения могут также иметь операторы умножения и деления. Вы также знаете, что существует неявный приоритет операторов или иерархия, связанная с выражениями, чтобы в выражениях типа </p>
2 + 3 * 4, </p>
мы знали, что нужно сначала умножить, а затем сложить. (Видите, зачем нам нужен стек?)</p>
В ранние дни технологии компиляторов, люди использовали различные довольно сложные методы для того чтобы правила приоритета операторов соблюдались. Но, оказывается, все же, что ни один из них нам не нужен… эти правила могут быть очень хорошо применены в нашей технике нисходящего синтаксического анализа. До сих пор единственной формой, которую мы применяли для терма была форма одиночной десятичной цифры. В более общей форме мы можем определить терм как произведение показателей (product of factors), то есть </p>
&lt;term&gt; ::= &lt;factor&gt;  [ &lt;mulop&gt; &lt;factor ]* </p>
Что такое показатель? На данный момент это тоже, чем был раннее терм - одиночной цифрой.</p>
Обратите внимание: терм имеет ту же форму, что и выражение. Фактически, мы можем добавить это, в наш компилятор осторожно скопировав и переименовав. Но во избежание неразберихи ниже приведен полный листинг всех подпрограмм  анализатора. (Заметьте способ, которым мы изменяем порядок операндов в Divide.) </p>
<pre>
{ Parse and Translate a Math Factor } 
procedure Factor; 
begin 
   EmitLn('MOVE #' + GetNum + ',D0') 
end; 
 
{ Recognize and Translate a Multiply } 
procedure Multiply; 
begin 
   Match('*'); 
   Factor; 
   EmitLn('MULS (SP)+,D0'); 
end; 
{-------------------------------------------------------------} 
{ Recognize and Translate a Divide } 
procedure Divide; 
begin 
   Match('/'); 
   Factor; 
   EmitLn('MOVE (SP)+,D1'); 
   EmitLn('DIVS D1,D0'); 
end; 
{---------------------------------------------------------------} 
{ Parse and Translate a Math Term } 
procedure Term; 
begin 
   Factor; 
   while Look in ['*', '/'] do begin 
      EmitLn('MOVE D0,-(SP)'); 
      case Look of 
       '*': Multiply; 
       '/': Divide; 
      else Expected('Mulop'); 
      end; 
   end; 
end; 
 
{ Recognize and Translate an Add } 
procedure Add; 
begin 
   Match('+'); 
   Term; 
   EmitLn('ADD (SP)+,D0'); 
end; 
{-------------------------------------------------------------} 
{ Recognize and Translate a Subtract } 
procedure Subtract; 
begin 
   Match('-'); 
   Term; 
   EmitLn('SUB (SP)+,D0'); 
   EmitLn('NEG D0'); 
end; 
{---------------------------------------------------------------} 
{ Parse and Translate an Expression } 
procedure Expression; 
begin 
   Term; 
   while Look in ['+', '-'] do begin 
      EmitLn('MOVE D0,-(SP)'); 
      case Look of 
       '+': Add; 
       '-': Subtract; 
      else Expected('Addop'); 
      end; 
   end; 
end;
</pre>
Конфетка! Почти работающий транслятор в 55 строк Паскаля! Получаемый код начинает выглядеть действительно полезным, если не обращать внимание на неэффективность. Запомните, мы не пытаемся создавать сейчас самый компактный код. </p>
КРУГЛЫЕ СКОБКИ </p>
Мы можем закончить эту часть синтаксического анализатора, добавив поддержку круглых скобок. Как вы знаете, скобки являются механизмом принудительного изменения приоритета операторов. Так, например, в выражении </p>
     2*(3+4) , </p>
скобки заставляют выполнять сложение перед умножением. Но, что гораздо более важно, скобки дают нам механизм для определения выражений любой степени сложности, как, например </p>
     (1+2)/((3+4)+(5-6)) </p>
Ключом к встраиванию скобок в наш синтаксический анализатор является понимание того, что не зависимо от того, как сложно выражение,  заключенное в скобки, для остальной части мира оно выглядит как простой показатель. Это одна из форм для показателя: </p>
     &lt;factor&gt; ::= (&lt;expression&gt;) </p>
Здесь появляется рекурсия. Выражение может содержать показатель, который содержит другое выражение, которое содержит показатель и т.д. до бесконечности. </p>
Сложно это или нет, мы должны позаботиться об этом, добавив несколько строчек в процедуру Factor: </p>
<pre>
{ Parse and Translate a Math Factor } 
procedure Expression; Forward; 
procedure Factor; 
begin 
   if Look = '(' then begin 
      Match('('); 
      Expression; 
      Match(')'); 
      end 
   else 
      EmitLn('MOVE #' + GetNum + ',D0'); 
end;
</pre>
Заметьте снова, как легко мы можем дополнять синтаксический анализатор, и как хорошо код Паскаля соответствует  синтаксису БНФ. </p>
Как обычно, откомпилируйте новую версию и убедитесь, что анализатор корректно распознает допустимые  предложения и отмечает недопустимые сообщениями об ошибках. </p>
УНАРНЫЙ МИНУС </p>
На данном этапе мы имеем синтаксический анализатор, который поддерживает почти любые выражения, правильно? ОК, тогда испробуйте следующее предложение: </p>
     -1 </p>
Опс! Он не работает, не правда ли? Процедура Expression ожидает, что все числа будут целыми и спотыкается на знаке минус. Вы найдете, что +3 также не будет работать, так же как и что-нибудь типа: </p>
     -(3-2). </p>
Существует пара способов для исправления этой проблемы. Самый легкий (хотя и не обязательно самый лучший) способ &#8211; вставить ноль в начало выражения, так чтобы -3 стал 0-3. Мы можем легко исправить это в существующей версии Expression: </p>
<pre>
{ Parse and Translate an Expression } 
procedure Expression; 
begin 
   if IsAddop(Look) then 
      EmitLn('CLR D0') 
   else 
      Term; 
   while IsAddop(Look) do begin 
      EmitLn('MOVE D0,-(SP)'); 
      case Look of 
       '+': Add; 
       '-': Subtract; 
      else Expected('Addop'); 
      end; 
   end; 
end;
</pre>
&nbsp;</p>
Я говорил вам, насколько легко мы сможем вносить изменения! На этот раз они стоили нам всего трех новых строчек Паскаля. Обратите внимание на появление ссылки на новую функцию IsAddop. Как только проверка на addop появилась дважды, я решил выделить ее в отдельную функцию. Форма функции IsAddop должна быть аналогична форме функции IsAlpha. Вот она: </p>
<pre>
{ Recognize an Addop } 
function IsAddop(c: char): boolean; 
begin 
   IsAddop := c in ['+', '-']; 
end;
</pre>
ОК, внесите эти изменения в программу и повторно откомпилируйте. Вы должны также включить IsAddop в базовую копию программы Cradle. Она потребуется нам позже. Сейчас попробуйте снова ввести -1. Вау! Эффективность полученного кода довольно плохая… шесть строк кода только для того, чтобы загрузить простую константу… но, по крайней мере, правильно работает. Запомните, мы не пытаемся сделать замену Turbo Pascal. </p>
На данном этапе мы почти завершили создание структуры нашего синтаксического анализатора выражений. Эта версия программы должна правильно распознавать и компилировать почти любое выражение, которое вы ей подсунете. Она все еще ограничена тем, что поддерживает показатели, состоящие только из одной цифры. Но я надеюсь, что теперь вы начинаете понимать, что мы можем расширять возможности синтаксического анализатора делая незначительные изменения. Вы возможно даже не будете удивлены, когда услышите, что переменная или даже вызов функции это просто один из видов показателя. </p>
В следующей главе я покажу, как можно легко расширить наш синтаксический анализатор для поддержки всех этих возможностей, и я также покажу как легко мы можем добавить много символьные числа и имена переменных. Итак, вы видите, что мы совсем недалеко от действительно полезного синтаксического анализатора. </p>
СЛОВО ОБ ОПТИМИЗАЦИИ </p>
Раннее в этой главе я обещал дать несколько подсказок как мы можем повысить качество генерируемого кода. Как я сказал, получение компактного кода не является главной целью этой книги. Но вам нужно, по крайней мере, знать, что мы не зря проводим свое время… что мы действительно можем модифицировать анализатор, для получения лучшего кода не выбрасывая то, что мы уже сделали к настоящему времени. Обычно небольшая оптимизация не слишком трудна… просто в синтаксический анализатор вставляется дополнительный код.</p>
Существуют два основных метода, которые мы можем использовать: </p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Попытаться исправить код после того, как он сгенерирован. <br>
<p>Это понятие «щелевой» оптимизации. Основная идея в том, что известно какие комбинации инструкций компилятор собирается произвести и также известно которые из них «плохие» (такие как код для числа -1). Итак, все что нужно сделать &#8211; просканировать полученный код, найти такие комбинации инструкций и заменить их на более «хорошие». Это вид макрорасширений наоборот и прямой пример метода сопоставления с образцом. Единственная сложность в том, что может существовать множество таких комбинаций.  Этот метод называется «щелевой» оптимизацией просто потому, что оптимизатор работает с маленькой группой инструкций. «Щелевая» оптимизация может драматически влиять на качество кода и не требует при этом больших изменений в структуре компилятора. Но все же за это приходится платить скоростью, размером и сложностью компилятора. Поиск всех комбинаций требует проверки множества условий, каждая из которых является источником ошибки. И, естественно, это требует много времени. </td></tr></table>В классической реализации «щелевого» оптимизатора, оптимизация выполняется как второй проход компилятора. Выходной код записывается на диск и затем оптимизатор считывает и обрабатывает этот файл снова. Фактически, оптимизатор может быть даже отдельной от компилятора программой. Так как оптимизатор только обрабатывает код в маленьком «окне» инструкций (отсюда и название),  лучшей реализацией было бы буферизировать несколько срок выходного кода и сканировать буфер каждый раз после EmitLn. </p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Попытаться сразу генерировать лучший код.</td></tr></table>В этом методе выполняется проверка дополнительных условий перед  выводом кода. Как тривиальный пример, мы должны были бы идентифицировать нуль и выдать CLR вместо загрузки, или даже совсем ничего не делать, как в случае с прибавлением нуля, например. Конкретней, если мы решили распознавать унарный минус в процедуре Factor вместо Expression, то мы должны обрабатывать &#8211;1 как обычную константу, а не генерировать ее из положительных. Ни одна из этих вещей  не является слишком сложной для реализации… просто они требуют включения дополнительных проверок в код, поэтому я не включил их в программу. Как только мы дойдем до получения работающего компилятора, генерирующего полезный выполнимый код, мы всегда сможем вернуться и доработать программу для получения более компактного кода. Именно поэтому в мире существует «Версия 2.0».</p>
Существует еще один, достойный упоминания, способ оптимизации, обещающий достаточно компактный код без излишних хлопот. Это мое «изобретение», в  том смысле, что я нигде не видел публикаций по этому методу, хотя я и не питаю иллюзий что это придумано мной. </p>
Способ заключается в том, чтобы избежать частого использования стека, лучше используя регистры центрального процессора. Вспомните, когда мы выполняли только сложение и вычитание, то мы использовали регистры D0 и D1 а не стек? Это работало, потому для этих двух операций стек никогда не использовал более чем две ячейки. </p>
Хорошо, процессор 68000 имеет восемь регистров данных. Почему бы не использовать их как стек? В любой момент своей работы синтаксический анализатор «знает» как много элементов в стеке, поэтому он может правильно ими манипулировать. Мы можем определить частный указатель стека, который следит, на каком уровне мы находимся и адресует соответствующий регистр. Процедура Factor, например, должна загружать данные не в регистр D0, а в тот, который является текущей вершиной стека.</p>
Что мы получаем, заменяя стек в RAM на локальный стек созданный из регистров. Для большинства выражений уровень стека никогда не превысит восьми, поэтому мы получаем достаточно хороший код. Конечно, мы должны предусмотреть те случаи, когда уровень стека превысит восемь, но это также не проблема. Мы просто позволим стеку перетекать в стек ЦПУ. Для уровней выше восьми код не хуже, чем тот, который мы генерируем сейчас, а для уровней ниже восьми он значительно лучше. </p>
Я реализовал этот метод, просто для того, чтобы удостовериться в том, что он работает перед тем, как представить его вам. Он работает. На практике вы не можете в действительности использовать все восемь уровней... вам, как минимум, нужен один свободный регистр для изменения порядка операндов при делении. Для выражений, включающих вызовы функций, также необходимо зарезервировать регистр. Но все равно, существует возможность улучшения размера кода для большинства выражений.</p>
Итак, вы видите, что получение лучшего кода не настолько трудно, но это усложняет наш транслятор... это сложность, без которой мы можем сейчас обойтись. По этой причине, я очень советую продолжать игнорировать вопросы эффективности в этой книге, усвоив, что мы действительно можем повысить качество кода, не выбрасывая того, что уже сделано.</p>
В следующей главе я покажу вам как работать с переменными и вызовами функций. Я также покажу вам как легко добавить поддержку много символьных токенов и пробелов.</p>
