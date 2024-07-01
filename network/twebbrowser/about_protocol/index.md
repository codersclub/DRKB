---
Title: Как использовать протокол about?
Date: 01.01.2007
Source: FAQ: <https://blackman.km.ru/myfaq/cont4.phtml>
---


Как использовать протокол about?
================================


_Перевод материала с сайта members.home.com/hfournier/webbrowser.htm_

    procedure TForm1.LoadHTMLString(sHTML: String);
    var
      Flags, TargetFrameName, PostData, Headers: OleVariant;
    begin
      WebBrowser1.Navigate('about:' + sHTML, Flags, TargetFrameName, PostData, Headers)
    end; 
