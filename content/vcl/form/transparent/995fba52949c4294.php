<h1>Прозрачная форма, не реагирующая на мышь?</h1>
<div class="date">01.01.2007</div>


<pre>
unit transpar_frm;

interface
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
  StdCtrls;
type
  TForm1 = class(TForm)
    Button1: TButton;
    Button2: TButton;
    CheckBox1: TCheckBox;
    // это просто кнопки на форме - для демонстрации
  protected
    procedure RebuildWindowRgn;
    procedure Resize; override;
  public
    constructor Create(AOwner: TComponent); override;
  end;
var
  Form1 : TForm1;
implementation
 
{$R *.DFM}
{ Прозрачная форма }
constructor TForm1.Create(AOwner: TComponent);
begin
  inherited;
  // StayOnTop в принципе можно убрать
  FormStyle:=fsStayOnTop;
  // убираем скроллбары, чтобы не мешались
  // при изменении размеров формы
  HorzScrollBar.Visible:= False;
  VertScrollBar.Visible:= False;
  // строим новый регион
  RebuildWindowRgn;
end;
procedure TForm1.Resize;
begin
  inherited;
  // строим новый регион
  RebuildWindowRgn;
end;
procedure TForm1.RebuildWindowRgn;
var
  FullRgn, Rgn: THandle;
  ClientX, ClientY, I: Integer;
begin
  // определяем относительные координаты клиенской части
  ClientX:= (Width - ClientWidth) div 2;
  ClientY:= Height - ClientHeight - ClientX;
  // создаем регион для всей формы
  FullRgn:= CreateRectRgn(0, 0, Width, Height);
  // создаем регион для клиентской части формы
  // и вычитаем его из FullRgn
  Rgn:= CreateRectRgn(ClientX, ClientY, ClientX + ClientWidth, ClientY +
ClientHeight);
  CombineRgn(FullRgn, FullRgn, Rgn, rgn_Diff);
  // теперь добавляем к FullRgn регионы каждого контрольного элемента
  for I:= 0 to ControlCount -1 do
    with Controls[I] do begin
      Rgn:= CreateRectRgn(ClientX + Left, ClientY + Top, ClientX + Left +
Width, ClientY + Top + Height);
      CombineRgn(FullRgn, FullRgn, Rgn, rgn_Or);
    end;
  // устанавливаем новый регион окна
  SetWindowRgn(Handle, FullRgn, True);
end;
end.
</pre>
<p class="author">Автор: Krid </p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<hr />
<pre>
type

  TForm1 = class(TForm)
    procedure FormCreate(Sender: TObject);
  protected
    procedure CreateParams (var Params: TCreateParams); override;
  end;
 
var
  Form1: TForm1;
 
implementation
 
...
 
procedure TForm1.FormCreate(Sender: TObject);
begin
  SetWindowLong(Handle, GWL_EXSTYLE, GetWindowLong(Handle, GWL_EXSTYLE) or WS_EX_LAYERED);
  SetLayeredWindowAttributes(Handle, 0, Byte(196), 2);
end;
 
procedure TForm1.CreateParams(var Params: TCreateParams);
begin
  inherited CreateParams (Params);
  Params.ExStyle := Params.ExStyle or
    WS_EX_TRANSPARENT;
end;
</pre>
<p class="author">Автор:&nbsp; Smike</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<hr /><p>Вместо перекрытия CreateParams():<br>
<p>Сделать "прозрачным" для мышки: </p>
<pre>
setWindowLong(Handle, GWL_EXSTYLE, GetWindowLong(Handle, GWL_EXSTYLE) or WS_EX_TRANSPARENT);
</pre>
<p>Сделать обратно нормальным: </p>
<pre>
setWindowLong(Handle, GWL_EXSTYLE, GetWindowLong(Handle, GWL_EXSTYLE) and not WS_EX_TRANSPARENT);
</pre>
<p>&nbsp;<br>
<p class="author">Автор:&nbsp; Vitalik</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<hr /><p>Еще одно хорошее решение. Его преимущество в том, что работать оно будет на всех системах, включая Win9x.<br>
<p>&nbsp;</p>
<pre>
procedure TForm1.HandleMessage(var Msg: tagMSG;var Handled: Boolean);
Var
  P:TPoint;
  S,R:HRGN;
begin
  Inherited;
  Case Msg.message Of
    WM_MOUSEFIRST..WM_MOUSELAST:
    Begin
      P.X:=ScreenToClient(Msg.pt).X+ClientOrigin.X-Left;
      P.Y:=ScreenToClient(Msg.pt).Y+ClientOrigin.Y-Top;
      R:=CreateRectRgn(P.X,P.Y,P.X+1,P.Y+1);
      S:=CreateRectRgn(0,0,Width,Height);
      CombineRgn(S,S,R,RGN_XOR);
      SetWindowRgn(Handle,S,True);
      SendMessage(WindowFromPoint(Msg.pt),Msg.message,Msg.wParam,Msg.lParam);
      DeleteObject(R);
      DeleteObject(S);
      Handled:=True;
    End;
  End;
end;
 
procedure TForm1.FormCreate(Sender: TObject);
begin
  Application.OnMessage:=HandleMessage;
end;
</pre>
<p>&nbsp;<br>
Автор ответа - Scorpy <br>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
