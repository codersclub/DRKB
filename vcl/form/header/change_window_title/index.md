---
Title: Изменяем заголовок окна
Author: Christian Cristofori
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Изменяем заголовок окна
=======================

В примере показывается, как изменять заголовок окна (видимый в списке
задач при переключении между приложениями) при минимизации окна в
иконку.

Сперва необходимо определить сообщение поумолчанию:

    const 
      DefMsgNorm = 'MyApp version 1.0'; 
      DefMsgIcon = 'MyApp. (Use F12 to turn of)'; 

И добавить две глобальных переменных:

    var 
      ActMsgNorm : String; 
      ActMsgIcon : String; 

Затем при открытии основной формы инициализируем переменные из констант.

    procedure TFormMain.FormCreate( Sender : TObject ); 
    begin 
      ActMsgNorm := DefMsgNorm; 
      ActMsgIcon := DefMsgIcon; 
      Application.Title := ActMsgNorm; 
    end;

Затем достаточно в обработчик OnResize добавить следующий код:

    procedure TFormMain.FormResize( Sender : TObject ); 
    begin 
      if ( FormMain.WindowState = wsMinimized ) then 
        Application.Title := ActMsgIcon 
      else 
        Application.Title := ActMsgNorm; 
    end; 

