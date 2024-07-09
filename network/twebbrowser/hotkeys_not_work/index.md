---
Title: Не работают Ctrl-C, Ctrl-O, и т.д.
Date: 01.01.2007
Source: FAQ: <https://blackman.km.ru/myfaq/cont4.phtml>
---


Не работают Ctrl-C, Ctrl-O, и т.д.
=======================================================================


_Перевод материала с сайта members.home.com/hfournier/webbrowser.htm_

> Вопрос:
> Комбинации клавиш Ctrl-C, Ctrl-O, и т.д. не срабатывают. В чем проблема?

Это не ошибка. Информацию по данному вопросу можно найти на сайте
Microsoft KnowledgeBase статья Q168777.

Приведённый ниже код, устраняет данную проблему:

    ...
    var
      Form1: TForm1;
      FOleInPlaceActiveObject: IOleInPlaceActiveObject;
      SaveMessageHandler: TMessageEvent; 
    ... 
    implementation 
    ... 
     
    procedure TForm1.FormActivate(Sender: TObject);
    begin
      SaveMessageHandler := Application.OnMessage;
      Application.OnMessage := MyMessageHandler;
    end;
     
    procedure TForm1.FormDeactivate(Sender: TObject);
    begin
      Application.OnMessage := SaveMessageHandler;
    end; 
     
    procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);
    begin
      Application.OnMessage := SaveMessageHandler;
      FOleInPlaceActiveObject := nil;
    end; 
     
    procedure TForm1.MyMessageHandler(var Msg: TMsg; var Handled: Boolean);
    var
      iOIPAO: IOleInPlaceActiveObject;
      Dispatch: IDispatch;
    begin
      { exit if we do not get back a webbrowser object }
      if WebBrowser = nil then
      begin
        Handled := False;
        Exit;
      end;
      Handled:=(IsDialogMessage(WebBrowser.Handle, Msg) = True);
      if (Handled) and (not WebBrowser.Busy) then
      begin
        if FOleInPlaceActiveObject = nil then
        begin
          Dispatch := WebBrowser.Application;
          if Dispatch <> nil then
          begin
            Dispatch.QueryInterface(IOleInPlaceActiveObject, iOIPAO);
            if iOIPAO <> nil then
              FOleInPlaceActiveObject := iOIPAO;
          end;
        end;
        if FOleInPlaceActiveObject <> nil then
          if ((Msg.message = WM_KEYDOWN) or (Msg.message = WM_KEYUP)) and
             ((Msg.wParam = VK_BACK) or (Msg.wParam = VK_LEFT) or (Msg.wParam = VK_RIGHT)) then
             //nothing - do not pass on Backspace, Left or Right arrows
          else
            FOleInPlaceActiveObject.TranslateAccelerator(Msg);
      end;
    end;
