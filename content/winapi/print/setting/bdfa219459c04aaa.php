<h1>Определение количества заданий в спулере печати</h1>
<div class="date">01.01.2007</div>


<p>Spooler печати Windows посылает WM_SPOOLERSTATUS каждый раз при добавлении и удалении заданий в очереди печати. В следующем примере показано как перехватить это сообщение:</p>
<pre>
type
TForm1 = class(TForm)
    Label1: TLabel;
private
    { Private declarations }
    procedure WM_SpoolerStatus(var Msg : TWMSPOOLERSTATUS); message WM_SPOOLERSTATUS;
public
    { Public declarations }
end;
 
var
Form1: TForm1;
 
implementation
 
{$R *.DFM}
 
procedure TForm1.WM_SpoolerStatus(var Msg : TWMSPOOLERSTATUS);
begin
Lable1.Caption := IntToStr(msg.JobsLeft) +
            ' Jobs currenly in spooler';
msg.Result := 0;
end;
</pre>

<p class="author">Автор: Song</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

