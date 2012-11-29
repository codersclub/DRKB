Как перехватывать kernel-signals?
=================================

::: {.date}
01.01.2007
:::

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

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
