<h1>Определение подключения / отключения нового устройства</h1>
<div class="date">01.01.2007</div>


<p>Маленький коментарий:<br>
При открытии сидирома срабатывает DBT_DEVICEREMOVECOMPLETE, при закрытии DBT_DEVICEARRIVAL<br>
При подключении сетевого диска также приходит DBT_DEVICEARRIVAL а при отключении DBT_DEVICEREMOVECOMPLETE<br>
При подключении или отключении флэшки срабатывает DBT_DEVNODES_CHANGED...<br>
<p></p>
<pre>
unit Unit1;

 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
  Dialogs, MMSystem;
 
type
  TForm1 = class(TForm)
  public
    procedure CD(var Msg: TMessage); message WM_DEVICECHANGE;
  end;
 
const
  DBT_DEVICEARRIVAL = $8000;
  DBT_DEVICEREMOVECOMPLETE = $8004;
  DBT_DEVNODES_CHANGED = $7;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.dfm}
 
{ TForm1 }
 
procedure TForm1.CD(var Msg: TMessage);
begin
  case Msg.WParam of
    DBT_DEVNODES_CHANGED: Caption := 'Flash change';
    DBT_DEVICEARRIVAL: Caption := 'CD close with new disk';
    DBT_DEVICEREMOVECOMPLETE: Caption := 'CD open';
    //DBT_DEVICEARRIVAL: Caption := 'New network disk maped';
    //DBT_DEVICEREMOVECOMPLETE: Caption := 'Network disk unmaped';
  else
    Caption := 'Unknown';
  end;
end;
 
end.
</pre>
<div class="author">Автор: Александр (Rouse_) Багель</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
