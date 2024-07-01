---
Title: Как перевести TWebBrowser в режим редактирования (дизайна)?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как перевести TWebBrowser в режим редактирования (дизайна)?
===========================================================

    {
      You can use the designMode property to put the Webbrowser
      into a mode where you can edit the current document.
    }
     
    uses
      MSHTML_TLB;
     
    procedure TForm1.WebBrowser1DocumentComplete(Sender: TObject;
      const pDisp: IDispatch; var URL: OleVariant);
    var
      CurrentWB: IWebBrowser;
    begin
      CurrentWB := pDisp as IWebBrowser;
      (CurrentWB.Document as IHTMLDocument2).DesignMode := 'On';
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      WebBrowser1.Navigate('http://wp.netscape.com/assist/net_sites/example1-F.html')
    end;

