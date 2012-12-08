---
Title: Паскалевский метод доступа
Date: 01.01.2007
---


Паскалевский метод доступа
==========================

::: {.date}
01.01.2007
:::

Для более тонких операций над текстовыми файлами прийдется освоить очень
древний паскалевский способ.

Итак, для доступа к текстовым файлам используется переменная типа
TextFile. До сих пор не совсем понимаю что это такое физически - что-то
типа \"внутреннего\" паскалевского Handle на файл.

Итак чтобы ассоциировать файл на диске с переменной надо проделать
следующие опрерации:

1\) Определяем файловую переменную:

var f:TextFile;        

2\) Ассоциируем ее:

AssignFile(F, \'c:\\MyFile.txt\');        

3\) Теперь надо этот файл открыть, есть 3 варианта:

\- файла нет или он должен быть перезаписан, открытие для записи:

Rewrite(f)        

\- файл есть и его надо открыть для чтения (с первой строки)

Reset(f)        

\- файл есть и его надо открыть для дописования строк в конец

Append(f)        

Как видите не хватает очень полезных функций таких как открытия файла
для чтения с произвольной строки и для записи в файл произвольной
строки. Но надо учесть, что так как длины строк разные, не существует
никакого способа узнать физическое место начала например 1000 строки, не
прочитав всю тысячу строк. Для записи ситуация еще сложнее - вставить
строку означает перезаписать всю информацию после этой строки заново.
Таким образом варианты только следующие:

\- Перезаписать весть файл

\- Читать с первой строки

\- Дописать что-то в конец

\- Читать и писать файл целиком (см. выше работу через TStrings)

В конце работы открытый файл нужно закрыть:

CloseFile(f);        

Теперь пусть у нас есть строковая переменная s для чтения строки из
файла

Чтение предварительно открытого файла:

ReadLn(f, s) - будет прочитанна текущая строка и позиция чтения
переведена на следующую позицию.        

А как прочитать весь файл?

    While not eof(f) do  
    begin 
    ReadLn(f, s); 
    {здесь делаем что-то с прочитанной строкой} 
    end; 

       

Хорошо, а если файл несколько метров есть ли способ поставить
какой-нибудь ProgressBar или Gauge чтобы показывал сколько считанно?
Есть, но не совсем прямой - не забыли, сколько строк в файле заранее мы
не знаем, узнать можно только прочитав его весь, но показометер мы
все-таки сделаем:

    var Canceled:Boolean;
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

Теперь комментарии к коду.

1\) Функию GetFileSize я рсссмотрю после, она немного по другому подходит
к чтению файла (кстати я знаю еще по крайней мере 3 способа ее
реализации, поэтому не нужно указывать что это можно сделать легче,
быстрее или просто по другому - просто давайте разберем это позже)

2\) Переменная i - все время указывает на количество байт которое мы
считали - мы определяем длину каждой строки и прибавляем 2 (символы
конца строки). Зная длину файла в байтах и сколько байт прочитано можно
оценить и прогресс, но

3\) Если ставить изменение прогресса после каждой строки, то это очень
сильно тормознет процесс. Поэтому вводим переменную j и обновляем
прогресс например 1 раз на 1000 прочитанных строк

4\) Переменная Canceled - глобальная переменная. Поставьте на форму
кнопку, в обработчике нажатия поставьте Canceled:=True; и нажатие кнопки
прервет чтение файла.

Теперь как писать в текстовый файл:

Запись целой строки:

Writeln(f,s);        

Запись кусочка строки(те следующая операция записи будет произведена в
ту же строку):

Write(f,s);        

Если переменная s содержит больше 255 символов (т.е. является длинной
строкой), то таким способом ни фига не запишится, в файл вместо строки
попадут 4 байта указателя на нее. Надо делать так:

Writeln(f,pointer(s)\^);        