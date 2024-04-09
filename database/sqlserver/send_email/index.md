---
Title: Послать E-mail
Author: Vit
Date: 01.01.2007
---


Послать E-mail
==============

    Exec master.dbo.xp_sendmail 
      @recipients='nevzorov@yahoo.com', 
      @Subject='MS SQL Test',
      @message='This is email body!'
