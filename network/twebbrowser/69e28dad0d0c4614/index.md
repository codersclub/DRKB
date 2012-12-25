---
Title: Добавить HTML к TWebBrowser Document
Date: 01.01.2007
---


Добавить HTML к TWebBrowser Document
====================================

::: {.date}
01.01.2007
:::

    uses
      MSHTML;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      Range: IHTMLTxtRange;
    begin
      Range := ((WebBrowser1.Document as IHTMLDocument2).body as
        IHTMLBodyElement).createTextRange;
      Range.collapse(False);
      Range.pasteHTML('<br><b>Hello!</b>');
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      Webbrowser1.Navigate('www.google.ch');
    end;

    unit Unit1;
    // by Sprint
     
    interface
     
     
    uses
      Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
      Dialogs, OleCtrls, SHDocVw, MSHTML, StdCtrls;
     
     
    type
      TForm1 = class(TForm)
        WebBrowser1: TWebBrowser;
        procedure FormCreate(Sender: TObject);
        procedure WebBrowser1DocumentComplete(Sender: TObject;
          const pDisp: IDispatch; var URL: OleVariant);
      private
        { Private-Deklarationen }
        FirstRun: Boolean;
      public
        { Public-Deklarationen }
      end;
     
     
    var
      Form1: TForm1;
     
     
    implementation
     
     
    {$R *.dfm}
    {----------------------------------------------------------------}
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      FirstRun := True;
      WebBrowser1.Navigate('about:blank');
    end;
     
    {----------------------------------------------------------------}
     
     
    procedure TForm1.WebBrowser1DocumentComplete(Sender: TObject;
      const pDisp: IDispatch; var URL: OleVariant);
    var
      WebDoc: HTMLDocument;
      WebBody: HTMLBody;
    begin
      if FirstRun then
        if pDisp = WebBrowser1.Application then
        begin
          FirstRun := False;
          WebDoc := WebBrowser1.Document as HTMLDocument;
          WebBody := WebDoc.body as HTMLBody;
          WebBody.insertAdjacentHTML('BeforeEnd', '<h1>Hello World!</h1>');
        end;
    end;
     
    {----------------------------------------------------------------}
     
    end.

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
