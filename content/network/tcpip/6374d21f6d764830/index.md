---
Title: Преобразуем доменное имя в IP адрес
Author: Lutfi Baran
Date: 01.01.2007
---


Преобразуем доменное имя в IP адрес
===================================

::: {.date}
01.01.2007
:::

Автор: Lutfi Baran

Описывается функция, которая показывает, как вычислить IP адрес
компьютера в интернете по его доменному имени.

Совместимость: Delphi 3.x (или выше)

Объявляем Winsock, для использования в функции

    function HostToIP(Name: string; var Ip: string): Boolean; 
    var 
      wsdata : TWSAData; 
      hostName : array [0..255] of char; 
      hostEnt : PHostEnt; 
      addr : PChar; 
    begin 
      WSAStartup ($0101, wsdata); 
      try 
        gethostname (hostName, sizeof (hostName)); 
        StrPCopy(hostName, Name); 
        hostEnt := gethostbyname (hostName); 
        if Assigned (hostEnt) then 
          if Assigned (hostEnt^.h_addr_list) then begin 
            addr := hostEnt^.h_addr_list^; 
            if Assigned (addr) then begin 
              IP := Format ('%d.%d.%d.%d', [byte (addr [0]), 
              byte (addr [1]), byte (addr [2]), byte (addr [3])]); 
              Result := True; 
            end 
            else 
              Result := False; 
          end 
          else 
            Result := False 
        else begin 
          Result := False; 
        end; 
      finally 
        WSACleanup; 
      end 
    end; 

Вы можете разметстить на форме EditBox, Кнопку и Label и добавить к
кнопке следующий обработчик события OnClick:

    procedure TForm1.Button1Click(Sender: TObject); 
    var 
    IP: string; 
    begin 
    if HostToIp(Edit1.Text, IP) then Label1.Caption := IP; 
     

Взято из <https://forum.sources.ru>
