---
Title: Перенаправление стандартного ввода и вывода
Author: Горбань С.В.
Date: 01.01.2007
---

Перенаправление стандартного ввода и вывода
===========================================

::: {.date}
01.01.2007
:::

Автор: Горбань С.В.

Вообще - я программист молодой, стаж - всего 2 года. И я никак не
ожидал, что в век GDI мне придется возится с консолью... Ан нет,
пришлось.

Начал писать "движок" для собственного сайта. А именно - "Apache 1.x
shared module" (dll - линкуется к Апачу и обрабатывает определенные
адреса).

Написал. Всего три сотни строк. НО умеет кучу всяких полезностей, типа
вставлять на страницы данные из файлов (файл в файл), строки и, главное,
данные из БД. Все это прекрасно. НО не умеет вставлять результаты работы
других файлов (типа как CGI). Ну, думаю, надо сделать.

Ага, а как? Вот тут то все и началось...

Итак,

ЗАДАЧА:

запустить процесс (некий файл), передать ему команды и получить от него
результаты работы. Вставить полученные результаты на страницу сайта.
Причем в целях совместимости механизмы передачи данных ДОЛЖНЫ быть
стандартными - StdIn, StdOut, StdErr.

Поискал на КД. Нашел вот такую штуку: Как переназначить StdOut в файл
для консольной программы запускаемой по CreateProcess

Хорошая статья, но мне-то НЕ в ФАЙЛ, а в ПРОГРАММУ надо! Автор (Спасибо
ему!!!) предусмотрительно указал ссылки на полезные раздел справки -
"Creating a Child Process with Redirected Input and Output". Лезем
туда. Ууууух... Круто. В общем, каких-то два дня ковыряния и вуаля!
Работает!

Получился небольшой такой класс... За кривизну некоторых мест, типа
отсутствия проверок - НЕ бить! (по крайней мере ногами :-)). Кому надо -
тот сам вставит. (Вот так и рождается "кривой" код. Типа сейчас лень,
потом добавлю... Ага... Через час уже забудешь!!!)

В общем - перехожу таки к технике дела.

Для передачи данных используются "безымянные" (Anonymus) "каналы"
(Pipes). Чтобы заставить программу писать в (читать из) канал (а) -
просто подменяем соответствующие Std(In, Out, Err). Программа и знать не
будет, что ее данные уходят в "трубу" а не на реальную консоль.

При создании каналов есть одна ВАЖНАЯ особенность. Создаем-то мы их в
своем процессе (Parent) а использовать будем и в дочернем. (Учтите!
дочерний процесс НЕ будет знать, что использует КАНАЛ! НО будет его
использовать...). Так, вот, чтобы дочерний процесс мог нормально
работать - хэндлы канала должны быть НАСЛЕДУЕМЫМИ.

Чтобы это обеспечить - надо правильно заполнить структуру
SECURITY\_ATTRIBUTES используемую при вызове CreatePipe:

    New(FsaAttr);
    FsaAttr.nLength := SizeOf(SECURITY_ATTRIBUTES);
    FsaAttr.bInheritHandle := True;
    FsaAttr.lpSecurityDescriptor := nil;

Заполнили? Молодцы! Теперь создаем каналы (я делаю только два, StdErr
мне не нужен):

    if not CreatePipe(FChildStdoutRd, FChildStdoutWr, FsaAttr, 0) then
      //Создаем "читальный" Pipe
      raise ECreatePipeErr.CreateRes(@sCreatePipeMsg)
    else
    if not CreatePipe(FChildStdinRd, FChildStdinWr, FsaAttr, 0) then
      //Создаем "писальный" Pipe
      raise ECreatePipeErr.CreateRes(@sCreatePipeMsg)

Создали? Если нет - то дальше ловить нечего, поэтому генерим
Exception\'ы...

Есть еще одна тонкость. У нас Все созданные хэндлы наследуемые! А
дочернему процессу понадобятся только два... Поэтому:

    // Делаем НЕ наследуемые дубликаты
    // Это нужно, чтобы не тащить лишние хэндлы в дочерний процесс...
    if not DuplicateHandle(GetCurrentProcess(), FChildStdoutRd,
      GetCurrentProcess(), @Tmp1, 0, False, DUPLICATE_SAME_ACCESS) then
      raise EDuplicateHandleErr.CreateRes(@sDuplicateHandleMsg)
    else if not DuplicateHandle(GetCurrentProcess(), FChildStdinWr,
      GetCurrentProcess(), @Tmp2, 0, False, DUPLICATE_SAME_ACCESS) then
      raise EDuplicateHandleErr.CreateRes(@sDuplicateHandleMsg)

Дубликаты у нас в Tmp1 и Tmp2, теперь:

    CloseHandle(FChildStdoutRd); //Закроем наследуемый вариант "Читального" хэндла
    CloseHandle(FChildStdinWr); //Закроем наследуемый вариант "Писального" хэндла
    FChildStdoutRd := Tmp1;    //И воткнем их места НЕ наследуемые дубликаты
    FChildStdinWr := Tmp2;    //И воткнем их места НЕ наследуемые дубликаты

Ура! Теперь можем создавать дочерний процесс!

    if not CreateChildProcess(ExeName, CommadLine, FChildStdinRd, FChildStdoutWr) then
      // Наконец-то! Создаем дочерний процесс!
      raise ECreateChildProcessErr.CreateRes(@sCreateChildProcessMsg)

Причем CreateChildProcess - это не API - это моя функция! Вот она:

    function TChildProc.CreateChildProcess(ExeName, CommadLine: string; StdIn,
      StdOut: THandle): Boolean;
    var
      piProcInfo: TProcessInformation;
      siStartInfo: TStartupInfo;
    begin
      // Set up members of STARTUPINFO structure.
      ZeroMemory(@siStartInfo, SizeOf(TStartupInfo));
      siStartInfo.cb := SizeOf(TStartupInfo);
      siStartInfo.hStdInput := StdIn;
      siStartInfo.hStdOutput := StdOut;
      siStartInfo.dwFlags := STARTF_USESTDHANDLES;
      // Create the child process.
      Result := CreateProcess(nil,
        PChar(ExeName + ' ' + CommadLine), // command line
        nil, // process security attributes
        nil, // primary thread security attributes
        TRUE, // handles are inherited
        0, // creation flags
        nil, // use parent's environment
        nil, // use parent's current directory
        siStartInfo, // STARTUPINFO pointer
        piProcInfo); // receives PROCESS_INFORMATION
    end;

Здесь важное значение имеют вот эти строчки:

    siStartInfo.hStdInput := StdIn;
    siStartInfo.hStdOutput := StdOut;
    siStartInfo.dwFlags := STARTF_USESTDHANDLES;

Первые две - понятно. А третья - читайте Хелп! Там все написано...

Самые умные (то есть те, кто ухитрился дочитать до этого места :-)))
спросят:

\- Ну, создали мы процесс и что дальше?

А дальше - мы можем с ентим процессом общаться! Например вот так:

    function TChildProc.WriteToChild(Data: string; Timeout: Integer = 1000): Boolean;
    var
      dwWritten, BufSize: DWORD;
      chBuf: PChar;
    begin
      //Обратите внимание на Chr($0D)+Chr($0A)!!! Без них - будет работать с ошибками
      //На досуге - подумайте почему...
      //Для тех, кому думать лень - подскажу - это пара символов конца строки.
      //(вообще-то можно обойтись одним, но так надежнее, программы-то бывают разные)
      chBuf := PChar(Data + Chr($0D) + Chr($0A));
      BufSize := Length(chBuf);
      Result := WriteFile(FChildStdinWr, chBuf^, BufSize, dwWritten, nil);
      Result := Result and (BufSize = dwWritten);
    end;

Это мы посылаем данные на StdIn процесса.

Читать - несколько сложнее. Нам же не надо вешать всю нашу программу
только потому, что процесс не желает нам ничего сообщать??? А ReadFile -
функция синхронная и висит - пока не прочитает! Если заранее известно,
чего и сколько ДОЛЖЕН выдать процесс, то еще ничего... А если нет?

А если нет - делаем хитрый финт ушами :-) Есть у Мелко-Мягких такая ф-ия
PeekNamedPipe. Не покупайтесь, на то, что она "Named" - фигня! Она
прекрасно работает а анонимными пайпами! (кто не верит - можете почитать
хелп)

Поэтому делаем так:

    function TChildProc.ReadStrFromChild(Timeout: Integer): string;
    var
      i: Integer;
      dwRead, BufSize, DesBufSize: DWORD;
      chBuf: PChar;
      Res: Boolean;
    begin
      try
        BufSize := 0;
        New(chBuf);
        repeat
          for i := 0 to 9 do
          begin
            Res := PeekNamedPipe(FChildStdoutRd, nil, 0, nil, @DesBufSize, nil);
            Res := Res and (DesBufSize > 0);
            if Res then
              Break;
            Sleep(Round(Timeout / 10));
          end;
          if Res then
          begin
            if DesBufSize > BufSize then
            begin
              FreeMem(chBuf);
              GetMem(chBuf, DesBufSize);
              BufSize := DesBufSize;
            end;
            Res := ReadFile(FChildStdoutRd, chBuf^, BufSize, dwRead, nil);
            Result := Result + LeftStr(chBuf, dwRead);
          end;
        until not Res;
      except
        Result := 'Read Err';
      end;
    end;

Ну, вот, как я и говорил - работает. Даже слишком хорошо. Как я и
говорил - эта вся бодяга для Web сервера. Ну, беру я в качестве файла -
format.exe.... Ндаааа....

Если честно - с format\'ом я не прверял - а вот help c парметрами и
"net use" прошли на ура! Так что пришлось резко думать, как ограничить
список разрешенных для запуска программ....

В общем, кому лень разбираться - вот вам исходники модуля с готовым
классом. А вот пример его использования:

    with TChildProc.Create(ReadIni(TagParams.Values['file'], FPage),
      TagParams.Values['cmd']) do
      try
        WriteToChild(TagParams.Text);
        ReplaceText := ReadStrFromChild;
      finally
        Free;
      end;

Не правда ли просто?

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
