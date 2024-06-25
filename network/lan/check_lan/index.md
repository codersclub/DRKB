---
Title: Как узнать, подключен ли компьютер к сети?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как узнать, подключен ли компьютер к сети?
==========================================

    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      if GetSystemMetrics(SM_NETWORK) and $01 = $01 then 
        ShowMessage('Computer is attached to a network!') 
      else 
        ShowMessage('Computer is not attached to a network!'); 
    end; 

