<h1>Приложение с различным разрешением монитора?</h1>
<div class="date">01.01.2007</div>


<p>Из рассылки "Мастера DELPHI. Новости мира компонент, FAQ, статьи..."</p>
<p>Приложение, адекватно отображающееся на экранах с различным разрешением монитора?</p>
<pre>unit Main;
interface
uses
Windows, Messages, SysUtils, Classes, Graphics,
Controls, Forms, Dialogs, StdCtrls;
 
type
TForm1 = class(TForm)
Button1: TButton;
Edit1: TEdit;
procedure Button1Click(Sender: TObject);
procedure FormCreate(Sender: TObject);
private
{Отлавливаем, сообщение о изменении разрешения экрана}
procedure WMDisplayChange(var message: TMessage); message WM_DISPLAYCHANGE;
public
W, H: integer;
end;
var Form1: TForm1;
implementation
{$R *.DFM}
procedure TForm1.Button1Click(Sender: TObject);
begin
Width := Round(Width * 1.5);
Height := Round(Height
* 1.5);
ScaleBy(150, 100)
end;
procedure TForm1.WMDisplayChange(var message: TMessage);
begin
inherited;
Width := Round(Width * LOWORD(message.LParam) / W);
Height := Round(Height * HIWORD(message.LParam) / H);
ScaleBy(LOWORD(message.LParam), W);
W := Screen.Width;
H := Screen.Height;
end;
procedure TForm1.FormCreate(Sender: TObject);
begin
W := Screen.Width;
H := Screen.Height;
end;
end.
</pre>

<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
