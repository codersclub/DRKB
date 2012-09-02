<h1>Как назначить событие на увеличение / уменьшение TSpinEdit с помощью стрелочек?</h1>
<div class="date">01.01.2007</div>


<p>У TSpinEdit.Button есть дополнительные события, которые не показаны в инспекторе объектов, например, OnUpClick и OnDownClick...</p>
<pre>
unit Unit1;

 
interface
uses
 Windows, Messages, SysUtils, Classes, Graphics, 
 Controls, Forms, Dialogs, StdCtrls, Spin;
 
type
 TForm1 = class(TForm)
   SpinEdit1: TSpinEdit;
   procedure FormCreate(Sender: TObject);
 public
   procedure OnButtonUpClick(Sender: TObject);
end;
 
var
 Form1: TForm1;
 
implementation
 
 {$R *.DFM}
 
procedure TForm1.FormCreate(Sender: TObject);
begin
 SpinEdit1.Button.OnUpClick := OnButtonUpClick;
end;
 
procedure TForm1.OnButtonUpClick(Sender: TObject);
begin
 MessageDlg('Up Button was clicked.', mtInformation,
   [mbOk], 0);
end;
 
end.
</pre>

<p class="author">Автор: p0s0l</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
