---
Title: WhoIs, демо получения информации с WhoIs сервера
Author: Александр (Rouse_) Багель
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


WhoIs, демо получения информации с WhoIs сервера
================================================

    ////////////////////////////////////////////////////////////////////////////////
    //
    //  ****************************************************************************
    //  * Project Name : WhoIs
    //  * Unit Name    : uMain
    //  * Purpose      : Демонстрационный пример получения информации с WhoIs сервера.
    //  * Author       : Александр (Rouse_) Багель
    //  * Version      : 1.00
    //  ****************************************************************************
    //
     
    unit uMain;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls, ExtCtrls, Winsock;
     
    type
      TfrmMain = class(TForm)
        edServer: TLabeledEdit;
        edRecipient: TLabeledEdit;
        GroupBox1: TGroupBox;
        memReport: TMemo;
        Button1: TButton;
        procedure Button1Click(Sender: TObject);
      end;
     
    var
      frmMain: TfrmMain;
     
    implementation
     
    {$R *.dfm}
     
    function WhoIs(Server, Query: String; Timeout: Integer;
      var Response: TStringList): Boolean;
    const
      MAXBLOCKSIZE = 1024;
    var
      WSAData: TWSAData;
      hSocket: TSocket;
      Addr_in: sockaddr_in;
      Host: PHostEnt;
      InAddr, NoBlock: u_long;
      FDSet: TFDSet;
      Time: timeval;
      Buff: array [0..MAXBLOCKSIZE - 1] of Char;
      RecvCount: Integer;
    begin
      // инициализируем WinSock
      Result := WSAStartup(MakeWord(1, 0), WSAData) = NOERROR;
      if not Result then Exit;
      try
        // создаем сокет
        hSocket := socket(AF_INET, SOCK_STREAM, IPPROTO_TCP);
        if hSocket = INVALID_SOCKET then
        begin
          Result := False;
          Exit;
        end;
        try
          // Определяем, что ввел пользователь имя хоста или его адрес
          InAddr := inet_addr(PChar(Server));
          if InAddr = INADDR_NONE then
          begin
            Host := gethostbyname(PChar(Server));
            if not Assigned(Host) then
            begin
              Result := False;
              Exit;
            end;
            InAddr := PInAddr(Host.h_addr_list^)^.S_addr;
          end;
          // Подготавливаем структуру для соединения
          FillChar(Addr_in, SizeOf(sockaddr_in), 0);
          Addr_in.sin_addr.S_addr := InAddr;
          Addr_in.sin_family:= AF_INET;
          Addr_in.sin_port := htons(IPPORT_WHOIS);
          // Устанавливаем интервалы таймаута
          setsockopt(hSocket, SOL_SOCKET, SO_RCVTIMEO, @Timeout, SizeOf(Integer));
          setsockopt(hSocket, SOL_SOCKET, SO_SNDTIMEO, @Timeout, SizeOf(Integer));
          // Соединение с сервером - довольно долгий процесс, поэтому мы поступим по
          // хитрому - а именно переводим сокет в неблокирующий режим
          NoBlock := 1;
          ioctlsocket(hSocket, FIONBIO, NoBlock);
          // соединяемся
          if connect(hSocket, Addr_in, SizeOf(sockaddr_in)) = SOCKET_ERROR then
            case WSAGetLastError of
              // Обычно при неблокирующем соединении выдается вот эта ошибка
              // на попытку соединения, поэтому мы будем ждать окончания
              // соединения через select
              WSAEWOULDBLOCK:
              begin
                FD_ZERO(FDSet);
                FD_SET(hSocket, FDSet);
                Time.tv_sec := Timeout div 1000;
                Time.tv_usec := Timeout;
                if select(0, nil, @FDSet, nil, @Time) <> 1 then
                begin
                  Result := False;
                  Exit;
                end;
              end;
            else
              begin
                Result := False;
                Exit;
              end;
            end;
          // Соединились - теперь неблокирующий режим нам не нужен
          // Возвращаем все как было
          NoBlock := 0;
          ioctlsocket(hSocket, FIONBIO, NoBlock);
          // Обязательно проверяем чтобы в конце запроса стояло #13#10
          Query := Query + sLineBreak;
          // И отправляем запрос серверу
          if Send(hSocket, Query[1], Length(Query), 0) = SOCKET_ERROR then
          begin
            Result := False;
            Exit;
          end;
          // Запрос отправлен - начинаем читать данные пока не кончатся
          RecvCount := 1;
          while RecvCount > 0 do
          begin
            RecvCount := recv(hSocket, Buff, MAXBLOCKSIZE, 0);
            Response.Text := Response.Text + String(Buff);
          end;
        finally
          // Завершаем установленную сессию
          shutdown(hSocket, SD_BOTH);
          // Закрываем сокет
          closesocket(hSocket);
        end;
      finally
        // Деинициализируем WinSock
        WSACleanup;
      end;
    end;
     
    procedure TfrmMain.Button1Click(Sender: TObject);
    var
      S: TStringList;
    begin
      S := TStringList.Create;
      try
        // edServer.Text = whois.alldomains.com
        // edRecipient.Text = borland.com
        WhoIs(edServer.Text, edRecipient.Text, 10000, S);
        memReport.Lines.Assign(S);
      finally
        S.Free;
      end;
    end;
     
    end.



Проект также доступен по адресу: <http://rouse.drkb.ru/files/whois.zip>

