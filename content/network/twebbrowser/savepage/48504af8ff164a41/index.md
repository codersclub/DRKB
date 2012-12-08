---
Title: Как получить полный исходник HTML?
Author: Ron Loewy Обратите внимание: Вам понадобится импортировать
Date: 01.01.2007
---


Как получить полный исходник HTML?
==================================

::: {.date}
01.01.2007
:::

Взято из FAQ:<https://blackman.km.ru/myfaq/cont4.phtml>

Перевод материала с сайта members.home.com/hfournier/webbrowser.htm

В IE5, можно получить исходник используя свойство outerHTML тэгов

HTML. В IE4 или IE3, Вам понадобится записать документ в файл, а затем

загрузить файл в TMemo, TStrings, и т.д.

    var
      HTMLDocument: IHTMLDocument2;
      PersistFile: IPersistFile;
    begin
    ...
      HTMLDocument := WebBrowser1.Document as IHTMLDocument2;
      PersistFile := HTMLDocument as IPersistFile;
      PersistFile.Save(StringToOleStr('test.htm'), True); 
      while HTMLDocument.readyState < > 'complete' do
        Application.ProcessMessages;
    ...
    end;

Автор: Ron Loewy Обратите внимание: Вам понадобится импортировать
библиотеку

MSHTML и добавить MSHTML\_TLB как ActiveX, в секцию Uses.
