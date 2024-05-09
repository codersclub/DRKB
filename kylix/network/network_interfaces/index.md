---
Title: Информация о сетевых интерфейсах
Author: pve
Date: 01.01.2007
Source: Исходники.Ru <https://forum.sources.ru/>
---


Информация о сетевых интерфейсах
================================

    unit netinfo;
     
    interface
    uses Libc;
     
    type
      INTERFACE_INFO = packed record
        Name: string;
        IPAddress: string;
        Broadcast: string;
        NetMask: string;
        IsUp: boolean;
        IsRun: boolean;
        IsBroadcast: boolean;
        IsMulticast: boolean;
        IsLoopBack: boolean;
        IsPPP: boolean;
      end;
     
      TAInfo = record
        INFO: array of INTERFACE_INFO;
      end;
     
    function EnumInterfaces(var IInfo: TAInfo): Boolean;
     
    implementation
     
    function EnumInterfaces(var IInfo: TAInfo): Boolean;
    var SHandle: integer;
      len: longint;
      bufChar;
      ifc: ifconf;
      pifr: pifreq;
      ifr: ifreq;
      lastlen, i: integer;
      pAddrChar;
    begin
      Result := False;
      //создать UDP сокет
      SHandle := Socket(AF_INET, SOCK_DGRAM, 0);
      if SHandle = INVALID_SOCKET then exit;
     
    {
    При вызове SIOCGIFCONF некоторые реализации
    не возвращают ошибок, если буфер слишком мал
    для хранения результата вызова (результат просто обрезается)
    Поэтому надо сделать вызов, запомнить возвращенную длину,
    увеличить буфер и сделать еще один вызов
    ксли после этого вызова длины будут равны - OK!
    иначе надо циклично увеличивать буфер.
    }
      lastlen := 0;
      len := 100 * sizeof(ifreq);
     
      while true do
        begin
          buf := Malloc(len);
          ifc.ifc_len := len;
          PChar(ifc.ifc_ifcu) := buf;
          if ioctl(SHandle, SIOCGIFCONF, @ifc) < 0 then
            begin
              if (errno <> EINVAL) and (lastlen <> 0) then
                warn('ioctl error');
            end
          else
            begin
              if ifc.ifc_len = lastlen then break;
              lastlen := ifc.ifc_len;
            end;
          len := len + 10 * sizeof(ifreq);
          free(buf);
        end;
      Result := True;
      //здесь результат получен полностью
      //len - кол-во интерфейсов
      len := ifc.ifc_len div sizeof(ifreq);
      SetLength(IInfo.Info, len);
     
      //указатель - на начало буфера
      pifr := ifc.ifc_ifcu.ifcu_req;
      for i := 0 to len - 1 do
        begin
          fillchar(ifr, sizeof(ifreq), 0);
          //считать очередную порцию данных
          move(pifr^, ifr, sizeof(ifreq));
     
          //имя интерфейса
          IInfo.INFO[i].Name := ifr.ifrn_name;
          //адрес интерфейса
          pAddr := inet_ntoa(ifr.ifru_addr.sin_addr);
          IInfo.INFO[i].IPAddress := pAddr;
     
          //ШВ адрес
          ioctl(SHandle, SIOCGIFBRDADDR, @ifr);
          pAddr := inet_ntoa(ifr.ifru_netmask.sin_addr);
          IInfo.INFO[i].Broadcast := pAddr;
     
          //маска сети
          ioctl(SHandle, SIOCGIFNETMASK, @ifr);
          pAddr := inet_ntoa(ifr.ifru_netmask.sin_addr);
          IInfo.INFO[i].NetMask := pAddr;
     
          //флаги
          ioctl(SHandle, SIOCGIFFLAGS, @ifr);
     
          IInfo.INFO[i].IsUP := (ifr.ifru_flags and IFF_UP) = IFF_UP;
          IInfo.INFO[i].IsRun := (ifr.ifru_flags and IFF_RUNNING) = IFF_RUNNING;
          IInfo.INFO[i].IsBroadcast := (ifr.ifru_flags and IFF_BROADCAST) = IFF_BROADCAST;
          IInfo.INFO[i].IsLoopBack := (ifr.ifru_flags and IFF_LOOPBACK) = IFF_LOOPBACK;
          IInfo.INFO[i].IsPPP := (ifr.ifru_flags and IFF_POINTOPOINT) = IFF_POINTOPOINT;
          IInfo.INFO[i].IsMulticast := (ifr.ifru_flags and IFF_MULTICAST) = IFF_MULTICAST;
     
          inc(pifr);
        end;
     
    end;
    end.

