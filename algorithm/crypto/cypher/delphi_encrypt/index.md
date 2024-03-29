---
Title: Шифрование в Delphi
Author: Трофим Роцкий
Date: 16.01.2007
---


Шифрование в Delphi
===================

Данные надо беречь. Сам посуди, обидно, если открытие ценой в сто
миллионов енотов
или рецепт безалкогольной водки, над которым ты корпел три вечера в
мрачном подвале
нелегального компьютерного клуба, уплывет к злостному ленивому
конкуренту,
который, пользуясь твоим похмельем, наложил грязную лапу на приватные
дискеты с ценнейшей инфой?!
Дальше можно не продолжать. Шифруем, шифруем, шифруем!..

Добрый дядюшка borland предоставил нам несколько занятных функций для
работы со строками, о которых не все знают. Сосредоточены они в модуле
strutils.pas.

Такие функции, как rightstr, leftstr совмещают стандартные команды copy
и delete: так, leftstr возвращает значение левой части строки до
указанной вами позиции (что вытворяет rightstr, догадайся сам), а
функция reversestring и вовсе делает зеркальное отображение данной
строки: 321 вместо 123. Используем ее в особенности,
чтобы осложнить жизнь хитрому дешифровщику.

Алгоритм шифрования будет прост, как win 3.1.
С каждым символом кодируемого документа проделаем следующее:

1. Преобразуем символ в число командой ord.
2. Преобразуем каждый символ пользовательского пароля
   в число и сумму этих чисел прибавим к полученному в пункте 1.
3. От результата отнимаем число, равное позиции данного символа.
   То есть буковки будут шифроваться по-разному в зависимости от их позиции
   в строке :).
4. То, что получилось, запишем обратно из чисел в символы командой chr.
   Как видишь, после всех наших манипуляций этот символ уже будет другим.
5. Запишем всю строку навыворот командой reversestring.

Дешифровка, как ты догадываешься, будет производиться в обратном
порядке.

Теперь, когда алгоритм намертво засел в голове, реализуем
соответствующую программу.
Внимание! Не исключено, что это будет первая твоя программа с настоящим
синтаксисом команд:

    <команда> <путь> <пароль>

так будет выглядеть он в консоли нашего приложения (да, оно будет
консольным!).
Команд всего две: crypt и decrypt соответственно зашифровать и
дешифровать файл,
путь к которому указывается после пробела, а затем - твой пароль. НЕ
ЗАБУДЬ ЕГО!
Предупреждаю совершенно серьезно. Запомнил? В бой!
закодируем file.txt:

    crypt c:file.txt linuxmustsurvive

Результат (зашифрованный текст) сохранится в той же директории,
что и исполняемый файл нашего приложения под именем
translated_file.txt.
Дешифровка:

    decrypt c:translated\file.txt linuxmustsurvive

Реализовывается это вот как:

    program crypter;
     
    {$apptype console}
     
    uses
    sysutils,
    strutils; //!!
    var
    f, //входящий файл
    f1: textfile; //результат (файл с переводом)
    todo, filename, passw, line, translatedfile: string;
    position, iscrypt: integer;
     
    //находим сумму числовых значений символов пароля
    function password(psw: string): integer;
    var
    i,res: integer;
    begin
    res:=0;
    for i:=1 to length(psw) do res:=res+ord(psw[i]);
    result:=res;
    end;
     
    function crypt(cryptstr: string): string;
    var
    s: string;
    i: integer;
    begin
    if cryptstr<>emptystr then
    for i:=1 to length(cryptstr) do begin
    s:=leftstr(cryptstr,1);
    cryptstr:=rightstr(cryptstr,length(cryptstr)-1);
    //ШИФРОВКА:
    s:=chr(ord(s[1])+password(passw)-i);
    result:=result+s;
    end;
    result:=reversestring(result);
    end;
     
    function decrypt(decryptstr: string): string;
    var
    i: integer;
    s: string;
    begin
    decryptstr:=reversestring(decryptstr);
    if decryptstr<>emptystr then
    for i:=1 to length(decryptstr) do begin
    s:=leftstr(decryptstr,1);
    decryptstr:=rightstr(decryptstr,length(decryptstr)-1);
    //ДЕШИФРОВКА:
    result:=result+chr(ord(s[1])-password(passw)+i);
    end;
    end;
     
    begin
    while true do begin
    iscrypt:=0;
    writeln(#10+'crypter >'+#10);
    //Какую команду ввел юзер?
    readln(todo);
    if uppercase(todo)='exit' then exit;
    if ansicontainstext(todo,'decrypt') then iscrypt:=1
    else if ansicontainstext(todo,'crypt') then iscrypt:=2;
    //прочитав команду, удаляем ее из строки и читаем дальше
    position:=pos(' ',todo);
    if position>0 then todo:=rightstr(todo,length(todo)-position);
    //Читаем путь к файлу
    position:=pos(' ',todo);
    if position>0 then filename:=leftstr(todo,position-1);
    //Читаем пароль
    passw:=rightstr(todo,length(todo)-position);
    //Всё правильно? Начинаем!
    if (iscrypt<=0) or (passw=emptystr) or 
    (not fileexists(filename)) then writeln('wrong command')
    else begin
    translatedfile:=extractfilepath(paramstr(0)) + 
    'translated_' + extractfilename(filename);
    //соединяемся с файлами
    assignfile(f, filename);
    assignfile(f1, translatedfile);
    //переходим в начало файла
    rewrite(f1);
    reset(f);
    //читаем строки, пока не дойдем до конца файла
    while not eof(f) do begin
    //читаем из переводимого файла
    readln(f, line);
    if iscrypt=1 then line:=decrypt(line);
    if iscrypt=2 then line:=crypt(line);
    //записываем в файл с переводом
    writeln(f1, line);
    end;
    //отсоединямся от файлов 
    closefile(f);
    closefile(f1);
    end;
    end;
    end.


Вот, собственно, и всё.
Еще раз напоминаю, что результат (файл с переводом)
сохранится В ТОЙ ЖЕ ДИРЕКТОРИИ, что и наше приложение,
а не в той, где лежит исходный файл.

В заключение процитирую отрывок из статьи
«Криптография в c++» в номере 3.03 журнала «Хакер»:

> //(с) Николай «gorlum» Андреев
> Но я хочу тебя предупредить:  
> в нашей стране, согласно указу № 334 от 1995 года,
> производить и распространять любые шифрующие средства можно,
> только имея лицензию ФАПСИ.  
> Соответственно, шифровать нельзя :).

Поэтому пиши программы только для личного пользования и только в
познавательных целях.


Автор: Трофим Роцкий
