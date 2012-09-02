<h1>Получить время задержки хранителя экрана</h1>
<div class="date">01.01.2007</div>


<pre>
function GetScreenSaverTimeout: Integer;
 begin
   SystemParametersInfo(SPI_GETSCREENSAVETIMEOUT, 0, @Result, 0);
 end;
 
 procedure TForm1.Button1Click(Sender: TObject);
 begin
   ShowMessage(IntToStr(GetScreenSaverTimeout) + ' Sec.');
 end;
</pre>

<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
