<h1>Как создать форму в форме элипса?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.FormCreate(Sender: TObject);
var
  Region: HRGN;
begin
  Region := CreateEllipticRgn(0, 0, 300, 300);
  SetWindowRgn(Handle, Region, True);
end;
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
