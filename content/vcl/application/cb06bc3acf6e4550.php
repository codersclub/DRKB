<h1>Восстановление минимизированного приложения</h1>
<div class="date">01.01.2007</div>


<p>При минимизации формы я использую RxTrayIcon, чтобы при этом исчезла</p>
<p>кнопка из Панели задач вызываю ShowWindow(Application.Handle,SW_HIDE).</p>
<p>Но вот незадача - не получается при восстановлении приложения (после клика</p>
<p>на TrayIcon) добиться, чтобы оно становилось поверх других окон и обязательно было активным.</p>
<p>Дело оказалось в следующем : гасить Tray-иконку надо в последнюю очередь,</p>
<p>именно так все работает(ранее сначала гасил Tray-иконку, а уже потом восттанавливал свое приложение).</p>
<p>Таким образом правильно работает следующий код:</p>
<pre>
procedure TForm1.ApplicationMinimize(Sender : TObject);
begin
 RxTrayIcon1.Show;
 ShowWindow(Application.Handle,SW_HIDE);
end;
 
procedure TForm1.RxTrayIcon1Click(Sender: TObject; Button: TMouseButton;
         Shift: TShiftState; X, Y: Integer);
begin
 Application.Restore;
 SetForeGroundWindow(Application.MainForm.Handle);
 RxTrayIcon1.Hide;
end;
</pre>
<div class="author">Автор: Song, Den</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
