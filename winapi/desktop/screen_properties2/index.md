---
Title: Как пpогpаммно вывести окно свойств экpана?
Author: Nomadic
Date: 01.01.2007
---


Как пpогpаммно вывести окно свойств экpана?
===========================================

::: {.date}
01.01.2007
:::

Автор: Nomadic

    ShellExecute(Application.Handle, 'open', 'desk.cpl', nil, nil, sw_ShowNormal); 

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

Для этого воспользуемся \'Rundll32.exe\' и запустим её в
\'shellexecute\'. Не забудьте добавить \'shellapi\' в Ваш список uses.

    //Эта функция совместима со всеми версиями Windows
    function GetSystemDir: TFileName;
    var
      SysDir: array [0..MAX_PATH-1] of char;
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

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
