---
Title: Определение нажатия определенной клавиши во время загрузки приложения
Date: 01.01.2007
---


Определение нажатия определенной клавиши во время загрузки приложения
=====================================================================

Вариант 1:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Используйте WinAPI функцию GetKeyState() для определения нажатия клавиши
в тексте проекта.

Для того чтобы увидеть текст файла проекта в главном
меню Delphi 3 выберите "View" -> "ProjectSource",
а в Delphi 4 "Project" -> "View Source".

    program Project1;
     
    uses
      Windows,
      Forms,
      Unit1 in 'Unit1.pas' {Form1};
     
    {$R *.RES}
     
    begin
      if GetKeyState(vk_F8) < 1 then
        MessageBox(0, 'F8 was pressed during startup', 'MyApp', mb_ok);
      Application.Initialize;
      Application.CreateForm(TForm1, Form1);
      Application.Run;
    end.

------------------------------------------------------------------------
Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    program Project1; 
     
    uses 
      Forms, 
      Windows, 
      Dialogs, 
      Unit1 in 'Unit1.pas' {Form1}; 
     
    var 
      KeyState: TKeyBoardState; 
     
    {$R *.RES} 
     
    begin 
      Application.Initialize; 
      GetKeyboardState(KeyState); 
      if ((KeyState[vk_Shift] and 128) <> 0) then 
      begin 
        { here you could put some code to show the app as tray icon, ie 
     
         hier kann z.B ein Code eingefugt werden, um die Applikation als 
         Tray Icon anzuzeigen} 
      end; 
      Application.CreateForm(TForm1, Form1); 
      Application.Run; 
    end.


