---
Title: Как вычислить IP-адрес по доменному имени?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как вычислить IP-адрес по доменному имени?
==========================================

    uses winsock;
    
    function IPAddrToName(IPAddr : String): String; 
    var 
      SockAddrIn: TSockAddrIn; 
      HostEnt: PHostEnt; 
      WSAData: TWSAData; 
    begin 
      WSAStartup($101, WSAData); 
      SockAddrIn.sin_addr.s_addr:= inet_addr(PChar(IPAddr)); 
      HostEnt:= gethostbyaddr(@SockAddrIn.sin_addr.S_addr, 4, AF_INET); 
      if HostEnt<>nil then 
      begin 
        result:=StrPas(Hostent^.h_name) 
      end 
      else 
      begin 
        result:=''; 
      end; 
    end; 

Пример использования:

    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      Label1.Caption:=IPAddrToName(Edit1.Text); 
    end;

