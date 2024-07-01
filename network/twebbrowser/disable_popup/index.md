---
Title: Как запретить всплывающее меню при нажатии правой кнопки мыши?
Date: 01.01.2007
Source: FAQ: <https://blackman.km.ru/myfaq/cont4.phtml>
---


Как запретить всплывающее меню при нажатии правой кнопки мыши?
==============================================================


_Перевод материала с сайта members.home.com/hfournier/webbrowser.htm_

Вам необходимо включить интерфейс IDocHostUIHandler.

Для этого Вам понадобятся два файла: ieConst.pas и
IEDocHostUIHandler.pas.

В методе ShowContextMenu интерфейса IDocHostUIHandler,
необходимо изменить возвращаемое значение с E\_NOTIMPL на S\_OK.

После этого меню перестанет реагировать на правое нажатие кнопки мыши.

Добавьте два модуля, упомянутые выше, в секцию Uses и добавьте следующий
код:

    ...
    var
      Form1: TForm1;
      FDocHostUIHandler: TDocHostUIHandler;
    ... 
    implementation
    ... 
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      FDocHostUIHandler := TDocHostUIHandler.Create;
    end; 
     
    procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);
    begin
      FDocHostUIHandler.Free;
    end; 
    procedure TForm1.WebBrowser1NavigateComplete2(Sender: TObject;
      pDisp: IDispatch; var URL: OleVariant);
    var
      hr: HResult;
      CustDoc: ICustomDoc;
    begin
      hr := WebBrowser1.Document.QueryInterface(ICustomDoc, CustDoc);
      if hr = S_OK then CustDoc.SetUIHandler(FDocHostUIHandler);
    end;
