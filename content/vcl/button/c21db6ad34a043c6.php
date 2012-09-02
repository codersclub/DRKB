<h1>Можно ли использовать иконку как картинку на кнопке TSpeedButton?</h1>
<div class="date">01.01.2007</div>


<pre>
uses ShellApi;
 
procedure TForm1.FormShow(Sender: TObject);
var
  Icon: TIcon;
begin
  Icon := TIcon.Create;
  Icon.Handle := ExtractIcon(0, 'C:\WINDOWS\NOTEPAD.EXE', 1);
  SpeedButton1.Glyph.Width := Icon.Width;
  SpeedButton1.Glyph.Height := Icon.Height;
  SpeedButton1.Glyph.Canvas.Draw(0, 0, Icon);
  Icon.Free;
end;
</pre>

