<h1>В строке состояния TStatusBar выводится только 127 символов</h1>
<div class="date">01.01.2007</div>


<p>В строке состояния TStatusBar выводится только 127 символов.</p>
<p>Можно ли как-нибудь увеличить это число? </p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
 
 var i:integer;
      s:string;
begin
  s:='';
  for i:=1 to 150 do
    s:=s+inttostr(i mod 10);
  label1.Caption:=s;
  form1.Paint;
end;
 
procedure TForm1.FormPaint(Sender: TObject);
begin
  label1.Repaint;
  application.processmessages;{yield;}
  statusbar1.Canvas.CopyRect(rect(2,round((statusbar1.height- label1.height)/2),label1.width,label1.height),
label1.canvas,rect(0,0,label1.width,label1.height));
end;
</pre>

<p class="author">Автор: Mikel </p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
