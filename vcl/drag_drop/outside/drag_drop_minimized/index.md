---
Title: Drag & Drop с минимизированным приложением
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Drag & Drop с минимизированным приложением
==========================================

В ситуации, когда ваше приложение минимизировано, необходимо понимать,
что окно главной формы НЕ работает. Фактически, если вы проверяете окно
главной формы, и обнаруживаете, что оно имеет прежний размер, не
удивляйтесь, оно просто невидимо. Иконка минимизированного
Delphi-приложения принадлежит объекту Application, чей дескриптор окна -
Application.Handle.

Вот некоторый код из моей программы, который с помощью компонента
CheckBox проверяет возможность принятия перетаскиваемых файлов
минимизированным приложением:

    procedure TForm1.WMDropFiles(var Msg: TWMDropFiles);
    {Вызывается только если TApplication НЕ получает drag/drop}
    begin
      RecordDragDrop(Msg.Drop, False); {внутренняя функция}
      Msg.Result := 0;
    end;
     
    procedure TForm1.AppOnMessage(var Msg: TMsg; var Handled: Boolean);
    {когда активно, получаем сообщения WM_DROPFILES, посылаемые
    форме ИЛИ минимизированному приложению}
    begin
      if Msg.message = WM_DROPFILES then
      begin
        RecordDragDrop(Msg.wParam, Msg.hWnd = Application.Handle);
        Handled := True;
      end;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      DragAcceptFiles(Handle, True);
      DragAcceptFiles(Application.Handle, False);
      Application.OnMessage := nil;
    end;

OK?
Первоначально вызов DragAcceptFiles работает с дескриптором главной
формы...



 
