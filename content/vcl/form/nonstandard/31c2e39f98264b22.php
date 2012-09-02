<h1>Как сделать дырку в окне?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button4Click(Sender: TObject);
var
  HRegion1, Hreg2, Hreg3: THandle;
  Col: TColor;
begin
  ShowMessage ('Ready for a real crash?');
  Col := Color;
  Color := clRed;
  PlaySound ('boom.wav', 0, snd_sync);
  HRegion1 := CreatePolygonRgn (Pts,
    sizeof (Pts) div 8,
    alternate);
  SetWindowRgn (
    Handle, HRegion1, True);
  ShowMessage ('Now, what have you done?');
  Color := Col;
  ShowMessage ('Вам лучше купить новый монитор');
end;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

