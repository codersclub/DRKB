---
Title: Подключен ли в своем компе протокол TCP/IP?
Author: Vit
Date: 01.01.2007
---


Подключен ли в своем компе протокол TCP/IP?
===========================================

Вариант 1:

Author: Vit

Source: Vingrad.ru <https://forum.vingrad.ru>

Думаю что надёжнее всего "ping 127.0.0.1" потому что другие методы не
дадут уверенности что протокол работает нормально.

Почему именно ping 127.0.0.1?

127.0.0.1 - или по другому `localhost` - это предопределённый протоколом
TCP/IP собственный (внутренний) адрес компьютера, так что если TCP/IP
установлен и работает, то этот адрес точно есть и должен пинговаться без
проблем, кроме того он пингуется без выхода в сеть, и удобен если надо
отличить неработоспособность протокола (драйвера) от поломок вне
компьютера(хаб, свич, разъёмы, провода, сервера, другие компьютеры).

------------------------------------------------------------------------

Вариант 2:

Source: <https://forum.sources.ru>

    uses Registry;
     
    function TCPIPInstalled: boolean;
    var 
      Reg:   TRegistry; 
      RKeys: TStrings; 
    begin 
     Result:=False; 
     try 
      Reg := TRegistry.Create; 
      RKeys := TStringList.Create; 
      Reg.RootKey:=HKEY_LOCAL_MACHINE; 
      if Reg.OpenKey('\Enum\Network\MSTCP', False) Then 
       begin 
         reg.GetKeyNames(RKeys); 
         Result := RKeys.Count > 0; 
       end; 
     finally 
      Reg.free; 
      RKeys.free; 
     end; 

