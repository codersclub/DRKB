---
Title: Как получить текст HTML-документа из TWebBrowser без тегов
Date: 01.01.2007
---


Как получить текст HTML-документа из TWebBrowser без тегов
==========================================================

::: {.date}
01.01.2007
:::

    uses mshtml, activex;
     
    procedure GetHtmlCode(WebBrowser: TWebBrowser; FileName: string);
    var
     htmlDoc: IHtmlDocument2;
     PersistFile: IPersistFile;
    begin
     htmlDoc := WebBrowser.document as IHtmlDocument2;
     PersistFile := HTMLDoc as IPersistFile;
     PersistFile.save(StringToOleStr(FileName), true);
    end;

Взято с <https://delphiworld.narod.ru>

------------------------------------------------------------------------

    var
      Document: IHTMLDocument2;
    begin
     Document := WB.Document as IHtmlDocument2;
     if Document < >  nil then
       Memo1.Text := (Document.all.Item(NULL, 0) as IHTMLElement).OuterHTML;

Взято с <https://delphiworld.narod.ru>
