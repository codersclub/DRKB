---
Title: Русификация консольных приложений в Delphi
Author: Eugene Kasnerik, eugene1975@mail.ru
Date: 12.12.1999
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---

Русификация консольных приложений в Delphi
==========================================

С периодичностью раз в месяц-полтора конференция RU.DELPHI оглашается
стонами на тему "Консоль не поет по-русски", за которыми стоит вывод
текста в консольных приложениях в кодировке OEM (Delphi IDE, как и все
GUI, работает в ANSI).

С точки зрения набора символов эти кодовых таблицы не совпадают: позиции
символов кириллицы в них различны (отсюда и неприятные эффекты), кроме
того, в ANSI присутствуют диакритические символы, которых нет в OEM, но
в последней имеются символы псевдографики, незаменимые при изображении
таблиц (интересно, это еще кем-то востребовано? На ум приходит только
FAR). Впрочем, возможности для вывода текстовой информации у этих таблиц
одинаковы, что в нашем случае позволяет говорить о взаимозаменяемости.

Рассмотрим некоторые способы, которыми можно решить возникающие проблемы
(три из них встречаются в различных FAQ, последний менее тривиален, но,
видимо, в наибольшей степень отвечает задаче).

Работа в OEM-редакторе. Вместо борьбы с выводом «не тех» символов можно
пойти иным путем - изначально готовить текст программы (точнее те его
части, которые критичны к кодовой таблице) в редакторе, работающем в
кодировке OEM. Решение простенькое, но на удивление эффективное,
особенно при написании каких-либо локальных утилит, в которых, тем не
менее, сильно востребован вывод информации.

К недостаткам можно отнести работу вне привычного IDE с его облегчающими
жизнь наворотами (кодирование, компиляция и отладка в одном флаконе), а
также определенные сложности при разрастании проекта, когда начинают
использоваться сторонние строковые ресурсы, созданные с применением
кодировки ANSI.

Если же проект не содержит hard-coded (включенных непосредственно в код)
строк, то возможно организовать вынесение всех строковых ресурсов в
отдельные модули с последующей их локализацией под требуемую
кодировку - утилит, меняющих кодировку файлов существует предостаточно.

Использование фильтрующих процедур. Windows API содержит функции для
преобразования между кодировками OEM и ANSI OemToChar, CharToOem,
которые и предлагается использовать при выводе текста, заменяя фрагменты

    Writeln('Delphi World - это круто!!!');

на:

    procedure MyWriteln(const S: string);
    var
      NewStr: string;
    begin
      SetLengtn(NewStr, Length(S));
      CharToOem(PChar(S), PChar(NewStr));
      Writeln(NewStr);
    end;
    ...
    MyWriteln('Delphi World - это круто!!!');

К недостаткам можно отнести невозможность использования расширенного
синтаксиса Write, а также некоторое захламление текста программы явным
вызовом фильтрующих процедур. Задача становится совсем неприятной, когда
предстоит «русифицировать» уже готовое приложение со многими обращениями
к Write, поэтому применять его стоит с определенными оговорками.

Изменение кодовой страницы консоли. В принципе, для решения задачи есть
документированный способ - изменение кодовой страницы консоли
средствами Windows API. Проблема лишь в том, что в Win95/98 функция не
работает. Впрочем, если приложение будет работать только в Windows NT,
можно воспользоваться функцией SetConsoleOutputCP(866).

Перекрытие процедур вывода в RTL. Вывод в Pascal (еще в версиях от
Borland для DOS) через Write-процедуры осуществляется посредством
передачи выводимой информации в файл Output, который вполне можно
подвергнуть легкой модификации с целью упростить себе жизнь.

Известно, что Write/Writeln без указания файла осуществляет вывод в файл
Output. Output имеет тип TextFile, он же TTextRec, содержимое которого
описано в SysUtils.pas. Есть там и поля, содержащие адреса процедур, в
которые приходит на обработку поток выводимых приложением данных (в
случае вывода). Не вдаваясь в подробности (желающие могут посмотреть
устройство механизмов вывода в исходниках RTL), покажем, что происходит
в процедуре, отвечающей за вывод (TTextRec.InOutFunc):

    { Реконструкция TextOut из Assign.asm }
    function TextOut(var Text: TTextRec): Integer;
    var
      Dummy: Cardinal;
      SavePos: Integer;
    begin
      SavePos := Text.BufPos;
      if SavePos > 0 then
      begin
        Text.BufPos := 0;
        if WriteFile(Text.Handle, Text.BufPtr^, SavePos, Dummy, nil) then
          Result := 0
        else
          Result := GetLastError;
      end
      else
        Result := 0;
    end;

Теперь видно, что нужно сделать для вывода символов в нужной кодовой
таблице - перед выводом в файл средствами ОС модифицировать данные в
выходном буфере структуры Text, вписав следующую строку:

    CharToOemBuff(Text.BufPtr, Text.BufPtr, SavePos);

Модифицировать буфер можно, т.к. после операции записи в файл содержимое
буфера фактически сбрасывается (когда в Text.BufPos записывается 0 -
именно столько актуальных данных остается в буфере). Если не
завязываться на эту особенность реализации, можно распределить буфер и
модифицировать данные уже в нем. Впрочем, решение в любом случае
достаточно сильно опирается на особенности реализации, поэтому проверить
его пригодность при смене версии Delphi рекомендуется в любом случае. С
другой стороны, вероятность отхода Borland от наработанного решения
крайне мала.

Заметим, что кроме InOutFunc вывод в файл ОС происходит и в FlushFunc,
которая в файле Output указывает на ту же функцию, что и InOutFunc. С
учетом всего вышесказанного модуль, осуществляющий «русификацию»
консольных приложений «на лету» будет совсем небольшим:

    {
    Модуль “русификации“ консольных приложений
    (c) Eugene Kasnerik, 1999
    e-mail: eugene1975@mail.ru
    }
    unit EsConsole;
     
    interface
     
    implementation
     
    uses
      Windows;
     
    {
    Описание структуры приведено здесь с единственной целью –
    не подключать SysUtils и, соответственно, код инициализации
    этого модуля. Консольные приложения обычно малы и 25К кода
    обработки исключений – несколько высокая плата за описание
    единственной структуры.
    }
    type
      TTextRec = record
        Handle: Integer;
        Mode: Integer;
        BufSize: Cardinal;
        BufPos: Cardinal;
        BufEnd: Cardinal;
        BufPtr: PChar;
        OpenFunc: Pointer;
        InOutFunc: Pointer;
        FlushFunc: Pointer;
        CloseFunc: Pointer;
        UserData: array[1..32] of Byte;
        name: array[0..259] of Char;
        Buffer: array[0..127] of Char;
    end;
     
    function ConOutFunc(var Text: TTextRec): Integer;
    var
      Dummy: Cardinal;
      SavePos: Integer;
    begin
      SavePos := Text.BufPos;
      if SavePos > 0 then
      begin
        Text.BufPos := 0;
        CharToOemBuff(Text.BufPtr, Text.BufPtr, SavePos);
        if WriteFile(Text.Handle, Text.BufPtr^, SavePos, Dummy, nil) then
          Result := 0
        else
          Result := GetLastError;
      end
      else
        Result := 0;
    end;
     
    initialization
      Rewrite(Output); // Проводим инициализацию файла
      { И подменяем обработчики. Есть в этом что-то от
      хака, но цель оправдывает средства }
      TTextRec(Output).InOutFunc := @ConOutFunc;
      TTextRec(Output).FlushFunc := @ConOutFunc;
    end.

Для русификации приложения достаточно лишь подключить вышеуказанный
модуль в любом месте программы (как правило, в проекте), после чего
вывод ANSI-символов будет осуществлен в ожидаемом виде. Однако следует
иметь в виду, что не будут доступны символы псевдографики (для них нет
аналогов в ANSI, т.е. в редакторе их не введешь) и часть диакритических
знаков (для них нет аналогов в OEM). Впрочем, для модификации значений
выводимых символов не обязательно использовать системные функции, что
открывает простор для консольного вывода в самых разных кодировках.
