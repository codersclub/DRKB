---
Title: Как переназначить вывод в файл для консольной программы?
Date: 01.01.2007
---

Как переназначить вывод в файл для консольной программы?
========================================================

::: {.date}
01.01.2007
:::

Я не профи в Win API, просто у меня возникла именно такая проблема. Я
нашел решение устраивающее меня. И к тому же решил, поделился с вами.
Если кому-то требуется что-то другое - дерзайте, я с удовольствием
прочту на "Королевстве" что и как у вас получилось. Handle = Хэндл =
Рукоятка :)

Хочу предложить 2 способа:

1) Простой, с использованием command.com /c имя\_консольной\_проги \>
имя\_файла\_куда\_переназначить\_StdOut

2) С использованием Win API (2 штуки)

Вы уж сами выберите, что вам подходит больше. Я использую способ № 2.2.

Рассмотрим их более подробно на примерах.

Способ №1

    var
      StartupInfo: TStartupInfo;
      ProcessInformation: TProcessInformation;
    begin
      GetStartupInfo(StartupInfo);
      with StartupInfo do
      begin
        wShowWindow := SW_HIDE; //не показывать окно
        dwFlags := STARTF_USESHOWWINDOW;
      end;
     
    // для примера будем запускать [c:\program files\Borland\Delphi5\Bin]grep.exe с ключом '?'
      Win32Check(CreateProcess(nil, 'command.com /c  grep.exe ? > MyStdOut.txt',
        nil, nil, FALSE, CREATE_NEW_CONSOLE, nil, nil, StartupInfo, ProcessInformation));
     
    // ждем пока наш процесс отработает
      WaitForSingleObject(ProcInfo.hProcess, INFINITE);
     
      Win32Check(CloseHandle(ProcInfo.hProcess);
    end;

Способ №2.1

    var
      ProcInfo: TProcessInformation;
      StartupInfo: TStartupInfo;
      hOut, hOutDup: THandle;
    begin
      // Создаем файл в который и будем переназначать StdOut
      // Например, с такими настройками, вы можете их изменить под свои нужды
      hOut := CreateFile('MyStdOut.txt', GENERIC_WRITE, 0, nil,
        CREATE_ALWAYS, FILE_ATTRIBUTE_NORMAL, 0);
      if (hOut = INVALID_HANDLE_VALUE) then
        RaiseLastWin32Error;
    end;
     

А вот в этом месте и происходит все самое важное!!! Необходимо сделать
рукоятку нашего файла НАСЛЕДУЕМОЙ, что и делаем...

     Win32Check(DuplicateHandle(GetCurrentProcess, hOut, 
       GetCurrentProcess, @hOutDup, 0, TRUE, DUPLICATE_SAME_ACCESS));

Небольшое замечание: следует отметить, что если вы пишите прогу ТОЛЬКО
под NT/2000, то сделать рукоятку наследуемой можно проще:

     Win32Check(SetHandleInformation (hOut, HANDLE_FLAG_INHERIT, 
       HANDLE_FLAG_INHERIT);

и не надо будет заводить дубликат рукоятки hOutDup

    // эта рукоятка нам уже не нужна, хотя вы можете ее
    // использовать для своих целей
    Win32Check(CloseHandle(hOut));
     
    GetStartupInfo(StartupInfo);
    with StartupInfo do
    begin
      wShowWindow := SW_HIDE; // не показывать окно
      dwFlags := dwFlags or STARTF_USESHOWWINDOW or STARTF_USESTDHANDLES;
      hStdOutput := hOutDup; // присваиваем рукоятку на свой файл
    end;

Для примера будем запускать [c:\\program
files\\Borland\\Delphi5\\Bin]grep.exe с ключом \'?\' Вызов
CreateProcess с флагом bInheritHandles = TRUE !!!

    Win32Check(CreateProcess(nil, 'grep.exe ?', nil, nil, TRUE,
      CREATE_NEW_CONSOLE, nil, nil, StartupInfo, ProcInfo));
     
    // ждем пока наш процесс отработает
    WaitForSingleObject(ProcInfo.hProcess, INFINITE);
     
    Win32Check(CloseHandle(ProcInfo.hProcess));
     
    // если вы больше ничего не хотите делать с файлом, в который
    // перенаправили StdOut, то закроем его
    Win32Check(CloseHandle(hOutDup));
    end;

Способ №2.2

Этот способ мне показал Юрий Зотов (поместив его в разделе "Обсуждение
статьи"), спасибо. Оказывается, рукоятку гораздо проще сделать
наследуемой, если использовать SECURITY\_ATTRIBUTES.

    var
      ProcInfo: TProcessInformation;
      StartupInfo: TStartupInfo;
      SecAtrtrs: TSecurityAttributes;
      hOut: THandle;
    begin
      with SecAtrtrs do
      begin
        nLength := SizeOf(TSecurityAttributes);
        lpSecurityDescriptor := nil;
        bInheritHandle := true; // ВОТ ОНО !!! Наша рукоятка будет НАСЛЕДУЕМОЙ
      end;
     
      // Создаем файл в который и будем переназначать StdOut
      // Например, с такими настройками, вы можете их изменить под свои нужды
      hOut := CreateFile('MyStdOut.txt', GENERIC_WRITE, 0, @SecAtrtrs,
        CREATE_ALWAYS, FILE_ATTRIBUTE_NORMAL, 0);
      if (hOut = INVALID_HANDLE_VALUE) then
        RaiseLastWin32Error;
     
      GetStartupInfo(StartupInfo);
      with StartupInfo do
      begin
        wShowWindow := SW_HIDE; // не показывать окно
        dwFlags := dwFlags or STARTF_USESHOWWINDOW or STARTF_USESTDHANDLES;
        hStdOutput := hOutDup; // присваиваем рукоятку на свой файл
      end;
     
      // для примера будем запускать
      // [c:\program files\Borland\Delphi5\Bin]grep.exe с ключом '?'
      // Вызов CreateProcess с флагом bInheritHandles = TRUE !!!
      Win32Check(CreateProcess(nil, 'grep.exe ?', nil, nil, TRUE,
        CREATE_NEW_CONSOLE, nil, nil, StartupInfo, ProcInfo));
     
      // ждем пока наш процесс отработает
      WaitForSingleObject(ProcInfo.hProcess, INFINITE);
     
      Win32Check(CloseHandle(ProcInfo.hProcess));
     
      // если вы больше ничего не хотите делать с файлом, в который
      // перенаправили StdOut, то закроем его
      Win32Check(CloseHandle(hOut));
    end;

Заключение

Первый способ проверялся мной под Win98 и Win2k Pro. Второй (обе
разновидности) только под Win2k Pro.

Оба способа служат одной и той же цели, но во втором случае программист
получает больше контроля над ситуацией. Вызовы Win32Check и
RaiseLastWin32Error добавляйте (убирайте) по своему вкусу.

Кстати, кто хочет узнать на эту тему больше - откройте Win32.hlp
(поставляется вместе с Делфой) и на закладке "Предметный указатель"
наберите "Creating a Child Process with Redirected Input and Output",
"Inheritance" и "SECURITY\_ATTRIBUTES" и ВНИМАТЕЛЬНО изучите. Изучив
эти (и смежные) разделы вы сможете переназначить StdOut, StdIn и StdErr
куда вам захочется.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
