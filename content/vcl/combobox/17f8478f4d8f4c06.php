<h1>Как у Комбобокса сделать BorderStyle := bsNone?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.FormCreate(Sender: TObject);

begin
  SetWindowRgn(
  ComboBox1.Handle,
  CreateRectRgn(2, 2, ComboBox1.Width - 2, ComboBox1.Height - 2), True);
end;
</pre>

<p>&nbsp;</p>
<p class="author">Автор: Smike</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
&nbsp;</p>
<hr />
<pre>
unit Unit1;

 
interface
 
uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, StdCtrls;
 
type
  TForm1 = class(TForm)
    ComboBox1: TComboBox;
    procedure FormCreate(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.dfm}
 
 
function NewComboProc(wnd:HWND; uMsg:UINT; wParam:WPARAM; lParam:LPARAM):integer; stdcall;
 var
   r,r1:TRect;
 begin
   case uMsg of
     WM_PAINT: begin
                  GetWindowRect(wnd,r);
                  SetWindowRgn(wnd,CreateRectRgn(2, 2, r.Right-r.Left - 2, r.Bottom-r.Top - 2), True);
               end;
     WM_CTLCOLORLISTBOX:
                  begin
                   GetWindowRect(wnd,r);
                   GetWindowRect(lParam,r1);
                   if (r.Left=r1.Left) and (r.Right=r1.Right) then
                   begin
                    InflateRect(r1,-2,0);
                    SetWindowPos(lParam,0,r.Left+2,r.Bottom-2,r1.Right-r1.Left,r1.Bottom-r1.Top,SWP_NOZORDER);
                   end
                  end;
   end;
    result:=CallWindowProc(Pointer(GetWindowLong(wnd,GWL_USERDATA)),wnd,uMsg,wParam,lParam);
 end;
 
procedure TForm1.FormCreate(Sender: TObject);
begin
 SetWindowLong(ComboBox1.Handle,GWL_USERDATA,SetWindowLong(ComboBox1.Handle, GWL_WNDPROC, LPARAM(@NewComboProc)))
end;
 
end.
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<p class="author">Автор: Krid</p>

