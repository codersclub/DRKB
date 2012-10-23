<h1>Как можно узнать, что было изменениие, например сдвиг мыши или нажатие клавиши?</h1>
<div class="date">01.01.2007</div>


<pre>
unit Unit1;

 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
  Dialogs, StdCtrls;
 
type
  TForm1 = class(TForm)
    Memo1: TMemo;
    procedure FormCreate(Sender: TObject);
    procedure FormClose(Sender: TObject; var Action: TCloseAction);
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.dfm}
 
var
  MouseHook: HHOOK;
 
function LowLevelMouseProc(nCode: Integer; WParam: WPARAM; LParam: LPARAM): LRESULT; stdcall;
begin
  Result := CallNextHookEx(MouseHook, nCode, WParam, LParam);
  case WParam of
    WM_LBUTTONDOWN: Form1.Memo1.Lines.Add('Мыша вдавилась левой кнопкой.');
    WM_LBUTTONUP: Form1.Memo1.Lines.Add('Мыша отдавилась левой кнопкой.');
    WM_LBUTTONDBLCLK: Form1.Memo1.Lines.Add('Мыша дважды клацнулась левой кнопкой.');
    WM_RBUTTONDOWN: Form1.Memo1.Lines.Add('Мыша вдавилась правой кнопкой.');
    WM_RBUTTONUP: Form1.Memo1.Lines.Add('Мыша отдавилась правой кнопкой.');
    WM_RBUTTONDBLCLK: Form1.Memo1.Lines.Add('Мыша дважды клацнулась правой кнопкой.');
    WM_MBUTTONDOWN: Form1.Memo1.Lines.Add('Мыша вдавилась средней кнопкой.');
    WM_MBUTTONUP: Form1.Memo1.Lines.Add('Мыша отдавилась средней кнопкой.');
    WM_MBUTTONDBLCLK: Form1.Memo1.Lines.Add('Мыша дважды клацнулась средней кнопкой.');
    WM_MOUSEMOVE: Form1.Memo1.Lines.Add('Мыша побежала.');
    WM_MOUSEWHEEL: Form1.Memo1.Lines.Add('Мыша тащиться.');
  else
    Form1.Memo1.Lines.Add('Мыша сошла с ума, купите новую мышу.');
  end;
end;
 
 
procedure TForm1.FormCreate(Sender: TObject);
const
  WH_MOUSE_LL = 14;
begin
  MouseHook := SetWindowsHookEx(WH_MOUSE_LL, @LowLevelMouseProc, HInstance, 0);
end;
 
procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);
begin
  UnhookWindowsHookEx(MouseHook);
end;
 
end.
</pre>
<p>&nbsp;<br>
Тож самое и на клавиатуру, код хука - Цифра 13 Соответственно принимай уже мессаги от клавиатуры...<br>
<p>Только начиная с Win 2000</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<div class="author">Автор: Rouse_</div>
