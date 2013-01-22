---
Title: PChar -> Integer
Date: 01.01.2007
---


PChar -> Integer
================

::: {.date}
01.01.2007
:::

Many Windows functions claim to want PChar parameters in the
documentation, but they are defined as requiring LongInts.

Is this a bug?

No, this is where \"typecasting\" is used. Typecasting allows you to
fool the compiler into thinking that one type of variable is of another
type for the ultimate in flexibility. The last parameter of  the Windows
API function SendMessage() is a good example. It is

documented as requiring a long integer, but commonly requires a PChar
for some messages (WM\_WININICHANGE). Generally, the variable you are
typecasting from must be the same size as the variable type you are
casting it to. In the SendMessage example, you could typecast a PChar as
a longint, since both occupy 4 bytes of memory:

    var 
       s : array[0..64] of char; 
    begin 
      StrCopy(S, 'windows'); 
      SendMessage(HWND_BROADCAST, WM_WININICHANGE, 0, LongInt(@S)); 
    end; 
