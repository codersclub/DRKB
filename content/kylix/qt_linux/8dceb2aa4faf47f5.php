<h1>Как перехватывать kernel-signals?</h1>
<div class="date">01.01.2007</div>


<pre>
program TestSignals; 
 
{$APPTYPE CONSOLE} 
 
uses 
  Libc; 
 
var 
  bTerminate: Boolean; 
 
procedure SignalProc(SigNum: Integer); cdecl; 
begin 
  case SigNum of  
    SIGQUIT:  
      begin 
        WriteLn('signal SIGQUIT'); 
        bTerminate := true; 
      end; 
    SIGUSR1: WriteLn('signal SIGUSR1'); 
    else 
      WriteLn('not handled signal'); 
  end; 
  signal(SigNum, SignalProc); // catch the signal again 
end; 
 
begin 
  bTerminate := false; 
 
  signal(SIGQUIT, SignalProc); // catch the signal SIGQUIT to procedure SignalProc 
  signal(SIGUSR1, SignalProc); // catch the signal SIGUSR1 to procedure SignalProc 
 
  repeat  
    sleep(1); 
  until bTerminate; 
end. 
</pre>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
