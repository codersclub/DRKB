---
Title: Просмотр буфера обмена
---


Просмотр буфера обмена
======================

Вариант 1:

Author: Sect, sect@mail.ru

Date: 16.06.2002

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Просмотр буфера обмена.
     
    Пример на основе простого модуля-класса, осуществляющего просмотр буфера обмена.
     
    Зависимости: clipboard
    Автор:       Sect, sect@mail.ru, Нижневартовск
    Copyright:   Советы по Delphi
    Дата:        16 июня 2002 г.
    ********************************************** }
     
    unit ClipboardViewer;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs;
     
    type
     
    TForm1 = class(TForm)
      procedure FormCreate(Sender: TObject);
      procedure FormDestroy(Sender: TObject);
      private
      FNextViewerHandle : THandle;
      procedure WMDrawClipboard (var message : TMessage);
      message WM_DRAWCLIPBOARD;
      procedure WMChangeCBCHain (var message : TMessage);
      message WM_CHANGECBCHAIN;
      public
    end; 

    var
      Form1: TForm1;
     
    implementation
    {$R *.DFM}
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      // Проверяем работоспособность функции.
      // При невозможности просмотра буфера обмена
      // функция возвратит значение Nil.
      FNextViewerHandle := SetClipboardViewer(Handle);
    end;
     
    procedure TForm1.FormDestroy(Sender: TObject);
    begin
      // Восстанавливаем цепочки.
      ChangeClipboardChain(Handle, FNextViewerHandle);
    end;
     
    procedure TForm1.WMDrawClipboard (var message : TMessage);
    begin
      // Вызывается при любом изменении содержимого буфера обмена
      message.Result := SendMessage(WM_DRAWCLIPBOARD, FNextViewerHandle, 0, 0);
    end;
     
    procedure TForm1.WMChangeCBCHain (var message : TMessage);
    begin
      // Вызывается при любом изменении цепочек буфера обмена.
      if message.wParam = FNextViewerHandle then begin
        // Удаляем следующую цепочку просмотра. Корректируем внутреннюю переменную.
        FNextViewerHandle := message.lParam;
        // Возвращаем 0 чтобы указать, что сообщение было обработано
        message.Result := 0;
      end else begin
        // Передаем сообщение следующему окну в цепочке.
        message.Result := SendMessage(FNextViewerHandle, WM_CHANGECBCHAIN,
        message.wParam, message.lParam);
      end;
    end;
     
     
    end.

------------------------------------------------------------------------

Вариант 2:

Author: Neil

Date: 01.01.2007

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Просмотр буфера обмена в Delphi совсем не сложен. Вот участок кода
программы, вешающий цепочки в буфере обмена и просто отображающий его
текст. Расположите компонент Memo на главной форме нового проекта,
присвойстве свойству Align значение alClient, добавьте необходимые
private-поля и методы и создайте их реализацию следующим образом:

    ...
    private
      { Private declarations }
      PrevHwnd: Hwnd;
     
      procedure WMChangeCBChain(var Msg: TWMChangeCBChain);
        message WM_CHANGECBCHAIN;
     
      procedure WMDrawClipboard(var Msg: TWMDrawClipboard);
        message WM_DRAWCLIPBOARD;
    ...
     
    procedure TForm1.WMChangeCBChain(var Msg: TWMChangeCBChain);
    begin
      if PrevHWnd = Msg.Remove then
        PrevHWnd := Msg.Next;
      if Msg.Remove <> Handle then
        SendMessage(PrevHWnd, WM_CHANGECBCHAIN, Msg.Remove, Msg.Next);
    end;
     
    procedure TForm1.WMDrawClipboard(var Msg: TWMDrawClipboard);
    var
      P: PChar;
      H: THandle;
    begin
      SendMessage(PrevHWnd, WM_DRAWCLIPBOARD, 0, 0);
      if Clipboard.HasFormat(CF_TEXT) then
      begin
        H := Clipboard.GetAsHandle(CF_TEXT);
        Len := GlobalSize(H) + 1;
        P := GlobalLock(H);
        Memo1.SetTextBuf(P);
        GlobalUnlock(H);
      end;
      Msg.Result := 0;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      PrevHwnd := SetClipboardViewer(Handle);
    end;
     
    procedure TForm1.FormDestroy(Sender: TObject);
    begin
      ChangeClipboardChain(Handle, PrevHwnd);
    end;

Обращаю ваше внимание на то, что у меня не было никакой конкретной идеи
прежде, чем я это сделал; я просто внимательно прочел файлы помощи по
SetClipboardViewer и во всех связанных темах.

