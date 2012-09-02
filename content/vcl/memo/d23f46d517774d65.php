<h1>Как сделать TMemo с закругленными краями?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  rgn: HRGN;
  r: TRect;
begin
  r := memo1.ClientRect;
  rgn := CreateRoundRectRgn(r.Left, r.top, r.right, r.bottom, 20, 20);
  memo1.BorderStyle := bsNone;
  memo1.Perform(EM_GETRECT, 0, lparam(@r));
  InflateRect(r, -5, -5);
  memo1.Perform(EM_SETRECTNP, 0, lparam(@r));
  SetWindowRgn(memo1.Handle, rgn, true);
end;
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
