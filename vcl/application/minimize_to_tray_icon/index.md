---
Title: Как приложение оставить свернутым в иконку?
Date: 01.01.2007
---


Как приложение оставить свернутым в иконку?
===========================================

Для этого необходимо обработать сообщение WMQUERYOPEN.

Однако обработчик
сообщения необходимо поместить в секции private - т.е. в объявлении
TForm.

    procedure WMQueryOpen(var Msg: TWMQueryOpen); message WM_QUERYOPEN; 
     
    Реализация будет выглядеть следующим образом:
     
    procedure WMQueryOpen(var Msg: TWMQueryOpen); 
    begin 
      Msg.Result := 0; 
    end;
