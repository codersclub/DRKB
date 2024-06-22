---
Title: Как добавить cookie?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как добавить cookie?
====================

Пример демонстрирует создание cookie посредствам стандартного компонента
Delphi

    procedure TwebDispatcher.WebAction(Sender: TObject; Request: TWebRequest; 
      Response: TWebResponse; var Handled: Boolean); 
    begin 
        with (Response.Cookies.Add) do begin 
          Name := 'TESTNAME'; 
          Value := 'TESTVALUE'; 
          Secure := False; 
          Expires := Now; 
          Response.Cookies.WebResponse.SendResponse; 
        end; 
    end; 

