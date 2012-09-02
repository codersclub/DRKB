<h1>Как перевести монитор в режим stand by?</h1>
<div class="date">01.01.2007</div>


<p class="author">Автор: Kecvin S. Gallagher</p>
<p>Если монитор поддерживает режим Stand by, то его можно программно перевести в этот режим. Данная возможность доступна на Windows95 и выше.</p>
<p>Чтобы перевести монитор в режим Stand by:</p>
<pre>
SendMessage(Application.Handle, wm_SysCommand, SC_MonitorPower, 0) ; 
</pre>
<p>Чтобы вывести его из этого режима:</p>
<pre>SendMessage(Application.Handle, wm_SysCommand, SC_MonitorPower, -1) ;
</pre>

<p>А теперь более полный пример кода:</p>
<p>На новую форму поместите кнопку, таймер и ListBox.</p>
<pre>Timer (use Object Inspector):
 
Enabled := False
Interval := 15000 
</pre>

<p>Добавьте следующее событие таймеру:</p>
<pre>procedure TForm1.Timer1Timer(Sender: TObject);
begin
  ListBox1.Items.Add(FormatDateTime('h:mm:ss AM/PM',Time)) ;
  SendMessage(Application.Handle, wm_SysCommand, SC_MonitorPower, -1);
end;
</pre>
<p>Command Button:</p>
<pre>procedure TForm1.Button1Click(Sender: TObject);
begin
  ListBox1.Items.Add('--&gt; ' + FormatDateTime('h:mm:ss AM/PM',Time)) ;
  Timer1.Enabled := not Timer1.Enabled ;
  SendMessage(Application.Handle, wm_SysCommand, SC_MonitorPower, 0) ;
end;
</pre>
<p>После запуска откомпилированного приложения и нажатия на кнопку, экран погаснет на 15 секунд.</p>
<p>ЗАМЕЧАНИЕ: Удостоверьтесь, что во первых компьютер поддерживает режимы энергосбережения, а вовторых, эти функции не запрещены на данном компьютере.</p>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

