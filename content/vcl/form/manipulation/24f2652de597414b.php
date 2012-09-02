<h1>Как заставить форму находиться всегда позади всех окон?</h1>
<div class="date">01.01.2007</div>


<pre>
type
  TForm1 = class(TForm)
    procedure WndProc (var message: TMessage); override;
  private
    { Private declarations }
  public
    { Public declarations }
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.dfm}
 
procedure TForm1.WndProc (var message: TMessage);
begin
  case message.Msg of                         
     WM_WINDOWPOSCHANGING: PWindowPos(Message.LParam)^.hwndInsertAfter:=HWND_BOTTOM;
  end;
   inherited;
end;
</pre>
<p class="author">Автор: antonn </p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
