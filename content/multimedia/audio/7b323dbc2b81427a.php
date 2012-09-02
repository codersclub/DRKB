<h1>Как проигрывать 2 звука одновременно?</h1>
<div class="date">01.01.2007</div>


<pre>
uses 
  MMSystem; 
 
procedure SendMCICommand(Cmd: string); 
var 
  RetVal: Integer; 
  ErrMsg: array[0..254] of char; 
begin 
  RetVal := mciSendString(PChar(Cmd), nil, 0, 0); 
  if RetVal &lt;&gt; 0 then 
  begin 
    {get message for returned value} 
    mciGetErrorString(RetVal, ErrMsg, 255); 
    MessageDlg(StrPas(ErrMsg), mtError, [mbOK], 0); 
  end; 
end; 
 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  SendMCICommand('open waveaudio shareable'); 
  SendMCICommand('play "C:\xyz\BackgroundMusic.wav"'); 
  SendMCICommand('play "C:\xyz\AnotherMusic.wav"'); 
  SendMCICommand('close waveaudio'); 
end; 
</pre>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
