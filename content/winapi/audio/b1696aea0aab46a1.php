<h1>Как использовать  Microsoft Speech API?</h1>
<div class="date">01.01.2007</div>


<pre>
// Works on NT, 2k, XP, Win9x with SAPI SDK
// reference &amp; Further examples: See links below!
 
uses Comobj;
 
procedure TForm1.Button1Click(Sender: TObject);
var
  voice: OLEVariant;
begin
  voice := CreateOLEObject('SAPI.SpVoice');
  voice.Speak('Hello World!', 0);
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
