<h1>Узнать, включен ли хранитель экрана</h1>
<div class="date">01.01.2007</div>


<pre>
function ScreenSaverEnabled: Boolean;
 var
   status: Bool;
 begin
   SystemParametersInfo(SPI_GETSCREENSAVEACTIVE, 0, @status, 0);
   Result := status = True;
 end;
 
 procedure TForm1.Button1Click(Sender: TObject);
 begin
   if ScreenSaverEnabled then
     Caption := 'Screensaver is enabled.'
   else
     Caption := 'Screensaver is disabled.'
 end;
</pre>

<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
