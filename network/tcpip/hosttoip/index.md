---
Title: Как вычислить IP-адрес компьютера?
Author: neutrino
Date: 01.01.2007
---


Как вычислить IP-адрес компьютера?
==================================

Вариант 1:

Author: neutrino

Source: Vingrad.ru <https://forum.vingrad.ru>

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
          if Assigned (hostEnt^.h_addr_list) then 
            begin 
              addr := hostEnt^.h_addr_list^; 
              if Assigned (addr) then 
              begin 
                IP := Format ('%d.%d.%d.%d', [byte (addr [0]), 
                byte (addr [1]), byte (addr [2]), byte (addr [3])]); 
                Result := True; 
              end 
              else 
                Result := False; 
            end 
            else 
              Result := False 
          else 
          begin 
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
    end; 

------------------------------------------------------------------------

Вариант 2:

Source: Vingrad.ru <https://forum.vingrad.ru>

А вот какой способ предложен для нахождения собственного IP рассылкой
мастеров дельфи <https://Subscribe.Ru/catalog/comp.soft.prog.mdelphi>:

    var
      WSAData: TWSAData;
      SockAddrIn: TSockAddrIn;
      Host: PHostEnt;
      // Эти переменные объявлены в Winsock.pas
    begin
      if WSAStartup($101, WSAData) = 0 then begin
        Host := GetHostByName(@Localname[1]);
        if Host<>nil then begin
          SockAddrIn.sin_addr.S_addr:= longint(plongint(Host^.h_addr_list^)^);
          LocalIP := inet_ntoa(SockAddrIn.sin_addr);
        end;
        WSACleanUp;
      end;
    end;

