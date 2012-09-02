<h1>Как получить картинки из MessageDlg?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  Ic: TIcon;
begin
  Ic := TIcon.Create;
  Ic.Handle := LoadIcon(0, IDI_APPLICATION);
  Form1.Canvas.Draw(1, 1, Ic);
  Ic.Handle := LoadIcon(0, IDI_ASTERISK);
  Form1.Canvas.Draw(32, 1, Ic);
  Ic.Handle := LoadIcon(0, IDI_EXCLAMATION);
  Form1.Canvas.Draw(64, 1, Ic);
  Ic.Handle := LoadIcon(0, IDI_QUESTION);
  Form1.Canvas.Draw(1, 32, Ic);
  Ic.Handle := LoadIcon(0, IDI_HAND);
  Form1.Canvas.Draw(32, 32, Ic);
  Ic.Handle := LoadIcon(0, IDI_WINLOGO);
  Form1.Canvas.Draw(64, 32, Ic);
  Ic.Destroy;
end;
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
