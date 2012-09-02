<h1>ASCII код для PrintScreen</h1>
<div class="date">01.01.2007</div>


<pre>
unit Unit1;
 
interface
 
uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs;
 
type
  TForm1 = class(TForm)
    procedure FormCreate(Sender: TObject);
  private
    { Private declarations }
    procedure AppIdle(Sender: TObject; var Done: Boolean);
  public
    { Public declarations }
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.dfm}
 
procedure TForm1.AppIdle(Sender: TObject; var Done: Boolean);
begin
if GetAsyncKeyState(VK_SNAPSHOT) &lt;&gt; 0 then
    Form1.Caption := 'PrintScreen ia?aoa !';
  Done := True;
end;
 
procedure TForm1.FormCreate(Sender: TObject);
begin
Application.OnIdle := AppIdle;
end;
end.
</pre>

<hr />
<pre>
type
  TForm1 = class(TForm)
    procedure FormCreate(Sender: TObject);
    procedure FormDestroy(Sender: TObject);
  private
    { Private declarations }
    procedure WMHotKey(var Msg : TWMHotKey); message WM_HOTKEY;
  public
    { Public declarations }
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.DFM}
 
const id_SnapShot = 101;
 
procedure TForm1.WMHotKey (var Msg : TWMHotKey);
begin
  if Msg.HotKey = id_SnapShot then
    ShowMessage('GotIt');
end;
 
procedure TForm1.FormCreate(Sender: TObject);
begin
  RegisterHotKey(Form1.Handle,
                 id_SnapShot,
                 0,
                 VK_SNAPSHOT);
end;
 
procedure TForm1.FormDestroy(Sender: TObject);
begin
  UnRegisterHotKey (Form1.Handle, id_SnapShot);
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

