---
Title: Как прочитать базу данных с Досовским шрифтом
Date: 01.01.2007
---


Как прочитать базу данных с Досовским шрифтом
=============================================

::: {.date}
01.01.2007
:::

При старте приложения попробуй вызвать вот такую процедуру:

 

    procedure SetLangForParadoxAndDBase;
    var
      p :TStringList;
      c :TConfigMode;
    begin
      p := TStringList.Create;
      c := Session.ConfigMode; Session.ConfigMode := cmSession;
      try
        p.Text := 'LANGDRIVER=ancyrr'^M^J'LEVEL=7';
        Session.ModifyDriver('PARADOX',p);
        p.Text := 'LANGDRIVER=db866ru0'^M^J'LEVEL=7';
        Session.ModifyDriver('DBASE',p);
      finally
        Session.ConfigMode := c;
        p.Free;
      end;
    end;

Взято с Vingrad.ru <https://forum.vingrad.ru>
