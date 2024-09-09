---
Title: Write / read a string to / from the serial port
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Write / read a string to / from the serial port
===============================================

    function OpenCOMPort: Boolean;
    var
      DeviceName: array[0..80] of Char;
      ComFile: THandle;
    begin
      { First step is to open the communications device for read/write.
        This is achieved using the Win32 'CreateFile' function.
        If it fails, the function returns false.
      }
      StrPCopy(DeviceName, 'COM1:');
     
      ComFile := CreateFile(DeviceName,
        GENERIC_READ or GENERIC_WRITE,
        0,
        nil,
        OPEN_EXISTING,
        FILE_ATTRIBUTE_NORMAL,
        0);
     
      if ComFile = INVALID_HANDLE_VALUE then
        Result := False
      else
        Result := True;
    end;
     
     
    function SetupCOMPort: Boolean;
    const
      RxBufferSize = 256;
      TxBufferSize = 256;
    var
      DCB: TDCB;
      Config: string;
      CommTimeouts: TCommTimeouts;
    begin
      { We assume that the setup to configure the setup works fine.
        Otherwise the function returns false.
      }
     
      Result := True;
     
      if not SetupComm(ComFile, RxBufferSize, TxBufferSize) then
        Result := False;
     
      if not GetCommState(ComFile, DCB) then
        Result := False;
     
      Config := 'baud=9600 parity=n data=8 stop=1';
     
      if not BuildCommDCB(@Config[1], DCB) then
        Result := False;
     
      if not SetCommState(ComFile, DCB) then
        Result := False;
     
      with CommTimeouts do
      begin
        ReadIntervalTimeout         := 0;
        ReadTotalTimeoutMultiplier  := 0;
        ReadTotalTimeoutConstant    := 1000;
        WriteTotalTimeoutMultiplier := 0;
        WriteTotalTimeoutConstant   := 1000;
      end;
     
      if not SetCommTimeouts(ComFile, CommTimeouts) then
        Result := False;
    end;
     
     
    {
      The following is an example of using the 'WriteFile' function
      to write data to the serial port.
    }
     
     
    procedure SendText(s: string);
    var
      BytesWritten: DWORD;
    begin
       {
         Add a word-wrap (#13 + #10) to the string
       }
      s := s + #13 + #10;
      WriteFile(ComFile, s[1], Length(s), BytesWritten, nil);
    end;
     
     
    {
      The following is an example of using the 'ReadFile' function to read
      data from the serial port.
    }
     
     
    procedure ReadText: string;
    var
      d: array[1..80] of Char;
      s: string;
      BytesRead, i: Integer;
    begin
      Result := '';
      if not ReadFile(ComFile, d, SizeOf(d), BytesRead, nil) then
      begin
        { Raise an exception }
      end;
      s := '';
      for i := 1 to BytesRead do s := s + d[I];
      Result := s;
    end;
     
     
    procedure CloseCOMPort;
    begin
      // finally close the COM Port!
      CloseHandle(ComFile);
    end;

