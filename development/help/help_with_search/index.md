---
Title: Хелп с окошечком для поиска раздела
Author: Konstantin Kipa (kotya@extranet.ru)
Date: 01.01.2007
---


Хелп с окошечком для поиска раздела
===================================

    procedure TForm1.HelpSearchFor; 
    var 
      S : String; 
    begin 
      S := ''; 
      Application.HelpFile := 'C:\MYAPPPATH\MYHELP.HLP'; 
      Application.HelpCommand(HELP_PARTIALKEY, LongInt(@S)); 
    end; 

Konstantin Kipa  
2:5061/19.17  
kotya@extranet.ru
