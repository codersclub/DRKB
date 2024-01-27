---
Title: Как закрыть Excel
Author: Akella
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Как закрыть Excel
=================

    try
      Ex1.Workbooks.Close(LOCALE_USER_DEFAULT);
      Ex1.Disconnect;
      Ex1.Quit;
      Ex1:=nil;
     except
     end;

