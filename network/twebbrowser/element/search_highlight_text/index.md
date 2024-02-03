---
Title: Как найти и выделить текст TWebBrowser?
Date: 01.01.2007
---


Как найти и выделить текст TWebBrowser?
=======================================

::: {.date}
01.01.2007
:::

    {....}
     
    private
      procedure SearchAndHighlightText(aText: string);
     
    {....}
     
    uses mshtml;
     
    { .... }
     
     
    procedure TForm1.SearchAndHighlightText(aText: string);
    var
      tr: IHTMLTxtRange; //TextRange Object
    begin
      if not WebBrowser1.Busy then
      begin
        tr := ((WebBrowser1.Document as IHTMLDocument2).body as IHTMLBodyElement).createTextRange;
        //Get a body with IHTMLDocument2 Interface and then a TextRang obj. with IHTMLBodyElement Intf.
     
        while tr.findText(aText, 1, 0) do //while we have result
        begin
          tr.pasteHTML('<span style="background-color: Lime; font-weight: bolder;">' +
            tr.htmlText + '</span>');
          //Set the highlight, now background color will be Lime
          tr.scrollIntoView(True);
          //When IE find a match, we ask to scroll the window... you dont need this...
        end;
      end;
    end;
     
    // Example:
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      SearchAndHighlightText('delphi');
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
