---
Title: Как загрузить строковые данные в TWebBrowser, не прибегая к открытию файла?
Date: 01.01.2007
---


Как загрузить строковые данные в TWebBrowser, не прибегая к открытию файла?
===========================================================================

::: {.date}
01.01.2007
:::

Взято из FAQ:<https://blackman.km.ru/myfaq/cont4.phtml>

Перевод материала с сайта members.home.com/hfournier/webbrowser.htm

Загрузите строку массив Variant, а затем запишите в документ (Document):

    ...
    var
      v: Variant;
      HTMLDocument: IHTMLDocument2;
    begin
      HTMLDocument := WebBrowser1.Document as IHTMLDocument2;
      v := VarArrayCreate([0, 0], varVariant);
      v[0] := HTMLString; // Это Ваша HTML строка
      HTMLDocument.Write(PSafeArray(TVarData(v).VArray));
      HTMLDocument.Close; ...
    end;
    ...
