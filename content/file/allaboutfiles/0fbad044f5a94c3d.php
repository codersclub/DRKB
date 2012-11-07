<h1>Паскалевский метод доступа</h1>
<div class="date">01.01.2007</div>


<p>Для более тонких операций над текстовыми файлами прийдется освоить очень древний паскалевский способ.</p>
<p>Итак, для доступа к текстовым файлам используется переменная типа TextFile. До сих пор не совсем понимаю что это такое физически - что-то типа "внутреннего" паскалевского Handle на файл.</p>
<p>Итак чтобы ассоциировать файл на диске с переменной надо проделать следующие опрерации:</p>
<p>1) Определяем файловую переменную:</p>
<p> var f:TextFile;</p>
<p>2) Ассоциируем ее:</p>
<p> AssignFile(F, 'c:\MyFile.txt');</p>
<p>3) Теперь надо этот файл открыть, есть 3 варианта:</p>
<p>- файла нет или он должен быть перезаписан, открытие для записи:</p>
<p>Rewrite(f)</p>
<p>- файл есть и его надо открыть для чтения (с первой строки)</p>
<p>Reset(f)</p>
<p>- файл есть и его надо открыть для дописования строк в конец</p>
<p>Append(f)</p>
<p>Как видите не хватает очень полезных функций таких как открытия файла для чтения с произвольной строки и для записи в файл произвольной строки. Но надо учесть, что так как длины строк разные, не существует никакого способа узнать физическое место начала например 1000 строки, не прочитав всю тысячу строк. Для записи ситуация еще сложнее - вставить строку означает перезаписать всю информацию после этой строки заново. Таким образом варианты только следующие:</p>
<p>- Перезаписать весть файл</p>
<p>- Читать с первой строки</p>
<p>- Дописать что-то в конец</p>
<p>- Читать и писать файл целиком (см. выше работу через TStrings)</p>
<p>В конце работы открытый файл нужно закрыть:</p>
<p>CloseFile(f);</p>
<p>Теперь пусть у нас есть строковая переменная s для чтения строки из файла</p>
<p>Чтение предварительно открытого файла:</p>
<p>ReadLn(f, s) - будет прочитанна текущая строка и позиция чтения переведена на следующую позицию.</p>
<p>А как прочитать весь файл?</p>
<pre>While not eof(f) do  
begin 
ReadLn(f, s); 
{здесь делаем что-то с прочитанной строкой} 
end; 
</pre>
</p>
<p>Хорошо, а если файл несколько метров есть ли способ поставить какой-нибудь ProgressBar или Gauge чтобы показывал сколько считанно? Есть, но не совсем прямой - не забыли, сколько строк в файле заранее мы не знаем, узнать можно только прочитав его весь, но показометер мы все-таки сделаем:</p>
<pre>var Canceled:Boolean;
Function GetFileSize(FIleName:String):integer;
var f: File of Byte;
begin
try
AssignFile(f, FileName);
Reset(f);
result:=filesize(F);
CloseFile(f);
except
result:=-1;
end;
end;
Procedure ReadMyFile;
Var i,j:integer;
Begin
ProgressBar1.Max:=GetFileSize('c:\MyFile.txt');
ProgressBar1.position:=0;
assignfile(f,'c:\MyFile.txt');
Canceled:=False;
reset(f);
i:=0;j:=0;
while not eof(f) do
begin
inc(j);
readln(f,s);
i:=i+length(s)+2;
if (j mod 1000)=0 then
begin
ProgressBar1.position:=i;
Application.ProcessMessages;
if canceled then break;
end;
{здесь мы что-то делаем с прочитанной строкой}
end;
CloseFile(f);
End;
</pre>

<p>Теперь комментарии к коду.</p>
<p>1) Функию GetFileSize я рсссмотрю после, она немного по другому подходит к чтению файла (кстати я знаю еще по крайней мере 3 способа ее реализации, поэтому не нужно указывать что это можно сделать легче, быстрее или просто по другому - просто давайте разберем это позже)</p>
<p>2) Переменная i - все время указывает на количество байт которое мы считали - мы определяем длину каждой строки и прибавляем 2 (символы конца строки). Зная длину файла в байтах и сколько байт прочитано можно оценить и прогресс, но</p>
<p>3) Если ставить изменение прогресса после каждой строки, то это очень сильно тормознет процесс. Поэтому вводим переменную j и обновляем прогресс например 1 раз на 1000 прочитанных строк</p>
<p>4) Переменная Canceled - глобальная переменная. Поставьте на форму кнопку, в обработчике нажатия поставьте Canceled:=True; и нажатие кнопки прервет чтение файла.</p>
<p>Теперь как писать в текстовый файл:</p>
<p>Запись целой строки:</p>
<p>Writeln(f,s);</p>
<p>Запись кусочка строки(те следующая операция записи будет произведена в ту же строку):</p>
<p>Write(f,s);</p>
<p>Если переменная s содержит больше 255 символов (т.е. является длинной строкой), то таким способом ни фига не запишится, в файл вместо строки попадут 4 байта указателя на нее. Надо делать так:</p>
<p>Writeln(f,pointer(s)^);</p>

