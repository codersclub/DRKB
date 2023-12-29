---
Title: Как получить активный URL из браузера?
Author: Ruslan Abu Zant
Date: 01.01.2007
---


Как получить активный URL из браузера?
======================================

::: {.date}
01.01.2007
:::

Автор: Ruslan Abu Zant

Приводимая здесь функция показывает, как Ваше приложение может извлечь
из браузера (IE или Netscape) URL, как, например, это делает аська.

Совместимость: Delphi 4.x (или выше)

Не забудьте добавить DDEMan в Ваш проект!

    uses windows, ddeman, ...... 
     
     
    function Get_URL(Servicio: string): String; 
    var 
       Cliente_DDE: TDDEClientConv; 
       temp:PChar;      //<<-------------------------This is new 
    begin 
        Result := ''; 
        Cliente_DDE:= TDDEClientConv.Create( nil ); 
         with Cliente_DDE do 
            begin 
               SetLink( Servicio,'WWW_GetWindowInfo'); 
               temp := RequestData('0xFFFFFFFF'); 
               Result := StrPas(temp); 
               StrDispose(temp);  //<<-Предотвращаем утечку памяти 
               CloseLink; 
            end; 
          Cliente_DDE.Free; 
    end; 
     
    procedure TForm1.Button1Click(Sender); 
    begin 
       showmessage(Get_URL('Netscape')); 
          или 
       showmessage(Get_URL('IExplore')); 
    end;

Взято из <https://forum.sources.ru>
