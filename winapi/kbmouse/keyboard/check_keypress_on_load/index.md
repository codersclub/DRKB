---
Title: Как определить нажатие определенной клавиши во время загрузки приложения?
Date: 01.01.2007
---


Как определить нажатие определенной клавиши во время загрузки приложения?
=========================================================================

::: {.date}
01.01.2007
:::

Используйту WinAPI функцию GetKeyState() для определения нажатия клавиши
в тексте проекта. Для того чтобы увидеть текст файла проекта в главном
меню Delphi 3 выберите \"View\"\>\>\"ProjectSource\" в Delphi 4
\"Project\"\>\>\"View Source\".

 

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
