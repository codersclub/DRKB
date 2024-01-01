---
Title: Как сделать Ping?
Date: 01.01.2007
---


Как сделать Ping?
=================

::: {.date}
01.01.2007
:::

Протокол Ping предназначен для тестирования компьютерных соединений в
Интернете путём посылки через протокол Internet Protocol (IP) по
обределённому адресу сообщения и ожидания от него ответа.

ICMP - Internet Control Message Protocol. ICMP служит для передачи
сообщений об ошибках а так же управляющих сообщений . ICMP-тест может
показать насколько быстро проходит информация между двумя узлами в
Интернете.

1. Запускаем Delphi;

2. В Новом проекте добавляем в форму Tbutton, Tedit и Tmemo;

3. Вставляем "winsock";

4. объявляем структурку для IP-заголовка:

    type
      IPINFO = record
        Ttl: char;
        Tos: char;
        IPFlags: char;
        OptSize: char;
        Options: ^char;
      end;

5. объявляем структурку для хранения ICMP пакета:

    type
      ICMPECHO = record
        Source: longint;
        Status: longint;
        RTTime: longint;
        DataSize: Shortint;
        Reserved: Shortint;
        pData: ^variant;
        i_ipinfo: IPINFO;
      end;

6. Объявляем функции и процедуры, которые мы будем вызывать из ICMP.DLL

    TIcmpCreateFile = function():integer; {$IFDEF WIN32} stdcall; {$ENDIF} 
    TIcmpCloseHandle = procedure(var handle:integer);{$IFDEF WIN32} stdcall; {$ENDIF} 
    TIcmpSendEcho = function(var handle:integer; endereco:DWORD; buffer:variant; tam:WORD; IP:IPINFO; ICMP:ICMPECHO; tamicmp:DWORD; tempo:DWORD):DWORD;{$IFDEF WIN32} stdcall; {$ENDIF} 

7. В Tbutton в событие Onclick вставляем следующий код:

    procedure TForm1.Button1Click(Sender: TObject);
    var
      wsadt: wsadata;
      icmp: icmpecho;
      HNDicmp: integer;
      hndFile: integer;
      Host: PHostEnt;
      Destino: in_addr;
      Endereco: ^DWORD;
      IP: ipinfo;
      Retorno: integer;
      dwRetorno: DWORD;
      x: integer;
     
      IcmpCreateFile: TIcmpCreateFile;
      IcmpCloseHandle: TIcmpCloseHandle;
      IcmpSendEcho: TIcmpSendEcho;
     
    begin
      if (edit1.Text = '') then
        begin
          Application.MessageBox('Enter a HostName ro a IP Adress',
            'Error', MB_OK);
          exit;
        end;
      HNDicmp := LoadLibrary('ICMP.DLL');
      if (HNDicmp <> 0) then
        begin
          @IcmpCreateFile := GetProcAddress(HNDicmp, 'IcmpCreateFile');
          @IcmpCloseHandle := GetProcAddress(HNDicmp, 'IcmpCloseHandle');
          @IcmpSendEcho := GetProcAddress(HNDicmp, 'IcmpSendEcho');
          if (@IcmpCreateFile = nil) or (@IcmpCloseHandle = nil) or (@IcmpSendEcho = nil) then
            begin
              Application.MessageBox('Error getting ICMP Adress', 'Error', MB_OK);
              FreeLibrary(HNDicmp);
            end;
        end;
      Retorno := WSAStartup($0101, wsadt);
     
      if (Retorno <> 0) then
        begin
          Application.MessageBox('Canґt Load WinSockets', 'WSAStartup', MB_OK);
          WSACleanup();
          FreeLibrary(HNDicmp);
        end;
     
      Destino.S_addr := inet_addr(Pchar(Edit1.text));
      if (Destino.S_addr = 0) then
        begin
          Host := GetHostbyName(PChar(Edit1.text));
        end
      else
        begin
          Host := GetHostbyAddr(@Destino, sizeof(in_addr), AF_INET);
        end;
     
      if (host = nil) then
        begin
          Application.MessageBox('Host not found', 'Error', MB_OK);
          WSACleanup();
          FreeLibrary(HNDicmp);
          exit;
        end;
      memo1.Lines.Add('Pinging ' + Edit1.text);
     
      Endereco := @Host.h_addr_list;
     
      HNDFile := IcmpCreateFile();
      for x := 0 to 4 do
        begin
          Ip.Ttl := char(255);
          Ip.Tos := char(0);
          Ip.IPFlags := char(0);
          Ip.OptSize := char(0);
          Ip.Options := nil;
     
          dwRetorno := IcmpSendEcho(
            HNDFile,
            Endereco^,
            null,
            0,
            Ip,
            Icmp,
            sizeof(Icmp),
            DWORD(5000));
          Destino.S_addr := icmp.source;
          Memo1.Lines.Add('Ping ' + Edit1.text);
        end;
     
      IcmpCLoseHandle(HNDFile);
      FreeLibrary(HNDicmp);
      WSACleanup();
    end;

У данного примера есть один недостаток - программа не воспримет доменное
имя, только IP-адресс. Для пользователей NT не используйте функцию
IcmpCloseHandle.

Это всё.....

Ну и в конце полный исходный код примера:

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      winsock, StdCtrls;
     
    type
      IPINFO = record
        Ttl: char;
        Tos: char;
        IPFlags: char;
        OptSize: char;
        Options: ^char;
      end;
     
    type
      ICMPECHO = record
        Source: longint;
        Status: longint;
        RTTime: longint;
        DataSize: Shortint;
        Reserved: Shortint;
        pData: ^variant;
        i_ipinfo: IPINFO;
      end;
     
      TIcmpCreateFile = function(): integer; {$IFDEF WIN32}stdcall; {$ENDIF}
      TIcmpCloseHandle = procedure(var handle: integer); {$IFDEF WIN32}stdcall; {$ENDIF}
      TIcmpSendEcho = function(var handle: integer; endereco: DWORD; buffer: variant; tam: WORD; IP: IPINFO; ICMP: ICMPECHO; tamicmp: DWORD; tempo: DWORD): DWORD; {$IFDEF WIN32}stdcall; {$ENDIF}
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
        Button2: TButton;
        Edit1: TEdit;
        Memo1: TMemo;
        procedure Button1Click(Sender: TObject);
        procedure Button2Click(Sender: TObject);
      private
    { Private declarations }
      public
     
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      wsadt: wsadata;
      icmp: icmpecho;
      HNDicmp: integer;
      hndFile: integer;
      Host: PHostEnt;
      Destino: in_addr;
      Endereco: ^DWORD;
      IP: ipinfo;
      Retorno: integer;
      dwRetorno: DWORD;
      x: integer;
     
      IcmpCreateFile: TIcmpCreateFile;
      IcmpCloseHandle: TIcmpCloseHandle;
      IcmpSendEcho: TIcmpSendEcho;
     
    begin
      if (edit1.Text = '') then
        begin
          Application.MessageBox('Digite um HostName ou um End. IP',
            'Error', MB_OK);
          exit;
        end;
      HNDicmp := LoadLibrary('ICMP.DLL');
      if (HNDicmp <> 0) then
        begin
          @IcmpCreateFile := GetProcAddress(HNDicmp, 'IcmpCreateFile');
          @IcmpCloseHandle := GetProcAddress(HNDicmp, 'IcmpCloseHandle');
          @IcmpSendEcho := GetProcAddress(HNDicmp, 'IcmpSendEcho');
          if (@IcmpCreateFile = nil) or (@IcmpCloseHandle = nil) or (@IcmpSendEcho = nil) then
            begin
              Application.MessageBox('Erro pegando endereзos ICMP', 'Error', MB_OK);
              FreeLibrary(HNDicmp);
            end;
        end;
      Retorno := WSAStartup($0101, wsadt);
     
      if (Retorno <> 0) then
        begin
          Application.MessageBox('Nгo foi possнvel carregar WinSockets', 'WSAStartup', MB_OK);
          WSACleanup();
          FreeLibrary(HNDicmp);
        end;
     
      Destino.S_addr := inet_addr(Pchar(Edit1.text));
      if (Destino.S_addr = 0) then
        begin
          Host := GetHostbyName(PChar(Edit1.text));
        end
      else
        begin
          Host := GetHostbyAddr(@Destino, sizeof(in_addr), AF_INET);
        end;
     
      if (host = nil) then
        begin
          Application.MessageBox('Host nгo encontrado', 'Error', MB_OK);
          WSACleanup();
          FreeLibrary(HNDicmp);
          exit;
        end;
      memo1.Lines.Add('Pinging ' + Edit1.text);
     
      Endereco := @Host.h_addr_list;
     
      HNDFile := IcmpCreateFile();
      for x := 0 to 4 do
        begin
          Ip.Ttl := char(255);
          Ip.Tos := char(0);
          Ip.IPFlags := char(0);
          Ip.OptSize := char(0);
          Ip.Options := nil;
     
          dwRetorno := IcmpSendEcho(
            HNDFile,
            Endereco^,
            null,
            0,
            Ip,
            Icmp,
            sizeof(Icmp),
            DWORD(5000));
          Destino.S_addr := icmp.source;
          Memo1.Lines.Add('Pingou ' + Edit1.text);
        end;
     
      IcmpCLoseHandle(HNDFile);
      FreeLibrary(HNDicmp);
      WSACleanup();
    end;
     
    end.

Взято из <https://forum.sources.ru>
