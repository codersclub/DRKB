---
Title: How to add alternative text to a Webbrowser image?
Date: 01.01.2007
---


How to add alternative text to a Webbrowser image?
==================================================

::: {.date}
01.01.2007
:::

    { Alternative Text for a image of a TWebBrowser }
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      HTMLDocument2Ifc: IHTMLDocument2;
      HTMLSelectionObjectIfc: IHTMLSelectionObject;
      HTMLTxtRangeIfc: IHTMLTxtRange;
    begin
      HTMLDocument2Ifc := WebBrowser1.Document as IHTMLDocument2;
      HTMLDocument2Ifc.execCommand('InsertImage', False, '');
      HTMLSelectionObjectIfc := HTMLDocument2Ifc.selection;
      if HTMLSelectionObjectIfc.type_ = 'Control' then HTMLSelectionObjectIfc.Clear;
      HTMLTxtRangeIfc := HTMLSelectionObjectIfc.createRange as IHTMLTxtRange;
      HTMLTxtRangeIfc.pasteHTML('<image alt="Hello" src="c:\test.gif"> ');
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
