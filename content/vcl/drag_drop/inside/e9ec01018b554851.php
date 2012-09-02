<h1>Drag &amp; Drop в TOutline</h1>
<div class="date">01.01.2007</div>

<p>Вам нужно перехватывать в TOutline сообщение wm_DropFiles. Для этого необходимо создать его потомка. Также, вы должны убедиться в том, что дескриптор TOutline Handle хотя бы раз передавался в качестве параметра функции DragAcceptFiles. Для определения положения мыши в момент перетаскивания используется DragQueryPoint. Если вы прочтете разделы в WINAPI.HLP по DragAcceptFiles, wm_DropFiles, DragQueryFile, DragQueryPoint и DragFinish, то вы поймете, как все это работает. </p>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>
<hr />
<p>Установите DragMode = dmManual, создайте OnMouseDownHandler, внутри обработчика осуществите вызов BeginDrag(False). BeginDrag(False) в действительности не начинает перемещение, пока пользователь не переместит объект больше, чем на 5 пикселей, так что если пользователь просто щелкнет на компоненте, операция перетаскивания даже не начнется. </p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>
<hr />
<p>Проблема заключается в том, что прежде, чем windows сможет обработать сообщение WM_MouseUp, курсор мыши передвинется дальше. Вот решение этой головоломки: </p>
<p>Разрешите Windows как можно скорее обработатывать события мыши:</p>
<pre>
OnMouseDown:
BeginDrag(False);
while ... do
begin
Application.ProccessMessages; { это позволяет Windows обработать }
{ все сообщения за один шаг }
end;
</pre>
<p>Комментарий: </p>
<p>Обратите пристальное внимание при создании цикла, если вы используете цикл типа 'while', то вы должны предусмотреть возможность выхода из него, например, при закрытии приложения, или других действий пользователя, требующих экстренного выхода из тела цикла. </p>
<p>Аналогично:</p>
<pre>
OnMouseDown:
BeginDrag(False);
Application.ProccessMessages;
while ... do
begin
{ единственный шаг обработки }
end;
</pre>
<p>Убедитесь в правильности работы кода. </p>
<p>Переместите вызов BeginDrag в обработчик события OmMouseMove. </p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>
&nbsp;</p>
<hr />
<p class="p_Heading1">Drag and Drop для двух компонентов TOutline </p>
<p class="author">Автор: Lloyd Linklater (Sysop) (Delphi Technical Support) </p>
<pre>
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
      if GetItem(x, y) &gt;= 0 then
        BeginDrag(False);
    end;
end;
 
procedure TForm1.OutlineDragOver(Sender, Source: TObject; X, Y: Integer;
 
  State: TDragState; var Accept: Boolean);
begin
 
  if (Source is TOutline) and (TOutline(Source).GetItem(x, y) &lt;&gt;
    TOutline(Source).SelectedItem) then
 
    Accept := True
  else
    Accept := False;
 
end;
 
end. 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>
&nbsp;</p>
