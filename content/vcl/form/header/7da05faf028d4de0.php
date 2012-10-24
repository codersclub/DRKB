<h1>Добавляем дополнительную кнопку в заголовок формы</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Vimil Saju</div>

<p>Чтобы добавить дополнительную кнопку, нам прийдётся создать обработчики для следующих событий:</p>
<p>WM_NCPAINT;//вызывается, когда перерисовывается не клиентская область формы</p>
<p>WM_NCACTIVATE; вызывается, когда заголовок формы становится активныи</p>
<p>WM_NCLBUTTONDOWN; вызывается, когда кнопка мыши нажимается на не клиентской области</p>
<p>WM_NCMOUSEMOVE; вызывается, когда курсор мыши передвигается по не клиентской области</p>
<p>WM_MOUSEMOVE;вызывается, когда курсор мыши передвигается по клиентской области</p>
<p>WM_LBUTTONUP; вызывается, когда кнопка мыши отпушена в клиентской области</p>
<p>WM_NCLBUTTONUP; вызывается, когда кнопка мыши отпушена в не клиентской области</p>
<p>WM_NCLBUTTONDBLCLK; вызывается при двойном щелчке мышкой в не клиентской области</p>

<p>Приведённый ниже код модифицирован, чтобы избавиться от нежелательного мерцания кнопки</p>
<p>будем использовать следующие переменные:</p>

<p>h1(Thandle) : хэндл контекста устройства всего окна, включая не клиентскую область.</p>
<p>pressed(boolean): индикатор, показывающий, нажата кнопка или нет.</p>
<p>focuslost(boolean): индикатор, показывающий, находится ли фокус на кнопке или нет.</p>
<p>rec(Trect): размер кнопки.</p>
<pre>type 
  TForm1 = class(TForm) 
    procedure FormPaint(Sender: TObject); 
    procedure FormResize(Sender: TObject); 
    procedure FormCreate(Sender: TObject); 
  private 
    { Private declarations } 
  public 
    procedure WMNCPAINT(var msg:tmessage);message WM_NCPAINT; 
    procedure WMNCACTIVATE(var msg:tmessage);message WM_NCACTIVATE; 
    procedure WMNCMOUSEDOWN(var msg:tmessage);message WM_NCLBUTTONDOWN; 
    procedure WMNCMOUSEMOVE(var msg:tmessage);message WM_NCMOUSEMOVE; 
    procedure WMMOVE(var msg:tmessage);message WM_MOUSEMOVE; 
    procedure WMLBUTTONUP(var msg:tmessage);message WM_LBUTTONUP; 
    procedure WMNCMOUSEUP(var msg:tmessage);message WM_NCLBUTTONUP; 
    procedure WNCLBUTTONDBLCLICK(var msg:tmessage);message WM_NCLBUTTONDBLCLK; 
  end; 

var 
  Form1: TForm1; 
  h1:thandle; 
  pressed:boolean; 
  focuslost:boolean; 
  rec:trect; 
implementation 

{$R *.DFM} 

procedure tform1.WMLBUTTONUP(var msg:tmessage); 
begin 
pressed:=false; 
invalidaterect(form1.handle,@rec,true); 
inherited; 
end; 

procedure tform1.WMMOVE(var msg:tmessage); 
var tmp:boolean 
begin 
tmp:=focuslost; 
focuslost:=true; 
if tmp&lt;&gt;focuslost then 
  invalidaterect(form1.handle,@rec,true); 
inherited; 
end; 

procedure tform1.WMNCMOUSEMOVE(var msg:tmessage); 
var 
pt1:tpoint; 
tmp:boolean; 
begin 
tmp:=focuslost; 
pt1.x:=msg.LParamLo-form1.left; 
pt1.y:=msg.LParamHi-form1.top; 
if not(ptinrect(rec,pt1)) then 
  focuslost:=true 
else 
  focuslost:=false; 
if tmp&lt;&gt;focuslost then 
  invalidaterect(form1.handle,@rec,true); 
end; 

procedure tform1.WNCLBUTTONDBLCLICK(var msg:tmessage); 
var pt1:tpoint; 
begin 
pt1.x:=msg.LParamLo-form1.left; 
pt1.y:=msg.LParamHi-form1.top; 
if not(ptinrect(rec,pt1)) then 
  inherited; 
end; 

procedure tform1.WMNCMOUSEUP(var msg:tmessage); 
  var pt1:tpoint; 
begin 
pt1.x:=msg.LParamLo-form1.left; 
pt1.y:=msg.LParamHi-form1.top; 
if (ptinrect(rec,pt1)) and (focuslost=false) then 
  begin 
   pressed:=false; 
   { 
     enter your code here when the button is clicked   
   } 
   invalidaterect(form1.handle,@rec,true); 
  end 
else 
  begin 
   pressed:=false; 
   focuslost:=true; 
   inherited; 
  end; 
end; 

procedure tform1.WMNCMOUSEDOWN(var msg:tmessage); 
var pt1:tpoint; 
begin 
pt1.x:=msg.LParamLo-form1.left; 
pt1.y:=msg.LParamHi-form1.top; 
if ptinrect(rec,pt1) then 
  begin 
   pressed:=true; 
   invalidaterect(form1.handle,@rec,true); 
  end 
else 
  begin 
   form1.paint; 
   inherited; 
  end; 
end; 

procedure tform1.WMNCACTIVATE(var msg:tmessage); 
begin 
invalidaterect(form1.handle,@rec,true); 
inherited; 
end; 

procedure tform1.WMNCPAINT(var msg:tmessage); 

begin 
invalidaterect(form1.handle,@rec,true); 
inherited; 
end; 

procedure TForm1.FormPaint(Sender: TObject); 
begin 
h1:=getwindowdc(form1.handle); 
rec.left:=form1.width-75; 
rec.top:=6; 
rec.right:=form1.width-60; 
rec.bottom:=20; 
selectobject(h1,getstockobject(ltgray_BRUSH)); 
rectangle(h1,rec.left,rec.top,rec.right,rec.bottom); 
if (pressed=false) or (focuslost=true) then 
  drawedge(h1,rec,EDGE_RAISED,BF_RECT) 
else if (pressed=true) and (focuslost=false) then 
  drawedge(h1,rec,EDGE_SUNKEN,BF_RECT); 
releasedc(form1.handle,h1); 
end; 

procedure TForm1.FormResize(Sender: TObject); 
begin 
form1.paint; 
end; 

procedure TForm1.FormCreate(Sender: TObject); 
begin 
rec.left:=0; 
rec.top:=0; 
rec.bottom:=0; 
rec.right:=0; 
end; 
</pre>

<p>  Комментарии специалистов:</p>

<p>Дата: 25 Августа 2000г.</p>
<div class="author">Автор: NeNashev nashev@mail.ru</div>

<p>InvalidateRect на событие Resize ничего не даёт. Но даже без него</p>
<p>кнопка всё равно моргает при Resize формы... Надо ещё где-то убрать</p>

<p>Для рисования кнопок на заголовке окна лучше пользоваться</p>
<p>DrawFrameControl а не DrawEdge... Так и с не серыми настройками</p>
<p>интерфейса всё правильно будет. Да и проще так.</p>

<p>Названия функций, констант и т.п лучше писать так, как они в описаниях</p>
<p>даются, а не подряд маленькими буквами. Особенно для публикации. Так</p>
<p>оно и читается по большей части лучше, и в С такая привычка Вам не</p>
<p>помешает...</p>

<p>Сравнивать логическое значение с логической константой чтоб получить</p>
<p>логическое значение глупо, так как логическое значение у Вас уже есть.</p>
<p>тоесь вместо</p>
<p>if (pressed=true) and (focuslost=false)</p>
<p>лучше писать</p>
<p>if Pressed and not FocusLost</p>

<p>Для конструирования прямоугольников и точек из координат есть две</p>
<p>простые функции Rect и Point.</p>

<p>В общем Ваша процедура FormPaint может выглядеть так:</p>
<pre>
procedure TMainForm.FormPaint(Sender: TObject);
var h1:THandle;
begin
h1:=GetWindowDC(MainForm.Handle);
rec:=Rect(MainForm.Width-75,6,MainForm.Width-60,20);
if Pressed and not FocusLost then 
  DrawFrameControl(h1, rec, DFC_BUTTON, DFCS_BUTTONPUSH or DFCS_PUSHED)
else
  DrawFrameControl(h1, rec, DFC_BUTTON, DFCS_BUTTONPUSH);
ReleaseDC(MainForm.Handle,h1);
end;
</pre>


<p>Но вообще-то рисовать эту кнопку надо только при WM_NCPAINT, а не</p>
<p>всегда... И вычислять координаты по другому... Вдруг размер элементов</p>
<p>заголовка у юзера в системе не стандартный? А это просто настраивается...</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


<hr />Непосредственно такой функции вроде нет, но можно изловчиться. Нарисовать там кнопку вручную и обрабатывать команды нажатия мышки на Caption Bar.</p>
<p>Пример.</p>

<pre>
unit Main;
interface
uses
  Windows, Buttons, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs;
 
type
  TForm1 = class(TForm)
    procedure FormResize(Sender: TObject);
  private
    CaptionBtn : TRect;
    procedure DrawCaptButton;
    procedure WMNCPaint(var Msg : TWMNCPaint); message WM_NCPaint;
    procedure WMNCActivate(var Msg : TWMNCActivate); message WM_NCACTIVATE;
    procedure WMSetText(var Msg : TWMSetText); message WM_SETTEXT;
    procedure WMNCHitTest(var Msg : TWMNCHitTest); message WM_NCHITTEST;
    procedure WMNCLButtonDown(var Msg : TWMNCLButtonDown); message WM_NCLBUTTONDOWN;
  public
    { Public declarations }
  end;
 
var
  Form1: TForm1;
 
implementation
const
  htCaptionBtn = htSizeLast + 1;
{$R *.DFM}
 
procedure TForm1.DrawCaptButton;
var
  xFrame,  yFrame,  xSize,  ySize  : Integer;
  R : TRect;
begin
  //Dimensions of Sizeable Frame
  xFrame := GetSystemMetrics(SM_CXFRAME);
  yFrame := GetSystemMetrics(SM_CYFRAME);
 
  //Dimensions of Caption Buttons
  xSize  := GetSystemMetrics(SM_CXSIZE);
  ySize  := GetSystemMetrics(SM_CYSIZE);
 
  //Define the placement of the new caption button
  CaptionBtn := Bounds(Width - xFrame - 4*xSize + 2,
                       yFrame + 2, xSize - 2, ySize - 4);
 
  //Get the handle to canvas using Form's device context
  Canvas.Handle := GetWindowDC(Self.Handle);
 
  Canvas.Font.Name := 'Symbol';
  Canvas.Font.Color := clBlue;
  Canvas.Font.Style := [fsBold];
  Canvas.Pen.Color := clYellow;
  Canvas.Brush.Color := clBtnFace;
 
  try
    DrawButtonFace(Canvas, CaptionBtn, 1, bsAutoDetect, False, False, False);
    //Define a smaller drawing rectangle within the button
    R := Bounds(Width - xFrame - 4 * xSize + 2,
                       yFrame + 3, xSize - 6, ySize - 7);
    with CaptionBtn do
      Canvas.TextRect(R, R.Left + 2, R.Top - 1, 'W');
  finally
    ReleaseDC(Self.Handle, Canvas.Handle);
    Canvas.Handle := 0;
  end;
end;
 
procedure TForm1.WMNCPaint(var Msg : TWMNCPaint);
begin
  inherited;
  DrawCaptButton;
end;
 
procedure TForm1.WMNCActivate(var Msg : TWMNCActivate);
begin
  inherited;
  DrawCaptButton;
end;
 
procedure TForm1.WMSetText(var Msg : TWMSetText);
begin
  inherited;
  DrawCaptButton;
end;
 
procedure TForm1.WMNCHitTest(var Msg : TWMNCHitTest);
begin
  inherited;
  with Msg do
    if PtInRect(CaptionBtn, Point(XPos - Left, YPos - Top)) then
      Result := htCaptionBtn;
end;
 
procedure TForm1.WMNCLButtonDown(var Msg : TWMNCLButtonDown);
begin
  inherited;
  if (Msg.HitTest = htCaptionBtn) then
    ShowMessage('You hit the button on the caption bar');
end;
 
procedure TForm1.FormResize(Sender: TObject);
begin
  //Force a redraw of caption bar if form is resized
  Perform(WM_NCACTIVATE, Word(Active), 0);
end;
 
end.
</pre>

<p>Источник: <a href="https://dmitry9.nm.ru/info/" target="_blank">https://dmitry9.nm.ru/info/</a></p>

<hr />Автор: Tercio Ferdinando Gaudencio Filho</p>

<p>Приведённый здесь код создаёт кнопку в заголовке окна, создаёт MenuItem в системном меню и создаёт подсказку(Hint) в кнопке. Поместите код в Ваш Unit и замените "FrmMainForm" на Ваше имя формы, а так же некоторые кусочки кода, ткст подсказки и т.д.</p>

<p>Совместимость: Delphi 3.x (или выше)</p>
<pre>
... 
 
  private 
    { Private declarations } 
    procedure WMNCPAINT          (var msg: Tmessage); message WM_NCPAINT; 
    procedure WMNCACTIVATE       (var msg: Tmessage); message WM_NCACTIVATE; 
    procedure WMNCMOUSEDOWN      (var msg: Tmessage); message WM_NCLBUTTONDOWN; 
    procedure WMNCMOUSEMOVE      (var Msg: TMessage); message WM_NCMOUSEMOVE; 
    procedure WMMOUSEMOVE        (var Msg: TMessage); message WM_MOUSEMOVE; 
    procedure WMLBUTTONUP        (var msg: Tmessage); message WM_LBUTTONUP; 
    procedure WNCLBUTTONDBLCLICK (var msg: Tmessage); message WM_NCLBUTTONDBLCLK; 
    procedure WMNCRBUTTONDOWN    (var msg: Tmessage); message WM_NCRBUTTONDOWN; 
    procedure WMNCHITTEST        (var msg: Tmessage); message WM_NCHITTEST; 
    procedure WMSYSCOMMAND       (var msg: Tmessage); message WM_SYSCOMMAND; 
 
... 
 
var 
... 
  Pressed         : Boolean; 
  FocusLost       : Boolean; 
  Rec             : TRect; 
  NovoMenuHandle  : THandle; 
  PT1             : TPoint; 
  FHintshow       : Boolean; 
  FHint           : THintWindow; 
  FHintText       : String; 
  FHintWidth      : Integer; 
 
... 
 
//------------------------------------------------------------------------------ 
 
procedure TFrmMainForm.WMSYSCOMMAND(var Msg: TMessage); 
begin 
  if Msg.WParam=LongInt(NovoMenuHandle) then 
    //********************************************* 
    //Кнопка была нажата! Добавьте сюда Вашу функцию 
    //********************************************* 
  inherited; 
end; 
 
//------------------------------------------------------------------------------ 
 
procedure TFrmMainForm.WMNCHITTEST(var Msg: TMessage); 
var 
  Tmp : Boolean; 
begin 
  if Pressed then 
  begin 
    Tmp:=FocusLost; 
    PT1.X := Msg.LParamLo - FrmMainForm.Left; 
    PT1.Y := Msg.LParamHi - FrmMainForm.Top ; 
    if PTInRect(Rec, PT1) then 
      FocusLost := False 
    else 
      FocusLost := True; 
    if FocusLost &lt;&gt; Tmp then 
      InvalidateRect(FrmMainForm.Handle, @Rec, True); 
  end; 
  inherited; 
end; 
 
//------------------------------------------------------------------------------ 
 
procedure TFrmMainForm.WMLBUTTONUP(var Msg: TMessage); 
var 
  Tmp : Boolean; 
begin 
  ReleaseCapture; 
  Tmp     := Pressed; 
  Pressed := False; 
  if Tmp and PTInRect(Rec, PT1) then 
  begin 
    InvalidateRect(FrmMainForm.Handle, @Rec, True); 
    FHintShow := False; 
    FHint.ReleaseHandle; 
    //********************************************* 
    //Кнопка была нажата! Добавьте сюда Вашу функцию 
    //********************************************* 
  end 
  else 
    inherited; 
end; 
 
//------------------------------------------------------------------------------ 
 
procedure TFrmMainForm.WNCLBUTTONDBLCLICK(var Msg: TMessage); 
begin 
  PT1.X := Msg.LParamLo - FrmMainForm.Left; 
  PT1.Y := Msg.LParamHi - FrmMainForm.Top ; 
  if not PTInRect(Rec, PT1) then 
    inherited; 
end; 
 
//------------------------------------------------------------------------------ 
 
procedure TFrmMainForm.WMNCRBUTTONDOWN(var Msg: TMessage); 
begin 
  PT1.X := Msg.LParamLo - FrmMainForm.Left; 
  PT1.Y := Msg.LParamHi - FrmMainForm.Top ; 
  if not PTInRect(Rec, PT1) then 
    inherited; 
end; 
 
//------------------------------------------------------------------------------ 
 
procedure TFrmMainForm.WMNCMOUSEDOWN(var Msg: TMessage); 
begin 
  PT1.X := Msg.LParamLo - FrmMainForm.Left; 
  PT1.Y := Msg.LParamHi - FrmMainForm.Top ; 
  FHintShow := False; 
  if PTInRect(Rec, PT1) then 
  begin 
   Pressed   := True; 
   FocusLost := False; 
   InvalidateRect(FrmMainForm.Handle, @Rec, True); 
   SetCapture(TWinControl(FrmMainForm).Handle); 
  end 
  else 
  begin 
   FrmMainForm.Paint; 
   inherited; 
  end; 
end; 
 
//------------------------------------------------------------------------------ 
 
//That function Create a Hint 
procedure TFrmMainForm.WMNCMOUSEMOVE(var Msg: TMessage); 
begin 
  PT1.X := Msg.LParamLo - FrmMainForm.Left; 
  PT1.Y := Msg.LParamHi - FrmMainForm.Top ; 
  if PTInRect(Rec, PT1) then 
  begin 
    FHintWidth  := FHint.Canvas.TextWidth(FHintText); 
    if (FHintShow = False) and (Length(Trim(FHintText)) &lt;&gt; 0) then 
      FHint.ActivateHint( 
        Rect( 
          Mouse.CursorPos.X, 
          Mouse.CursorPos.Y + 20, 
          Mouse.CursorPos.X + FHintWidth + 10, 
          Mouse.CursorPos.Y + 35 
          ), 
        FHintText 
      ); 
      FHintShow := True; 
  end 
  else 
  begin 
    FHintShow := False; 
    FHint.ReleaseHandle; 
  end; 
end; 
 
//------------------------------------------------------------------------------ 
 
procedure TFrmMainForm.WMMOUSEMOVE(var Msg: TMessage); 
begin 
  FHintShow := False; 
  FHint.ReleaseHandle; 
end; 
 
//------------------------------------------------------------------------------ 
 
procedure TFrmMainForm.WMNCACTIVATE(var Msg: TMessage); 
begin 
  InvalidateRect(FrmMainForm.Handle, @Rec, True); 
  inherited; 
end; 
 
//------------------------------------------------------------------------------ 
 
procedure TFrmMainForm.WMNCPAINT(var Msg: TMessage); 
begin 
  InvalidateRect(FrmMainForm.Handle, @Rec, True); 
  inherited; 
end; 
 
//------------------------------------------------------------------------------ 
 
procedure TFrmMainForm.FormPaint(Sender:TObject); 
var 
  Border3D_Y, Border_Thickness, Btn_Width, 
  Button_Width, Button_Height  : Integer; 
  MyCanvas                      : TCanvas; 
begin 
  MyCanvas        := TCanvas.Create; 
  MyCanvas.Handle := GetWindowDC(FrmMainForm.Handle); 
  Border3D_Y      := GetSystemMetrics(SM_CYEDGE); 
  Border_Thickness:= GetSystemMetrics(SM_CYSIZEFRAME); 
  Button_Width    := GetSystemMetrics(SM_CXSIZE); 
  Button_Height   := GetSystemMetrics(SM_CYSIZE); 
 
  //Создаём квадратную кнопку, но если Вы захотите создать кнопку другого размера, то
  //измените эту переменную на Вашу ширину. 
  Btn_Width  := Border3D_Y  + Border_Thickness + Button_Height - (2 * Border3D_Y) - 1; 
 
  Rec.Left   := FrmMainForm.Width - (3 * Button_Width + Btn_Width); 
  Rec.Right  := FrmMainForm.Width - (3 * Button_Width + 03); 
  Rec.Top    := Border3D_Y  + Border_Thickness - 1; 
  Rec.Bottom := Rec.Top     + Button_Height - (2 * Border3D_Y); 
  FillRect(MyCanvas.Handle,Rec,HBRUSH(COLOR_BTNFACE+1)); 
  If not Pressed or Focuslost Then 
    DrawEdge(MyCanvas.Handle, Rec, EDGE_RAISED, BF_SOFT or BF_RECT) 
  Else If Pressed and Not Focuslost Then 
    DrawEdge(MyCanvas.Handle, Rec, EDGE_SUNKEN, BF_SOFT or BF_RECT); 
 
  //It draw a the application icon to the button. Easy to change. 
  DrawIconEX(MyCanvas.Handle, Rec.Left+4, Rec.Top+3, Application.Icon, 8, 8, 0, 0, DI_NORMAL); 
 
  MyCanvas.Free; 
end; 
 
... 
 
procedure TFrmMainForm.FormCreate(Sender: TObject); 
 
... 
 
  InsertMenu(GetSystemMenu(Handle,False), 4, MF_BYPOSITION+MF_STRING, NovoMenuHandle,pchar('TEXT OF THE MENU')); 
  Rec             := Rect(0,0,0,0); 
  FHintText       := 'Put the text of your Hint HERE'; 
  FHint           := THintWindow.Create(Self); 
  FHint.Color     := clInfoBk;  //Вы можете изменить бэкграунд подсказки
 
... 
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


