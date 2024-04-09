---
Title: Пример вызова хранимой процедуры c передачей переменной
Author: Vit
Date: 01.01.2007
---


Пример вызова хранимой процедуры c передачей переменной
=======================================================

    Declare @MyVariable varchar(50)
     
    Set @MyVariable='dir'
     
    Exec master..xp_cmdshell @MyVariable
