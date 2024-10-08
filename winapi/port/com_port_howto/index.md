---
Title: Работа с последовательными портами
Date: 01.01.2007
---


Работа с последовательными портами
==================================

Вариант 1:

    //{$DEFINE COMM_UNIT}
     
    //Простой пример работы с последовательными портами
    //Код содержит интуитивно понятные комментарии и строки на шведском языке,
    //нецелесообразные для перевода.
    //Compiler maakt Simple_Comm.Dll of Simple_Com.Dcu afhankelijk van 1e Regel
    (COMM_UNIT)
     
    {$IFNDEF COMM_UNIT}
    library Simple_Comm;
    {$ELSE}
    unit Simple_Comm;
    interface
    {$ENDIF}
     
    uses Windows, Messages;
     
    const
      M_BaudRate = 1;
    const
      M_ByteSize = 2;
    const
      M_Parity = 4;
    const
      M_Stopbits = 8;
     
    {$IFNDEF COMM_UNIT}
    {$R Script2.Res} //versie informatie
    {$ENDIF}
     
    {$IFDEF COMM_UNIT}
    function Simple_Comm_Info: PChar; StdCall;
    function Simple_Comm_Open(Port: PChar; BaudRate: DWORD;
        ByteSize, Parity, StopBits: Byte;
        Mask: Integer; WndHandle: HWND; WndCommand: UINT;
        var Id: Integer): Integer; StdCall;
    function Simple_Comm_Close(Id: Integer): Integer; StdCall;
    function Simple_Comm_Write(Id: Integer; Buffer: PChar; Count: DWORD):
             Integer; StdCall;
    function Simple_Comm_PortCount: DWORD; StdCall;
     
    const
      M_None = 0;
    const
      M_All = 15;
     
    implementation
    {$ENDIF}
     
    const
      InfoString = 'Simple_Comm.Dll (c) by E.L. Lagerburg 1997';
    const
      MaxPorts = 5;
     
    const
      bDoRun: array[0..MaxPorts - 1] of boolean
        = (False, False, False, False, False);
    const
      hCommPort: array[0..MaxPorts - 1] of Integer = (0, 0, 0, 0, 0);
    const
      hThread: array[0..MaxPorts - 1] of Integer = (0, 0, 0, 0, 0);
    const
      dwThread: array[0..MaxPorts - 1] of Integer = (0, 0, 0, 0, 0);
    const
      hWndHandle: array[0..MaxPorts - 1] of Hwnd = (0, 0, 0, 0, 0);
    const
      hWndCommand: array[0..MaxPorts - 1] of UINT = (0, 0, 0, 0, 0);
    const
      PortCount: Integer = 0;
     
    function Simple_Comm_Info: PChar; stdcall;
    begin
      Result := InfoString;
    end;
     
    //Thread functie voor lezen compoort
     
    function Simple_Comm_Read(Param: Pointer): Longint; stdcall;
    var
      Count: Integer;
      id: Integer;
      ReadBuffer: array[0..127] of byte;
    begin
      Id := Integer(Param);
      while bDoRun[id] do
      begin
        ReadFile(hCommPort[id], ReadBuffer, 1, Count, nil);
        if (Count > 0) then
        begin
          if ((hWndHandle[id] <> 0) and
            (hWndCommand[id] > WM_USER)) then
            SendMessage(hWndHandle[id], hWndCommand[id], Count, LPARAM(@ReadBuffer));
        end;
      end;
      Result := 0;
    end;
     
    //Export functie voor sluiten compoort
    function Simple_Comm_Close(Id: Integer): Integer; stdcall;
    begin
      if (ID < 0) or (id > MaxPorts - 1) or (not bDoRun[Id]) then
      begin
        Result := ERROR_INVALID_FUNCTION;
        Exit;
      end;
      bDoRun[Id] := False;
      Dec(PortCount);
      FlushFileBuffers(hCommPort[Id]);
      if not
        PurgeComm(hCommPort[Id], PURGE_TXABORT + PURGE_RXABORT +
          PURGE_TXCLEAR + PURGE_RXCLEAR) then
      begin
        Result := GetLastError;
        Exit;
      end;
      if WaitForSingleObject(hThread[Id], 10000) = WAIT_TIMEOUT then
        if not TerminateThread(hThread[Id], 1) then
        begin
          Result := GetLastError;
          Exit;
        end;
     
      CloseHandle(hThread[Id]);
      hWndHandle[Id] := 0;
      hWndCommand[Id] := 0;
      if not CloseHandle(hCommPort[Id]) then
      begin
        Result := GetLastError;
        Exit;
      end;
      hCommPort[Id] := 0;
      Result := NO_ERROR;
    end;
     
    procedure Simple_Comm_CloseAll; stdcall;
    var
      Teller: Integer;
    begin
      for Teller := 0 to MaxPorts - 1 do
      begin
        if bDoRun[Teller] then
          Simple_Comm_Close(Teller);
      end;
    end;
     
    function GetFirstFreeId: Integer; stdcall;
    var
      Teller: Integer;
    begin
      for Teller := 0 to MaxPorts - 1 do
      begin
        if not bDoRun[Teller] then
        begin
          Result := Teller;
          Exit;
        end;
      end;
      Result := -1;
    end;
     
    //Export functie voor openen compoort
     
    function Simple_Comm_Open(Port: PChar; BaudRate: DWORD;
        ByteSize, Parity,
        StopBits: Byte; Mask: Integer; WndHandle: HWND; WndCommand: UINT;
        var Id: Integer): Integer; stdcall;
     
    var
      PrevId: Integer;
      ctmoCommPort: TCOMMTIMEOUTS; //Lees specificaties voor de compoort
      dcbCommPort: TDCB;
    
    begin
      if (PortCount >= MaxPorts) or (PortCount < 0) then
      begin
        result := error_invalid_function;
        exit;
      end;
      result := 0;
      previd := id;
      id := getfirstfreeid;
      if id = -1 then
      begin
        id := previd;
        result := error_invalid_function;
        exit;
      end;
      hcommport[id] := createfile(port, generic_read or
        generic_write, 0, nil, open_existing, file_attribute_normal, 0);
     
      if hcommport[id] = invalid_handle_value then
      begin
        bdorun[id] := false;
        id := previd;
        result := getlasterror;
        exit;
      end;
      //lees specificaties voor het comm bestand
      ctmocommport.readintervaltimeout := maxdword;
      ctmocommport.readtotaltimeoutmultiplier := maxdword;
      ctmocommport.readtotaltimeoutconstant := maxdword;
      ctmocommport.writetotaltimeoutmultiplier := 0;
      ctmocommport.writetotaltimeoutconstant := 0;
      //instellen specificaties voor het comm bestand
      if not setcommtimeouts(hcommport[id], ctmocommport) then
      begin
        bdorun[id] := false;
        closehandle(hcommport[id]);
        id := previd;
        result := getlasterror;
        exit;
      end;
      //instellen communicatie
      dcbcommport.dcblength := sizeof(tdcb);
      if not getcommstate(hcommport[id], dcbcommport) then
      begin
        bdorun[id] := false;
        closehandle(hcommport[id]);
        id := previd;
        result := getlasterror;
        exit;
      end;
      if (mask and m_baudrate <> 0) then
        dcbCommPort.BaudRate := BaudRate;
      if (Mask and M_ByteSize <> 0) then
        dcbCommPort.ByteSize := ByteSize;
      if (Mask and M_Parity <> 0) then
        dcbCommPort.Parity := Parity;
      if (Mask and M_Stopbits <> 0) then
        dcbCommPort.StopBits := StopBits;
      if not SetCommState(hCommPort[Id], dcbCommPort) then
      begin
        bDoRun[Id] := FALSE;
        CloseHandle(hCommPort[Id]);
        Id := PrevId;
        Result := GetLastError;
        Exit;
      end;
      //Thread voor lezen compoort
      bDoRun[Id] := TRUE;
      hThread[Id] := CreateThread(nil, 0, @Simple_Comm_Read, Pointer(Id), 0,
        dwThread[Id]
        );
     
      if hThread[Id] = 0 then
      begin
        bDoRun[Id] := FALSE;
        CloseHandle(hCommPort[Id]);
        Id := PrevId;
        Result := GetLastError;
        Exit;
      end
      else
      begin
        SetThreadPriority(hThread[Id], THREAD_PRIORITY_HIGHEST);
        hWndHandle[Id] := WndHandle;
        hWndCommand[Id] := WndCommand;
        Inc(PortCount);
        Result := NO_ERROR;
      end;
    end;
     
    //Export functie voor schrijven naar compoort;
    function Simple_Comm_Write(Id: Integer; Buffer: PChar; Count: DWORD):
             Integer; stdcall;
    var
      Written: DWORD;
    begin
      if (Id < 0) or (id > Maxports - 1) or (not bDoRun[Id]) then
      begin
        Result := ERROR_INVALID_FUNCTION;
        Exit;
      end;
      if not WriteFile(hCommPort[Id], Buffer, Count, Written, nil) then
      begin
        Result := GetLastError();
        Exit;
      end;
      if (Count <> Written) then
        Result := ERROR_WRITE_FAULT
      else
        Result := NO_ERROR;
    end;
     
    //Aantal geopende poorten voor aanroepende applicatie
    function Simple_Comm_PortCount: DWORD; stdcall;
    begin
      Result := PortCount;
    end;
     
    {$IFNDEF COMM_UNIT}
    exports
     
      Simple_Comm_Info Index 1,
      Simple_Comm_Open Index 2,
      Simple_Comm_Close Index 3,
      Simple_Comm_Write Index 4,
      Simple_Comm_PortCount index 5;
     
    procedure DLLMain(dwReason: DWORD);
    begin
      if dwReason = DLL_PROCESS_DETACH then
        Simple_Comm_CloseAll;
    end;
     
    begin
      DLLProc := @DLLMain;
      DLLMain(DLL_PROCESS_ATTACH); //geen nut in dit geval
    end.
     
    {$ELSE}
    initialization
    finalization
     
      Simple_Comm_CloseAll;
    end.
    {$ENDIF}

------------------------------------------------------------

Вариант 2:

Source: <https://delphiworld.narod.ru>

Другое решение: создание модуля I/O (ввода / вывода)под Windows 95/NT.

Вот он:


    (с TDCB в SetCommStatus вы можете управлять DTR и т.д.)
    (Примечание: XonLim и XoffLim не должны быть больше 600, иначе под NT это
      работает неправильно)
     
    unit My_IO;
     
    interface
     
    function OpenComm(InQueue, OutQueue, Baud: LongInt): Boolean;
    function SetCommTiming: Boolean;
    function SetCommBuffer(InQueue, OutQueue: LongInt): Boolean;
    function SetCommStatus(Baud: Integer): Boolean;
    function SendCommStr(S: string): Integer;
    function ReadCommStr(var S: string): Integer;
    procedure CloseComm;
     
    var
      ComPort: Word;
     
    implementation
     
    uses Windows, SysUtils;
     
    const
      CPort: array[1..4] of string = ('COM1', 'COM2', 'COM3', 'COM4');
     
    var
      Com: THandle = 0;
     
    function OpenComm(InQueue, OutQueue, Baud: LongInt): Boolean;
    begin
      if Com > 0 then
        CloseComm;
      Com := CreateFile(PChar(CPort[ComPort]),
        GENERIC_READ or GENERIC_WRITE,
        0, nil, OPEN_EXISTING, FILE_ATTRIBUTE_NORMAL, 0);
      Result := (Com > 0) and SetCommTiming and
        SetCommBuffer(InQueue, OutQueue) and
        SetCommStatus(Baud);
    end;
     
    function SetCommTiming: Boolean;
    var
      Timeouts: TCommTimeOuts;
     
    begin
      with TimeOuts do
      begin
        ReadIntervalTimeout := 1;
        ReadTotalTimeoutMultiplier := 0;
        ReadTotalTimeoutConstant := 1;
        WriteTotalTimeoutMultiplier := 2;
        WriteTotalTimeoutConstant := 2;
      end;
      Result := SetCommTimeouts(Com, Timeouts);
    end;
     
    function SetCommBuffer(InQueue, OutQueue: LongInt): Boolean;
    begin
      Result := SetupComm(Com, InQueue, OutQueue);
    end;
     
    function SetCommStatus(Baud: Integer): Boolean;
    var
      DCB: TDCB;
     
    begin
      with DCB do
      begin
        DCBlength := SizeOf(Tdcb);
        BaudRate := Baud;
        Flags := 12305;
        wReserved := 0;
        XonLim := 600;
        XoffLim := 150;
        ByteSize := 8;
        Parity := 0;
        StopBits := 0;
        XonChar := #17;
        XoffChar := #19;
        ErrorChar := #0;
        EofChar := #0;
        EvtChar := #0;
        wReserved1 := 65;
      end;
      Result := SetCommState(Com, DCB);
    end;
     
    function SendCommStr(S: string): Integer;
    var
      TempArray: array[1..255] of Byte;
      Count, TX_Count: Integer;
     
    begin
      for Count := 1 to Length(S) do
        TempArray[Count] := Ord(S[Count]);
      WriteFile(Com, TempArray, Length(S), TX_Count, nil);
      Result := TX_Count;
    end;
     
    function ReadCommStr(var S: string): Integer;
    var
      TempArray: array[1..255] of Byte;
      Count, RX_Count: Integer;
     
    begin
      S := '';
      ReadFile(Com, TempArray, 255, RX_Count, nil);
      for Count := 1 to RX_Count do
        S := S + Chr(TempArray[Count]);
      Result := RX_Count;
    end;
     
    procedure CloseComm;
    begin
      CloseHandle(Com);
      Com := -1;
    end;
     
    end.

