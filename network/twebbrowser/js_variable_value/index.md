---
Title: Читать значения переменных из JavaScript?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Читать значения переменных из JavaScript?
=========================================

    // Just add a Webbrowser and two Buttons to the form and insert the following code
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      webbrowser1.Navigate('http://www.dasbinich.info/myred/delphi/index.html');
    end;
     
    procedure TForm1.WebBrowser1DocumentComplete(Sender: TObject;
      const pDisp: IDispatch; var URL: OleVariant);
    begin
      if (url = 'http://www.dasbinich.info/myred/delphi/index.html') then
        ShowMessage('Value lautet: ' + webBrowser1.OleObject.Document.Forms.item
        ('test').Elements.item('testen').Value);
      //read the Javascript value testen of the form test
    end;
     
    //this is an example how to use it when there are no names
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      ShowMessage('Value lautet: ' + webBrowser1.OleObject.Document.Forms.item
      (0).Elements.item(0).Value);
    end;
     
     
    //to read the javascript value from a site with a frame use the following
    webBrowser1.OleObject.Document.Frames.item('top').Document.Forms.item
    ('Countdown').Elements.item('Countdown').Value;
    //top is the framename in this example

