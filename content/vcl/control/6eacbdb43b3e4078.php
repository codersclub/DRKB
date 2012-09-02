<h1>События OnKeyPress и OnKeyDown не вызываются для Tab &ndash; как определить её нажатие?</h1>
<div class="date">01.01.2007</div>


<pre>
type
  TForm1 = class(TForm)
  private
    procedure CMDialogKey(var msg: TCMDialogKey);
      message CM_DIALOGKEY;
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.DFM}
 
procedure TForm1.CMDialogKey(var msg: TCMDialogKey);
begin
  if msg.Charcode &lt;&gt; VK_TAB then
    inherited;
end;
 
procedure TForm1.FormKeyDown(Sender: TObject; var Key:
  Word; Shift: TShiftState);
begin
  if Key = VK_TAB then
    Form1.Caption := 'Tab Key Down!';
end;
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
