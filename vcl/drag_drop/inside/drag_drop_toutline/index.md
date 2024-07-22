---
Title: Drag & Drop в TOutline
Date: 01.01.2007
---


Drag & Drop в TOutline
======================

Вариант 1:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Вам нужно перехватывать в TOutline сообщение wm\_DropFiles. Для этого
необходимо создать его потомка. Также, вы должны убедиться в том, что
дескриптор TOutline Handle хотя бы раз передавался в качестве параметра
функции DragAcceptFiles. Для определения положения мыши в момент
перетаскивания используется DragQueryPoint. Если вы прочтете разделы в
WINAPI.HLP по DragAcceptFiles, wm\_DropFiles, DragQueryFile,
DragQueryPoint и DragFinish, то вы поймете, как все это работает.

------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Установите DragMode = dmManual, создайте OnMouseDownHandler, внутри
обработчика осуществите вызов BeginDrag(False). BeginDrag(False) в
действительности не начинает перемещение, пока пользователь не
переместит объект больше, чем на 5 пикселей, так что если пользователь
просто щелкнет на компоненте, операция перетаскивания даже не начнется.


------------------------------------------------------------------------

Вариант 3:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Проблема заключается в том, что прежде, чем windows сможет обработать
сообщение WM\_MouseUp, курсор мыши передвинется дальше. Вот решение этой
головоломки:

Разрешите Windows как можно скорее обработатывать события мыши:

    OnMouseDown:
    BeginDrag(False);
    while ... do
    begin
    Application.ProccessMessages; { это позволяет Windows обработать }
    { все сообщения за один шаг }
    end;

**Комментарий:**

Обратите пристальное внимание при создании цикла, если вы используете
цикл типа "while", то вы должны предусмотреть возможность выхода из
него, например, при закрытии приложения, или других действий
пользователя, требующих экстренного выхода из тела цикла.

Аналогично:

    OnMouseDown:
    BeginDrag(False);
    Application.ProccessMessages;
    while ... do
    begin
    { единственный шаг обработки }
    end;

Убедитесь в правильности работы кода.

Переместите вызов BeginDrag в обработчик события OmMouseMove.

------------------------------------------------------------------------

Вариант 4:

Author: Lloyd Linklater (Sysop) (Delphi Technical Support)

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Drag and Drop для двух компонентов TOutline


    unit Unit1;
     
    interface
     
    uses
     
      SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
      Forms, Dialogs, Grids, Outline;
     
    type
     
      TForm1 = class(TForm)
        Outline1: TOutline;
        Outline2: TOutline;
        procedure OutlineDragDrop(Sender, Source: TObject; X, Y: Integer);
        procedure OutlineMouseDown(Sender: TObject; Button: TMouseButton;
          Shift: TShiftState; X, Y: Integer);
        procedure OutlineDragOver(Sender, Source: TObject; X, Y: Integer;
     
          State: TDragState; var Accept: Boolean);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
     
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.OutlineDragDrop(Sender, Source: TObject; X, Y: Integer);
    begin
     
      with Sender as TOutline do
      begin
        AddChild(GetItem(x, y),
          TOutline(Source).Items[TOutline(Source).SelectedItem].Text);
      end;
     
    end;
     
    procedure TForm1.OutlineMouseDown(Sender: TObject; Button: TMouseButton;
     
      Shift: TShiftState; X, Y: Integer);
    begin
     
      if Button = mbLeft then
        with Sender as TOutline do
        begin
          if GetItem(x, y) >= 0 then
            BeginDrag(False);
        end;
    end;
     
    procedure TForm1.OutlineDragOver(Sender, Source: TObject; X, Y: Integer;
     
      State: TDragState; var Accept: Boolean);
    begin
     
      if (Source is TOutline) and (TOutline(Source).GetItem(x, y) <>
        TOutline(Source).SelectedItem) then
     
        Accept := True
      else
        Accept := False;
     
    end;
     
    end. 

