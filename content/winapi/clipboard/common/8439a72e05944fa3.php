<h1>Как программно реализовать Cut, Copy и Paste?</h1>
<div class="date">01.01.2007</div>


<p>Следущие операции производятся с активным контролом на форме:</p>
<pre>
procedure TForm1.Cut1Click(Sender: TObject);
begin
  SendMessage (ActiveControl.Handle, WM_Cut, 0, 0);
end;
 
 
procedure TForm1.Copy1Click(Sender: TObject);
begin
  SendMessage (ActiveControl.Handle, WM_Copy, 0, 0);
end;
 
procedure TForm1.Paste1Click(Sender: TObject);
begin
  SendMessage (ActiveControl.Handle, WM_Paste, 0, 0);
end;
</pre>

<p>Если Вы разрабатываете приложение MDI, то необходимо отправлять сообщение в активное дочернее окно, т.е. использовать: ActiveMDIChild.ActiveControl.Handle</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

