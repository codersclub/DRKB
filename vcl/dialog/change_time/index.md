---
Title: Как открыть диалог смены системного времени?
Date: 01.01.2007
---


Как открыть диалог смены системного времени?
============================================

::: {.date}
01.01.2007
:::

    uses 
      Shellapi; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      ShellExecute(Handle, 'open', 'control', 'date/time', nil, SW_SHOW); 
    end; 

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
