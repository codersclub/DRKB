---
Title: Как узнать, подключен ли компьютер к сети?
Date: 01.01.2007
---


Как узнать, подключен ли компьютер к сети?
==========================================

::: {.date}
01.01.2007
:::

    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      if GetSystemMetrics(SM_NETWORK) and $01 = $01 then 
        ShowMessage('Computer is attached to a network!') 
      else 
        ShowMessage('Computer is not attached to a network!'); 
    end; 

Взято из <https://forum.sources.ru>
