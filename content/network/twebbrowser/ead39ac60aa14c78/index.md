---
Title: Create a TWebBrowser at runtime?
Date: 01.01.2007
---


Create a TWebBrowser at runtime?
================================

::: {.date}
01.01.2007
:::

    procedure TForm1.Button1Click(Sender: TObject);
    var
     wb: TWebBrowser;
    begin
      wb := TWebBrowser.Create(Form1);
      TWinControl(wb).Name := 'MyWebBrowser';
      TWinControl(wb).Parent := Form1;
      wb.Align := alClient;
      // TWinControl(wb).Parent := TabSheet1; ( To put it on a TabSheet )
      wb.Navigate('http://www.swissdelphicenter.ch');
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
