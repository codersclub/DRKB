---
Title: Как проигрывать 2 звука одновременно?
Date: 01.01.2007
---


Как проигрывать 2 звука одновременно?
=====================================

::: {.date}
01.01.2007
:::

    uses 
      MMSystem; 
     
    procedure SendMCICommand(Cmd: string); 
    var 
      RetVal: Integer; 
      ErrMsg: array[0..254] of char; 
    begin 
      RetVal := mciSendString(PChar(Cmd), nil, 0, 0); 
      if RetVal <> 0 then 
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

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
