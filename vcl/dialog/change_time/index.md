---
Title: Как открыть диалог смены системного времени?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как открыть диалог смены системного времени?
============================================

    uses 
      Shellapi; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      ShellExecute(Handle, 'open', 'control', 'date/time', nil, SW_SHOW); 
    end; 

