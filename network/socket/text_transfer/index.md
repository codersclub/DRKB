---
Title: Прием текста, передаваемого с помощью метода SendText
Author: VID, snap@iwt.ru
Date: 30.09.2002
---


Прием текста, передаваемого с помощью метода SendText
=====================================================

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Приём и обработка пакетов переданных методом SendText() - с учётом "склеенных" и полученных неполностью пакетов.
     
    Юнит RecvPckt предназначен для приёма текста, передаваемого с помощью метода SendText
    объекта Socket:TCustomWinSocket. Данный юнит может использоваться как клиентом так
    и сервером для обработки принятого пакета.
     
    Функции юнита предусматривают возможность получения "склеенных" пакетов,
    или пакетов, пришедших не полностью.
     
    Тип TBuffer;
    FBuffer - хранит в себе принимаемый пакет
    FCurrentPacketSize = хранит сведения о полной длине принимаемого пакета.
     
    Описание функций и процедур, необходимых для использования в других юнитах
     
    Procedure ClearBuffer(var ABuffer:TBuffer);
    Очищает буффер FBuffer и обнуляет значение FCurrentPacketSize;
     
    Function ProcessReceivedPacket(var ABuffer:TBuffer; var APacket:String):Boolean;
    В данную функцию передаётся полученный от клиента/сервера пакет, через аргумент APacket
    Принцип работы этой функции заключается в накоплении получаемого текста в поле
    FBuffer объекта ABuffer. В случае когда FBuffer будет содержать полностью весь пакет,
    функция возвратит True, иначе возвращает False
     
    Функция ОТПРАВКИ текста:
     
    Function SendTextToSocket(Socket:TCustomWinSocket; const Text:String):Integer;
    begin
    Result := -1;
    IF Text = '' then exit;
    IF Socket.Connected then
    Result := Socket.SendText(IntToStr(Length(Text))+'#'+Text);
    end;
     
    Зависимости: sysutils
    Автор:       VID, snap@iwt.ru, ICQ:132234868, Махачкала
    Copyright:   VID
    Дата:        30 сентября 2002 г.
    ********************************************** }
     
    unit RecvPckt;
     
    interface
     
    uses
      SysUtils;
     
    Type
      TReadHeaderResult = record
        FPacketSize:Integer;
        FPacketSizeStr:String;
        FTextStartsAt:Integer;
      end;
     
      TBuffer = record
        FBuffer:String;
        FHeaderBuffer:String;
        FCurrentPacketSize:Integer;
      end;
     
      Procedure ClearBuffer(var ABuffer:TBuffer);
      Function ReadHeader(var ABuffer:TBuffer; var APacket:String):TReadHeaderResult;
      Function ProcessReceivedPacket(var ABuffer:TBuffer; var APacket:String):Boolean;
     
    implementation
     
    Procedure ClearBuffer(var ABuffer:TBuffer);
    begin
      With ABuffer do
      begin
        FBuffer := '';
        FHeaderBuffer := '';
        FCurrentPacketSize := 0;
      end;
    end;
     
    Function ReadHeader(var ABuffer:TBuffer; var APacket:String):TReadHeaderResult;
    Var X:Integer;
     
      Procedure ClearHeader;
      begin
        ABuffer.FHeaderBuffer := '';
      end;
     
      Function CorrectPacket:Boolean;
      Var I,L:Integer;
      begin
        X:=0; L:=Length(APacket);
        FOR I:=1 TO L DO
          IF (APacket[I] in ['0'..'9']) then Break
          else
            IF (APacket[I]='#') and (ABuffer.FHeaderBuffer<>'') then Break
            else X:=I;
        IF X>0 then Delete(APacket, 1, X);
        Result := APacket <> '';
      end;
     
      Procedure GetHeader;
      Var I,L:Integer;
      begin
        L:=Length(APacket); X:=0;
        FOR I:=1 TO L DO
        begin
          X:=I;
          IF (APacket[I] in ['0'..'9']) then
          begin
            Insert(APacket[I], ABuffer.FHeaderBuffer, Length(ABuffer.FHeaderBuffer)+1);
          end else Break;
        end;
      end;
     
      Procedure SetResultToNone;
      begin
        With Result do
        begin
          FPacketSize := 0;
          FTextStartsAt := 0;
          FPacketSizeStr := '';
        end;
      end;
     
    begin
      SetResultToNone;
      IF APacket = '' then Exit;
      IF ABuffer.FCurrentPacketSize > 0 then
      begin
        With Result do
        begin
          FPacketSize := ABuffer.FCurrentPacketSize;
          FPacketSizeStr := IntToStr(ABuffer.FCurrentPacketSize);
          FTextStartsAt := 1;
        end;
        Exit;
      end;
      IF not CorrectPacket then Exit;
      GetHeader;
      IF APacket[X]='#' then
      begin
        Inc(X);
        Try
          Result.FPacketSize := StrToInt(ABuffer.FHeaderBuffer);
        except end;
        Result.FPacketSizeStr := ABuffer.FHeaderBuffer; ClearHeader;
      end else
        IF not (APacket[X] in ['0'..'9']) then ClearHeader;
      Result.FTextStartsAt := X;
    end;
     
    Function ProcessReceivedPacket(var ABuffer:TBuffer; var APacket:String):Boolean;
    Var ReadHeaderResult:TReadHeaderResult;
        NeedToCopy, DelSize:Integer;
        S:String;
     
        Function FullPacket:Boolean;
        begin
          With ABuffer do Result := Length(FBuffer) = FCurrentPacketSize;
        end;
     
    begin
      Result := True;
      IF APacket = '' then Exit;
      IF ABuffer.FBuffer = '' then
      begin
        ReadHeaderResult := ReadHeader(ABuffer, APacket);
        ABuffer.FCurrentPacketSize := ReadHeaderResult.FPacketSize;
        S:=Copy(APacket, ReadHeaderResult.FTextStartsAt, ReadHeaderResult.FPacketSize);
        DelSize := Length(ReadHeaderResult.FPacketSizeStr)+ReadHeaderResult.FPacketSize+1;
      end else
      begin
        With ABuffer do NeedToCopy := FCurrentPacketSize - Length(FBuffer);
        S:=Copy(APacket, 1, NeedToCopy);
        DelSize := NeedToCopy;
      end;
      With ABuffer do
        IF FCurrentPacketSize > 0 then Insert(S, FBuffer, Length(FBuffer)+1);
      IF not FullPacket then Result := False;
      IF ABuffer.FHeaderBuffer = '' then
        Delete(APacket, 1, DelSize)
      else begin APacket := ''; Result := False; end;
    end;
     
    end.

Пример использования:

    Var GBuffer:TBuffer; //Объявляем переменную типа TBuffer. Для каждого клиента на сервере должна быть объявлена отдельная переменная этого типа
    ...
     
    procedure TForm1.ServerClientRead(Sender: TObject;
      Socket: TCustomWinSocket);
    VAR S:String;
    begin
      S:=Socket.ReceiveText;
      REPEAT
        IF ProcessReceivedPacket(GBuffer, S) then
          IF GBuffer.FBuffer <> '' then
            try
              Recv.Lines.Add(GBuffer.FBuffer);
              //Или же передать GBuffer.FBuffer на исполнение.
            finally
              ClearBuffer(GBuffer);
            end;
      UNTIL S='';
    end
