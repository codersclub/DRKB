---
Title: функции для изменения и получения чуствительности мышки
Author: Radmin
Date: 01.01.2007
---


функции для изменения и получения чуствительности мышки
=======================================================

::: {.date}
01.01.2007
:::

    Function SetMouseSpeed ( NewSpeed : Integer ) : Boolean;

     
    begin
     Result := SystemParametersInfo(SPI_SETMOUSESPEED, 1, Pointer(NewSpeed), SPIF_SENDCHANGE );
    End;
     
    Function GetMouseSpeed : Integer;
    Var
     Int : Integer;
    begin
     SystemParametersInfo(SPI_GETMOUSESPEED, 0, @Int, SPIF_SENDCHANGE );
     Result := Int;
    End;

Автор: Radmin

Взято с Vingrad.ru <https://forum.vingrad.ru>
