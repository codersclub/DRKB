<h1>Как работать с джойстиком?</h1>
<div class="date">01.01.2007</div>


<pre>
uses MMSYSTEM; 
var 
  MyJoy: TJoyInfo; 
  ErrorResult: MMRESULT; 
begin 
  ErrorResult := joyGetPos(joystickid1, @MyJoy); 
  if ErrorResult = JOYERR_NOERROR then 
  begin 
    TrackBar1.Position := MyJoy.wypos; 
    TrackBar2.Position := MyJoy.wxpos; 
    RadioButton1.Checked := (MyJoy.wbuttons and joy_button1) &gt; 0; 
    RadioButton2.Checked := (MyJoy.wbuttons and joy_button2) &gt; 0; 
  end  
else 
   case ErrorResult of 
     MMSYSERR_NODRIVER: ShowMessage('No Joystick driver present'); 
     MMSYSERR_INVALPARAM: ShowMessage('Invalid Joystick Paramameters'); 
     JOYERR_UNPLUGGED: ShowMessage('Joystick is Unplugged'); 
   else  
     ShowMessage('Unknown error with Joystick'); 
 end; 
 
end;
</pre>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
<hr />
<pre>
var
  myjoy: tjoyinfo;
begin
  joygetpos(joystickid1, @myjoy);
  trackbar1.position := myjoy.wypos;
  trackbar2.position := myjoy.wxpos;
  radiobutton1.checked := (myjoy.wbuttons and joy_button1) &gt; 0;
  radiobutton2.checked := (myjoy.wbuttons and joy_button2) &gt; 0;
end;
</pre>
<p>Не забудьте включить MMSYSTEM в список используемых (USES) модулей</p>
<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>

