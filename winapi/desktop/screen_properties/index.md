---
Title: Как показать окно свойств экрана?
Date: 01.01.2007
---


Как показать окно свойств экрана?
=================================

::: {.date}
01.01.2007
:::

Для этого воспользуемся \'Rundll32.exe\' и запустим её в
\'shellexecute\'. Не забудьте добавить \'shellapi\' в Ваш список uses.

    function GetSystemDir: TFileName;
    var
      SysDir: array[0..MAX_PATH - 1] of char;
    begin
      SetString(Result, SysDir, GetSystemDirectory(SysDir, MAX_PATH));
      if Result = '' then
        raise Exception.Create(SysErrorMessage(GetLastError));
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      x: Tfilename;
    begin
      x := getsystemdir;
      ShellExecute(Form11.Handle, 'open', Pchar('rundll32.exe'), 'shell32.dll,Control_RunDLL Desk.cpl,@0,3', Pchar(X), SW_normal);
    end;
     
    //getsystemdir это функция, которая совместима со всеми версиями windows.

Взято из <https://forum.sources.ru>
