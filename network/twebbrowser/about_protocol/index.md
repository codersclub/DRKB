---
Title: Как использовать протокол about?
Date: 01.01.2007
---


Как использовать протокол about?
================================

::: {.date}
01.01.2007
:::

Взято из FAQ: <https://blackman.km.ru/myfaq/cont4.phtml>

Перевод материала с сайта members.home.com/hfournier/webbrowser.htm

    procedure TForm1.LoadHTMLString(sHTML: String);
    var
      Flags, TargetFrameName, PostData, Headers: OleVariant;
    begin
      WebBrowser1.Navigate('about:' + sHTML, Flags, TargetFrameName, PostData, Headers)
    end; 
