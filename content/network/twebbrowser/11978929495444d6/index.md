---
Title: Как проверить является ли текущее соединение в TWebBrowser secure (SSL)?
Date: 01.01.2007
---


Как проверить является ли текущее соединение в TWebBrowser secure (SSL)?
========================================================================

::: {.date}
01.01.2007
:::

    // You need a TWebbrowser, a TLabel 
     
    procedure TForm1.WebBrowser1DocumentComplete(Sender: TObject; 
      const pDisp: IDispatch; var URL: OleVariant); 
    begin 
      if Webbrowser1.Oleobject.Document.Location.Protocol = 'https:' then 
        label1.Caption := 'Sichere Verbindung' 
      else 
        label1.Caption := 'Unsichere Verbindung' 
    end; 

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
