---
Title: Как показать окно свойств экрана?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как показать окно свойств экрана?
=================================

> Как пpогpаммно вывести окно свойств экpана?

Вариант 1:

Author: Nomadic

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    ShellExecute(Application.Handle, 'open', 'desk.cpl', nil, nil, sw_ShowNormal); 



------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Для этого воспользуемся \'Rundll32.exe\' и запустим её в
\'shellexecute\'. Не забудьте добавить \'shellapi\' в Ваш список uses.

    //getsystemdir это функция, которая совместима со всеми версиями Windows.
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
      ShellExecute(Form11.Handle, 'open', Pchar('rundll32.exe'),
        'shell32.dll,Control_RunDLL Desk.cpl,@0,3', Pchar(X), SW_normal);
    end;


