---
Title: Реагируем на щелчок по ссылке в TWebBrowser
Author: Rouse\_
Date: 01.01.2007
---


Реагируем на щелчок по ссылке в TWebBrowser
===========================================

::: {.date}
01.01.2007
:::


     
     
    var
      Document: IHtmlDocument2;
      V: Variant;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      WebBrowser1.Navigate('about:blank');
      while WebBrowser1.Document = nil do
        Application.ProcessMessages;
      Document := WebBrowser1.Document as IHtmlDocument2;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      V[0] :='<a href="https://ya.ru">Run</a>';
      Document.Writeln(PSafeArray(TVarData(v).VArray));
      WebBrowser1.OleObject.Document.ParentWindow.Scroll(0, 10000000);
    end;
     
    procedure TForm1.WebBrowser1BeforeNavigate2(Sender: TObject;
      const pDisp: IDispatch; var URL, Flags, TargetFrameName, PostData,
      Headers: OleVariant; var Cancel: WordBool);
    begin
      if url <> 'about:blank' then
      begin
        WebBrowser2.Navigate(URL);
        Cancel := True;
      end;
    end;

Автор: Rouse\_

Взято из <https://forum.sources.ru>

 \

------------------------------------------------------------------------


     
    var
      NavigateTo: Boolean = False;
     
    procedure TForm1.WebBrowser1BeforeNavigate2(Sender: TObject;
      const pDisp: IDispatch; var URL, Flags, TargetFrameName, PostData,
      Headers: OleVariant; var Cancel: WordBool);
    begin
      if NavigateTo then
      begin
        Cancel := True;
        WebBrowser2.Navigate(URL);
      end;
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      WebBrowser1.Navigate('about:<a href="https://ya.ru">Run</a>');
      NavigateTo := True;
    end;

Автор: s-mike

Взято из <https://forum.sources.ru>

 \

------------------------------------------------------------------------

OnNewWindow2\
Возникает при попытке открыть документ в новом окне. Если Вы хотите,
чтобы документ был открыт в Вашем экземпляре броузера, то Вам нужно
создать свой экземпляр броузера и параметру ppDisp присвоить
интерфейсную ссылку на этот экземпляр:\

 

    procedure TFormSimpleWB.WebBrowser1NewWindow2(Sender: TObject;
      var ppDisp: IDispatch; var Cancel: WordBool);
    var 
      newForm:TFormSimpleWB;
    begin 
      newForm := TFormSimpleWB.Create(Application);
      newForm.Show;
      ppDisp := newForm.WebBrowser1.ControlInterface;
    end;

 \

Автор: -TOXA-

Взято из <https://forum.sources.ru>\

 
