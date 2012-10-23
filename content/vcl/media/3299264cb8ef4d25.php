<h1>AVI файл проигрывается снова и снова</h1>
<div class="date">01.01.2007</div>


<p>В примере AVI файл проигрывается снова и снова - используем событие MediaPlayer'а Notify</p>
<pre>
procedure TForm1.MediaPlayer1Notify(Sender: TObject);
begin with MediaPlayer1 do
    if NotifyValue = nvSuccessful then
      begin
        Notify := True;
        Play;
      end;
end;
</pre>

<p>Взято с сайта <a href="https://blackman.wp-club.net/myfaq/default.php" target="_blank">https://blackman.wp-club.net/myfaq/default.php</a></p>
