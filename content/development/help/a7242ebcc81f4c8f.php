<h1>Как закрыть help при закрытии приложения?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.FormDestroy(Sender: TObject); 
begin 
  Application.HelpCommand(HELP_QUIT, 0); 
end; 
</pre>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
<hr />
<pre>
procedure TMainForm.FormClose(Sender: TObject; var Action: TCloseAction);
begin
  Winhelp(Handle, 'WINHELP.HLP', HELP_QUIT, 0);
  Action := caFree;
end;
</pre>

