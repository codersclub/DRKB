---
Title: RadioButtons in a TWebbrowser
Date: 01.01.2007
---


RadioButtons in a TWebbrowser
=============================

::: {.date}
01.01.2007
:::

    procedure TForm1.Button1Click(Sender: TObject);
    var
      Document: IHTMLDocument2;
      rbTestList: IHTMLElementCollection;
      rbTest: IHTMLOptionButtonElement;
      I: Integer;
    begin
      // Get a reference to the document
      Document := WebBrowser1.Document as IHTMLDocument2;
     
      // Get a reference to input-control (Radiobutton)
      rbTestList := Document.all.item('rating', EmptyParam) as IHTMLElementCollection;
     
      // Get current values.
      for I := 0 to rbTestList.Length - 1 do
      begin
        // reference to the i. RadioButton
        rbTest := rbTestList.item(I, EmptyParam) as IHTMLOptionButtonElement;
     
        // Show a message if radiobutton is checked
        if rbTest.Checked then
          ShowMessageFmt('Der RadioButton mit dem Wert %s' +
            ' ist ausgewahlt!', [rbTest.Value]);
      end;
     
      // Set new values
      for I := 0 to rbTestList.Length - 1 do
      begin
        // reference to the i. RadioButton
        rbTest := rbTestList.item(I, EmptyParam) as IHTMLOptionButtonElement;
     
        // check radiobutton with value 3.
        if rbTest.Value = '3' then
          rbTest.Checked := True;
      end;
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
