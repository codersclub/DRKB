---
Title: Определение нажатия определенной клавиши во время загрузки приложения
Date: 01.01.2007
---


Определение нажатия определенной клавиши во время загрузки приложения
=====================================================================

::: {.date}
01.01.2007
:::

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

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 

------------------------------------------------------------------------

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

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
