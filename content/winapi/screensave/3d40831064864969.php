<h1>Предотвратить запуск screensaver'a при работе программы</h1>
<div class="date">01.01.2007</div>


<pre>
interface
 
 private
   procedure AppMessage(var Msg: TMsg; var handled: Boolean);
 end;
 
 implementation
 
 
 procedure TForm1.AppMessage(var Msg: TMsg; var handled: Boolean);
 begin
   if (Msg.Message = WM_SYSCOMMAND) and (Msg.wParam = SC_SCREENSAVE) then
     Handled := True;
 end;
 
 procedure TForm1.FormCreate(Sender: TObject);
 begin
   Application.OnMessage := AppMessage;
 end;
 
 { 
  Note: The Screensaver is only disabled during the lifespan of 
  your application. 
}
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
