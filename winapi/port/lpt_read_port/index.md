---
Title: Как прочитать байт из параллельного порта?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как прочитать байт из параллельного порта?
==========================================

Первый способ:

    Var 
        BytesRead : BYTE; 
    begin 
        asm                { Читаем порт (LPT1) через встроенный ассемблер } 
          MOV dx,$379; 
          IN  al,dx; 
          MOV BytesRead,al; 
        end; 
    BytesRead:=(BytesRead OR $07);   { OR а затем XOR данных } 
    BytesRead:=(BytesRead XOR $80);  { маскируем неиспользуемые биты } 

Второй способ :

Используем команды Turbo Pascal ...

      value:=port[$379]; { Прочитать из порта } 
      port[$379]:=value; { Записать в порт }

