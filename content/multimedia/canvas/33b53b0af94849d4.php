<h1>Как очистить Canvas?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);
begin
  PatBlt(Form1.Canvas.Handle,0,0,Form1.ClientWidth,Form1.ClientHeight,WHITENESS);
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

<hr />
<pre>
Canvas.Brush.Color := ClWhite;
Canvas.FillRect(Canvas.ClipRect);
</pre>

<hr />
<pre>
InValidateRect(Canvas.handle,NIL,True);
</pre>

<p>(или взамен передать дескриптор компонента) </p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

<hr />Есть два хороших способа очистить Canvas. Их скорости очень близки. В первом способе используются возможности Delphi, во втором &#8211; WinAPI. Первый способ удобнее тем, что позволяет закрашивать Canvas любым цветом.</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
begin
  Form1.Canvas.Brush.Color := clRed;
  Form1.Canvas.FillRect(Form1.ClientRect);
  PatBlt(Form1.Canvas.Handle, 0, 0,
    Form1.ClientWidth, Form1.ClientHeight, WHITENESS);
end;
</pre>


<p class="author">Автор: Даниил Карапетян (delphi4all@narod.ru)</p>
<p>Автор справки: Алексей Денисов (aleksey@sch103.krasnoyarsk.su)</p>


<hr />
<pre>
InValidateRect(Canvas.handle,NIL,True);
</pre>

<p>Если вы используете холст формы, то попробуйте следующее: </p>
<pre>
 
InValidateRect(form1.handle,NIL,True); 
</pre>

<p>(или взамен передать дескриптор компонента) </p>

<p>Это очистит хост: </p>

<pre>
canvas.fillrect(canvas.cliprect);
</pre>
<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>



