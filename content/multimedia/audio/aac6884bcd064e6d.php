<h1>Как играть MIDI без медиаплеера?</h1>
<div class="date">01.01.2007</div>


<pre>
uses 
  MMSystem; 
 
// Play Midi 
procedure TForm1.Button1Click; 
const 
  FileName = 'C:\YourFile.mid'; 
begin 
  MCISendString(PChar('play ' + FileName), nil, 0, 0); 
end; 
 
// Stop Midi 
procedure TForm1.Button1Click; 
const 
  FileName = 'C:\YourFile.mid'; 
begin 
  MCISendString(PChar('stop ' + FileName), nil, 0, 0); 
end; 
</pre>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
