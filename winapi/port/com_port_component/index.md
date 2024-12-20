---
Title: Компонент для последовательного устройства (TRS232)
Date: 12.12.1998
Author: Angerer Bernhard
Source: <https://forum.sources.ru>
---


Компонент для последовательного устройства (TRS232)
===================================================

Компонент, который представлен здесь, выполняет функции синхронного
чтения и записи в последовательный интерфейс RS232.

В цикле выполняется Application.ProcessMessages, чтобы все сообщения от
основной программы обрабатывались.

    // ----------------------------------------------------------------------
    // | RS232 - Basic Driver for the RS232 port 1.0                        |
    // ----------------------------------------------------------------------
    // | © 1997 by Marco Cocco                                              |
    // | © 1998 by enhanced by Angerer Bernhard                             |
    // ----------------------------------------------------------------------
     
     
    unit uRS232;
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Forms,
      ExtCtrls;            // TTimer
     
    ////////////////////////////////////////////////////////////////////////////////
     
    type
      TReceiveDataEvent = procedure(Sender: TObject; Msg, lParam, wParam:longint) of object;
     
      // COM Port Baud Rates
      TComPortBaudRate = ( br110, br300, br600, br1200, br2400, br4800,
                           br9600, br14400, br19200, br38400, br56000,
                           br57600, br115200 );
      // COM Port Numbers
      TComPortNumber = ( pnCOM1, pnCOM2, pnCOM3, pnCOM4 );
      // COM Port Data bits
      TComPortDataBits = ( db5BITS, db6BITS, db7BITS, db8BITS );
      // COM Port Stop bits
      TComPortStopBits = ( sb1BITS, sb1HALFBITS, sb2BITS );
      // COM Port Parity
      TComPortParity = ( ptNONE, ptODD, ptEVEN, ptMARK, ptSPACE );
      // COM Port Hardware Handshaking
      TComPortHwHandshaking = ( hhNONE, hhRTSCTS );
      // COM Port Software Handshaing
      TComPortSwHandshaking = ( shNONE, shXONXOFF );
     
      TCommPortDriver = class(TComponent)
      private
        hTimer: TTimer;
        FActive: boolean;
        procedure SetActive(const Value: boolean);
      protected
        FComPortHandle             : THANDLE; // COM Port Device Handle
        FComPort                   : TComPortNumber; // COM Port to use (1..4)
        FComPortBaudRate           : TComPortBaudRate; // COM Port speed (brXXXX)
        FComPortDataBits           : TComPortDataBits; // Data bits size (5..8)
        FComPortStopBits           : TComPortStopBits; // How many stop bits to use
                                                       // (1,1.5,2)
        FComPortParity             : TComPortParity; // Type of parity to use
                                                     // (none,odd,even,mark,space)
        FComPortHwHandshaking      : TComPortHwHandshaking; // Type of hw
                                                            // handshaking to use
        FComPortSwHandshaking      : TComPortSwHandshaking; // Type of sw
                                                            // handshaking to use
        FComPortInBufSize          : word; // Size of the input buffer
        FComPortOutBufSize         : word; // Size of the output buffer
        FComPortReceiveData        : TReceiveDataEvent;
        FComPortPollingDelay       : word; // ms of delay between COM port pollings
        FTimeOut                   : integer; // sec until timeout
        FTempInBuffer              : pointer;
        procedure SetComPort( Value: TComPortNumber );
        procedure SetComPortBaudRate( Value: TComPortBaudRate );
        procedure SetComPortDataBits( Value: TComPortDataBits );
        procedure SetComPortStopBits( Value: TComPortStopBits );
        procedure SetComPortParity( Value: TComPortParity );
        procedure SetComPortHwHandshaking( Value: TComPortHwHandshaking );
        procedure SetComPortSwHandshaking( Value: TComPortSwHandshaking );
        procedure SetComPortInBufSize( Value: word );
        procedure SetComPortOutBufSize( Value: word );
        procedure SetComPortPollingDelay( Value: word );
        procedure ApplyCOMSettings;
        procedure TimerEvent(Sender: TObject); virtual;
      public
        constructor Create( AOwner: TComponent ); override;
        destructor  Destroy; override;
     
        function  Connect: boolean;    //override;
        function  Disconnect: boolean; //override;
        function  Connected: boolean;
     
        function SendData( DataPtr: pointer; DataSize: integer ): boolean;
        function SendString( aStr: string ): boolean; 
     
        // Event to raise when there is data available (input buffer has data)
        property OnReceiveData: TReceiveDataEvent read FComPortReceiveData
                                                  write FComPortReceiveData;
      published
        // Which COM Port to use
        property ComPort: TComPortNumber read FComPort write SetComPort
                                                       default pnCOM2;
        // COM Port speed (bauds)
        property ComPortSpeed: TComPortBaudRate read FComPortBaudRate
                               write SetComPortBaudRate default br9600;
        // Data bits to used (5..8, for the 8250 the use of 5 data bits with 2 stop
        // bits is an invalid combination, as is 6, 7, or 8 data bits with 1.5
        // stop bits)
        property ComPortDataBits: TComPortDataBits read FComPortDataBits
                                  write SetComPortDataBits default db8BITS;
        // Stop bits to use (1, 1.5, 2)
        property ComPortStopBits: TComPortStopBits read FComPortStopBits
                                  write SetComPortStopBits default sb1BITS;
        // Parity Type to use (none,odd,even,mark,space)
        property ComPortParity: TComPortParity read FComPortParity
                                write SetComPortParity default ptNONE;
        // Hardware Handshaking Type to use:
        //  cdNONE   no handshaking
        //  cdCTSRTS both cdCTS and cdRTS apply (This is the more common method)
        property ComPortHwHandshaking: TComPortHwHandshaking
          read FComPortHwHandshaking write SetComPortHwHandshaking default hhNONE;
        // Software Handshaking Type to use:
        //  cdNONE          no handshaking
        //  cdXONXOFF       XON/XOFF handshaking
        property ComPortSwHandshaking: TComPortSwHandshaking
          read FComPortSwHandshaking write SetComPortSwHandshaking default shNONE;
        // Input Buffer size
        property ComPortInBufSize: word read FComPortInBufSize
                                        write SetComPortInBufSize default 2048;
        // Output Buffer size
        property ComPortOutBufSize: word read FComPortOutBufSize
                                         write SetComPortOutBufSize default 2048;
        // ms of delay between COM port pollings
        property ComPortPollingDelay: word read FComPortPollingDelay
                                           write SetComPortPollingDelay default 100;
        property TimeOut: integer read FTimeOut write FTimeOut default 30;
     
        property Active: boolean read FActive write SetActive default false;
      end;
     
     
     
      TRS232 = class(TCommPortDriver)
      protected
      public
        // new comm parameters are set
        constructor Create( AOwner: TComponent ); override;
     
        // ReadStrings reads direct from the comm-buffer and waits for
        // more characters and handles the timeout
        function  ReadString(var aResStr: string; aCount: word ): boolean;
      published
      end;
     
     
    procedure Register;
     
    implementation
     
    procedure Register;
    begin
      RegisterComponents('Additional', [TRS232]);
    end;
     
    constructor TCommPortDriver.Create( AOwner: TComponent );
    begin
      inherited Create( AOwner );
      // Initialize to default values
      FComPortHandle             := 0;       // Not connected
      FComPort                   := pnCOM2;  // COM 2
      FComPortBaudRate           := br9600;  // 9600 bauds
      FComPortDataBits           := db8BITS; // 8 data bits
      FComPortStopBits           := sb1BITS; // 1 stop bit
      FComPortParity             := ptNONE;  // no parity
      FComPortHwHandshaking      := hhNONE;  // no hardware handshaking
      FComPortSwHandshaking      := shNONE;  // no software handshaking
      FComPortInBufSize          := 2048;    // input buffer of 512 bytes
      FComPortOutBufSize         := 2048;    // output buffer of 512 bytes
      FComPortReceiveData        := nil;     // no data handler
      FTimeOut                   := 30;      // sec until timeout
      FComPortPollingDelay       := 500;
      GetMem( FTempInBuffer, FComPortInBufSize ); // Temporary buffer
                                                  // for received data
      // Timer for teaching and messages
      hTimer := TTimer.Create(Self);
      hTimer.Enabled := false;
      hTimer.Interval := 500;
      hTimer.OnTimer := TimerEvent;
      if ComponentState = [csDesigning] then
        EXIT;
     
      if FActive then
        hTimer.Enabled := true; // start the timer only at application start
    end;
     
    destructor TCommPortDriver.Destroy;
    begin
      // Be sure to release the COM device
      Disconnect;
      // Free the temporary buffer
      FreeMem( FTempInBuffer, FComPortInBufSize );
      // Destroy the timer's window
      inherited Destroy;
    end;
     
    procedure TCommPortDriver.SetComPort( Value: TComPortNumber );
    begin
      // Be sure we are not using any COM port
      if Connected then
        exit;
      // Change COM port
      FComPort := Value;
    end;
     
    procedure TCommPortDriver.SetComPortBaudRate( Value: TComPortBaudRate );
    begin
      // Set new COM speed
      FComPortBaudRate := Value;
      // Apply changes
      if Connected then
        ApplyCOMSettings;
    end;
     
    procedure TCommPortDriver.SetComPortDataBits( Value: TComPortDataBits );
    begin
      // Set new data bits
      FComPortDataBits := Value;
      // Apply changes
      if Connected then
        ApplyCOMSettings;
    end;
     
    procedure TCommPortDriver.SetComPortStopBits( Value: TComPortStopBits );
    begin
      // Set new stop bits
      FComPortStopBits := Value;
      // Apply changes
      if Connected then
        ApplyCOMSettings;
    end;
     
    procedure TCommPortDriver.SetComPortParity( Value: TComPortParity );
    begin
      // Set new parity
      FComPortParity := Value;
      // Apply changes
      if Connected then
        ApplyCOMSettings;
    end;
     
    procedure TCommPortDriver.SetComPortHwHandshaking(Value: TComPortHwHandshaking);
    begin
      // Set new hardware handshaking
      FComPortHwHandshaking := Value;
      // Apply changes
      if Connected then
        ApplyCOMSettings;
    end;
     
    procedure TCommPortDriver.SetComPortSwHandshaking(Value: TComPortSwHandshaking);
    begin
      // Set new software handshaking
      FComPortSwHandshaking := Value;
     
      // Apply changes
      if Connected then
        ApplyCOMSettings;
    end;
     
    procedure TCommPortDriver.SetComPortInBufSize( Value: word );
    begin
      // Free the temporary input buffer
      FreeMem( FTempInBuffer, FComPortInBufSize );
      // Set new input buffer size
      FComPortInBufSize := Value;
      // Allocate the temporary input buffer
      GetMem( FTempInBuffer, FComPortInBufSize );
      // Apply changes
      if Connected then
        ApplyCOMSettings;
    end;
     
    procedure TCommPortDriver.SetComPortOutBufSize( Value: word );
    begin
      // Set new output buffer size
      FComPortOutBufSize := Value;
      // Apply changes
      if Connected then
        ApplyCOMSettings;
    end;
     
    procedure TCommPortDriver.SetComPortPollingDelay( Value: word );
    begin
      FComPortPollingDelay := Value;
      hTimer.Interval := Value;
    end;
     
    const
      Win32BaudRates: array[br110..br115200] of DWORD =
        ( CBR_110, CBR_300, CBR_600, CBR_1200, CBR_2400, CBR_4800, CBR_9600,
          CBR_14400, CBR_19200, CBR_38400, CBR_56000, CBR_57600, CBR_115200 );
     
    const
      dcb_Binary              = $00000001;
      dcb_ParityCheck         = $00000002;
      dcb_OutxCtsFlow         = $00000004;
      dcb_OutxDsrFlow         = $00000008;
      dcb_DtrControlMask      = $00000030;
        dcb_DtrControlDisable   = $00000000;
        dcb_DtrControlEnable    = $00000010;
        dcb_DtrControlHandshake = $00000020;
      dcb_DsrSensivity        = $00000040;
      dcb_TXContinueOnXoff    = $00000080;
      dcb_OutX                = $00000100;
      dcb_InX                 = $00000200;
      dcb_ErrorChar           = $00000400;
      dcb_NullStrip           = $00000800;
      dcb_RtsControlMask      = $00003000;
        dcb_RtsControlDisable   = $00000000;
        dcb_RtsControlEnable    = $00001000;
        dcb_RtsControlHandshake = $00002000;
        dcb_RtsControlToggle    = $00003000;
      dcb_AbortOnError        = $00004000;
      dcb_Reserveds           = $FFFF8000;
     
    // Apply COM settings.
    procedure TCommPortDriver.ApplyCOMSettings;
    var dcb: TDCB;
    begin
      // Do nothing if not connected
      if not Connected then
        exit;
     
      // Clear all
      fillchar( dcb, sizeof(dcb), 0 );
      // Setup dcb (Device Control Block) fields
      dcb.DCBLength := sizeof(dcb); // dcb structure size
      dcb.BaudRate := Win32BaudRates[ FComPortBaudRate ]; // baud rate to use
      dcb.Flags := dcb_Binary or // Set fBinary: Win32 does not support non
                                 // binary mode transfers
                                 // (also disable EOF check)
                   dcb_RtsControlEnable; // Enables the RTS line when the device
                                         // is opened and leaves it on
    //             dcb_DtrControlEnable; // Enables the DTR line when the device
                                         // is opened and leaves it on
     
      case FComPortHwHandshaking of // Type of hw handshaking to use
        hhNONE:; // No hardware handshaking
        hhRTSCTS: // RTS/CTS (request-to-send/clear-to-send) hardware handshaking
          dcb.Flags := dcb.Flags or dcb_OutxCtsFlow or dcb_RtsControlHandshake;
      end;
     
       case FComPortSwHandshaking of // Type of sw handshaking to use
        shNONE:; // No software handshaking
        shXONXOFF: // XON/XOFF handshaking
          dcb.Flags := dcb.Flags or dcb_OutX or dcb_InX;
      end;
     
      dcb.XONLim := FComPortInBufSize div 4; // Specifies the minimum number
                                             // of bytes allowed
                                             // in the input buffer before the
                                             // XON character is sent
      dcb.XOFFLim := 1; // Specifies the maximum number of bytes allowed in the
                        // input buffer before the XOFF character is sent.
                        // The maximum number of bytes allowed is calculated by
                        // subtracting this value from the size, in bytes,
                        // of the input buffer
      dcb.ByteSize := 5 + ord(FComPortDataBits); // how many data bits to use
      dcb.Parity := ord(FComPortParity); // type of parity to use
      dcb.StopBits := ord(FComPortStopbits); // how many stop bits to use
      dcb.XONChar := #17; // XON ASCII char
      dcb.XOFFChar := #19; // XOFF ASCII char
      SetCommState( FComPortHandle, dcb );
      // Setup buffers size
      SetupComm( FComPortHandle, FComPortInBufSize, FComPortOutBufSize );
    end;
     
    function TCommPortDriver.Connect: boolean;
    var comName: array[0..4] of char;
        tms: TCOMMTIMEOUTS;
    begin
      // Do nothing if already connected
      Result := Connected;
      if Result then exit;
      // Open the COM port
      StrPCopy( comName, 'COM' );
      comName[3] := chr( ord('1') + ord(FComPort) );
      comName[4] := #0;
      FComPortHandle := CreateFile(
                                    comName,
                                    GENERIC_READ or GENERIC_WRITE,
                                    0, // Not shared
                                    nil, // No security attributes
                                    OPEN_EXISTING,
                                    FILE_ATTRIBUTE_NORMAL,
                                    0 // No template
                                  ) ;
      Result := Connected;
      if not Result then exit;
      // Apply settings
      ApplyCOMSettings;
      // Setup timeouts: we disable timeouts because we are polling the com port!
      tms.ReadIntervalTimeout := 1; // Specifies the maximum time, in milliseconds,
                                    // allowed to elapse between the arrival of two
                                    // characters on the communications line
      tms.ReadTotalTimeoutMultiplier := 0; // Specifies the multiplier, in
                                           // milliseconds, used to calculate
                                           // the total time-out period
                                           // for read operations.
      tms.ReadTotalTimeoutConstant := 1; // Specifies the constant, in milliseconds,
                                         // used to calculate the total time-out
                                         // period for read operations.
      tms.WriteTotalTimeoutMultiplier := 0; // Specifies the multiplier, in
                                            // milliseconds, used to calculate
                                            // the total time-out period
                                            // for write operations.
      tms.WriteTotalTimeoutConstant := 0; // Specifies the constant, in
                                          // milliseconds, used to calculate
                                          // the total time-out period
                                          // for write operations.
      SetCommTimeOuts( FComPortHandle, tms );
     
      Sleep(1000);  // to avoid timing problems, wait until the Comm-Port is opened
    end;
     
    function TCommPortDriver.Disconnect: boolean;
    begin
      Result:=false;
      if Connected then
      begin
        CloseHandle( FComPortHandle );
        FComPortHandle := 0;
      end;
      Result := true;
    end;
     
    function TCommPortDriver.Connected: boolean;
    begin
      Result := FComPortHandle > 0;
    end;
     
    function TCommPortDriver.SendData(DataPtr: pointer; DataSize: integer): boolean;
    var nsent: DWORD;
    begin
      Result := WriteFile( FComPortHandle, DataPtr^, DataSize, nsent, nil );
      Result := Result and (nsent=DataSize);
    end;
     
    function TCommPortDriver.SendString( aStr: string ): boolean;
    begin
      if not Connected then
        if not Connect then raise Exception.CreateHelp('RS232.SendString:'+
                                  ' Connect not possible !', 101);
      Result:=SendData( pchar(aStr), length(aStr) );
      if not Result then raise
        Exception.CreateHelp('RS232.SendString: Send not possible !', 102);
    end;
     
     
    // Event for teaching and messages
    procedure TCommPortDriver.TimerEvent(Sender: TObject);
    var InQueue, OutQueue: integer;
     
      // Test if data in inQueue(outQueue)
      procedure DataInBuffer(Handle: THandle; var aInQueue, aOutQueue: integer);
      var ComStat: TComStat;
          e: cardinal;
      begin
        aInQueue := 0;
        aOutQueue := 0;
        if ClearCommError(Handle, e, @ComStat) then
        begin
          aInQueue := ComStat.cbInQue;
          aOutQueue := ComStat.cbOutQue;
        end;
      end;
     
    begin
      if not Connected then
        if not Connect then raise Exception.CreateHelp('RS232.TimerEvent:'+
                                  ' Connect not possible !', 101);
      if Connected then
      begin
        DataInBuffer(FComPortHandle, InQueue, OutQueue);
        // data in inQueue
        if InQueue > 0 then
          if Assigned(FComPortReceiveData) then FComPortReceiveData(Self, 0, 0, 0);
      end;
    end;
     
    // RS232 implementation ////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
     
    constructor TRS232.Create( AOwner: TComponent );
    begin
      inherited Create( AOwner );
      //OnReceiveData := ReceiveData;
      FComPort              := pnCOM1;  // COM 1
      FComPortBaudRate      := br9600;  // 9600 bauds
      FComPortDataBits      := db8BITS; // 8 data bits
      FComPortStopBits      := sb1BITS; // 1 stop bits
      FComPortParity        := ptEVEN;  // even parity
      FComPortHwHandshaking := hhNONE;  // no hardware handshaking
      FComPortSwHandshaking := shNONE;  // no software handshaking
      FComPortInBufSize     := 2048;    // input buffer of 512 ? bytes
      FComPortOutBufSize    := 2048;    // output buffer of 512 ? bytes
      FTimeOut              := 30;      // sec until timeout
    end;
     
    function  TRS232.ReadString(VAR aResStr: string; aCount: word ): boolean;
    var
      nRead: dword;
      Buffer: string;
      Actual, Before: TDateTime;
      TimeOutMin, TimeOutSec, lCount: word;
    begin
      Result := false;
      if not Connected then
        if not Connect then raise Exception.CreateHelp('RS232.ReadString:'+
                                  ' Connect not possible !', 101);
      aResStr := '';
      TimeOutMin:=TimeOut div 60;
      TimeOutSec:=TimeOut mod 60;
      if (not Connected) or (aCount <= 0) then EXIT;
      nRead := 0; lCount := 0;
      Before := Time;
      while lCount<aCount do
      begin
        Application.ProcessMessages;
        SetLength(Buffer,1);
        if ReadFile( FComPortHandle, PChar(Buffer)^, 1, nRead, nil ) then
        begin
          if nRead > 0 then
          begin
            aResStr := aResStr + Buffer;
            inc(lCount);
          end;
          Actual := Time;
          if Actual-Before>EncodeTime(0, TimeOutMin, TimeOutSec, 0)
          then raise Exception.CreateHelp('RS232.ReadString: TimeOut !', 103);
        end
        else begin
          raise Exception.CreateHelp('RS232.ReadString: Read not possible !', 104);
        end;
      end; // while
      Result:=true;
    end;
     
     
    [OBJECT]{$A+,B-,C+,D-,E-,F-,G+,H+,I+,J+,K-,L-,M-,N+,O+,P+,Q-,R-,S-,T-,U-,V+,W-,X+,Y-,Z1}
    {$MINSTACKSIZE $00004000}
    {$MAXSTACKSIZE $00100000}
    {$IMAGEBASE $51000000}
    {$APPTYPE GUI}
    unit ComportDriverThread;
     
    interface
     
    uses
      //Include "ExtCtrl" for the TTimer component.
      Windows, Messages, SysUtils, Classes, Forms, ExtCtrls;
     
    type
     
      TComPortNumber        = (pnCOM1,pnCOM2,pnCOM3,pnCOM4);
      TComPortBaudRate      = (br110,br300,br600,br1200,br2400,br4800,br9600,
                               br14400,br19200,br38400,br56000,br57600,br115200);
      TComPortDataBits      = (db5BITS,db6BITS,db7BITS,db8BITS);
      TComPortStopBits      = (sb1BITS,sb1HALFBITS,sb2BITS);
      TComPortParity        = (ptNONE,ptODD,ptEVEN,ptMARK,ptSPACE);
      TComportHwHandshaking = (hhNONE,hhRTSCTS);
      TComPortSwHandshaking = (shNONE,shXONXOFF);
     
      TTimerThread   = class(TThread)
      private
        { Private declarations }
        FOnTimer : TThreadMethod;
        FEnabled: Boolean;
      protected
        { Protected declarations }
        procedure Execute; override;
        procedure SupRes;
      public
        { Public declarations }
      published
        { Published declarations }
        property Enabled: Boolean read FEnabled write FEnabled;
      end;
     
      TComportDriverThread = class(TComponent)
      private
        { Private declarations }
        FTimer         : TTimerThread;
        FOnReceiveData : TNotifyEvent;
        FReceiving     : Boolean;
      protected
        { Protected declarations }
        FComPortActive           : Boolean;
        FComportHandle           : THandle;
        FComportNumber           : TComPortNumber;
        FComportBaudRate         : TComPortBaudRate;
        FComportDataBits         : TComPortDataBits;
        FComportStopBits         : TComPortStopBits;
        FComportParity           : TComPortParity;
        FComportHwHandshaking    : TComportHwHandshaking;
        FComportSwHandshaking    : TComPortSwHandshaking;
        FComportInputBufferSize  : Word;
        FComportOutputBufferSize : Word;
        FComportPollingDelay     : Word;
        FTimeOut                 : Integer;
        FTempInputBuffer         : Pointer;
        procedure SetComPortActive(Value: Boolean);
        procedure SetComPortNumber(Value: TComPortNumber);
        procedure SetComPortBaudRate(Value: TComPortBaudRate);
        procedure SetComPortDataBits(Value: TComPortDataBits);
        procedure SetComPortStopBits(Value: TComPortStopBits);
        procedure SetComPortParity(Value: TComPortParity);
        procedure SetComPortHwHandshaking(Value: TComportHwHandshaking);
        procedure SetComPortSwHandshaking(Value: TComPortSwHandshaking);
        procedure SetComPortInputBufferSize(Value: Word);
        procedure SetComPortOutputBufferSize(Value: Word);
        procedure SetComPortPollingDelay(Value: Word);
        procedure ApplyComPortSettings;
        procedure TimerEvent; virtual;
        procedure doDataReceived; virtual;
      public
        { Public declarations }
        constructor Create(AOwner: TComponent); override;
        destructor Destroy; override;
     
        function Connect: Boolean;
        function Disconnect: Boolean;
        function Connected: Boolean;
        function Disconnected: Boolean;
        function SendData(DataPtr: Pointer; DataSize: Integer): Boolean;
        function SendString(Input: String): Boolean;
        function ReadString(var Str: string): Integer;
      published
        { Published declarations }
        property Active: Boolean read FComPortActive write SetComPortActive default False;
        property ComPort: TComPortNumber read FComportNumber write SetComportNumber
                                                             default pnCOM1;
        property ComPortSpeed: TComPortBaudRate read FComportBaudRate write
                               SetComportBaudRate default br9600;
        property ComPortDataBits: TComPortDataBits read FComportDataBits write
                                  SetComportDataBits default db8BITS;
        property ComPortStopBits: TComPortStopBits read FComportStopBits write
                                  SetComportStopBits default sb1BITS;
        property ComPortParity: TComPortParity read FComportParity write
                                SetComportParity default ptNONE;
        property ComPortHwHandshaking: TComportHwHandshaking read FComportHwHandshaking
                                       write SetComportHwHandshaking default
                                       hhNONE;
        property ComPortSwHandshaking: TComPortSwHandshaking read FComportSwHandshaking
                                       write SetComportSwHandshaking default
                                       shNONE;
        property ComPortInputBufferSize: Word read FComportInputBufferSize
                                         write SetComportInputBufferSize default
                                         2048;
        property ComPortOutputBufferSize: Word read FComportOutputBufferSize
                                          write SetComportOutputBufferSize default
                                          2048;
        property ComPortPollingDelay: Word read FComportPollingDelay write
                                      SetComportPollingDelay default 100;
        property OnReceiveData: TNotifyEvent read FOnReceiveData
                                write FOnReceiveData;
        property TimeOut: Integer read FTimeOut write FTimeOut default 30;
      end;
     
    procedure Register;
     
    implementation
     
    procedure Register;
    begin
      RegisterComponents('Self-made Components', [TComportDriverThread]);
    end;
     
    { TComportDriver }
     
    constructor TComportDriverThread.Create(AOwner: TComponent);
    begin
      inherited;
      FReceiving               := False;
      FComportHandle           := 0;
      FComportNumber           := pnCOM1;
      FComportBaudRate         := br9600;
      FComportDataBits         := db8BITS;
      FComportStopBits         := sb1BITS;
      FComportParity           := ptNONE;
      FComportHwHandshaking    := hhNONE;
      FComportSwHandshaking    := shNONE;
      FComportInputBufferSize  := 2048;
      FComportOutputBufferSize := 2048;
      FOnReceiveData           := nil;
      FTimeOut                 := 30;
      FComportPollingDelay     := 500;
      GetMem(FTempInputBuffer,FComportInputBufferSize);
     
      if csDesigning in ComponentState then
        Exit;
     
      FTimer := TTimerThread.Create(False);
      FTimer.FOnTimer := TimerEvent;
     
      if FComPortActive then
        FTimer.Enabled := True;
      FTimer.SupRes;
    end;
     
    destructor TComportDriverThread.Destroy;
    begin
      Disconnect;
      FreeMem(FTempInputBuffer,FComportInputBufferSize);
      inherited Destroy;
    end;
     
    function TComportDriverThread.Connect: Boolean;
    var
      comName: array[0..4] of Char;
      tms: TCommTimeouts;
    begin
      if Connected then
        Exit;
      StrPCopy(comName,'COM');
      comName[3] := chr(ord('1') + ord(FComportNumber));
      comName[4] := #0;
      FComportHandle := CreateFile(comName,GENERIC_READ OR GENERIC_WRITE,0,nil,
                                   OPEN_EXISTING,FILE_ATTRIBUTE_NORMAL,0);
      if not Connected then
        Exit;
      ApplyComPortSettings;
      tms.ReadIntervalTimeout         := 1;
      tms.ReadTotalTimeoutMultiplier  := 0;
      tms.ReadTotalTimeoutConstant    := 1;
      tms.WriteTotalTimeoutMultiplier := 0;
      tms.WriteTotalTimeoutConstant   := 0;
      SetCommTimeouts(FComportHandle,tms);
      Sleep(1000);
    end;
     
    function TComportDriverThread.Connected: Boolean;
    begin
      Result := FComportHandle > 0;
    end;
     
    function TComportDriverThread.Disconnect: Boolean;
    begin
      Result := False;
      if Connected then
      begin
        CloseHandle(FComportHandle);
        FComportHandle := 0;
      end;
      Result := True;
    end;
     
    function TComportDriverThread.Disconnected: Boolean;
    begin
      if (FComportHandle <> 0) then
        Result := False
      else
        Result := True;
    end;
     
    const
      Win32BaudRates: array[br110..br115200] of DWORD =
       (CBR_110,CBR_300,CBR_600,CBR_1200,CBR_2400,CBR_4800,CBR_9600,CBR_14400,
        CBR_19200,CBR_38400,CBR_56000,CBR_57600,CBR_115200);
     
    const
      dcb_Binary              = $00000001;
      dcb_ParityCheck         = $00000002;
      dcb_OutxCtsFlow         = $00000004;
      dcb_OutxDsrFlow         = $00000008;
      dcb_DtrControlMask      = $00000030;
      dcb_DtrControlDisable   = $00000000;
      dcb_DtrControlEnable    = $00000010;
      dcb_DtrControlHandshake = $00000020;
      dcb_DsrSensitvity       = $00000040;
      dcb_TXContinueOnXoff    = $00000080;
      dcb_OutX                = $00000100;
      dcb_InX                 = $00000200;
      dcb_ErrorChar           = $00000400;
      dcb_NullStrip           = $00000800;
      dcb_RtsControlMask      = $00003000;
      dcb_RtsControlDisable   = $00000000;
      dcb_RtsControlEnable    = $00001000;
      dcb_RtsControlHandshake = $00002000;
      dcb_RtsControlToggle    = $00003000;
      dcb_AbortOnError        = $00004000;
      dcb_Reserveds           = $FFFF8000;
     
    procedure TComportDriverThread.ApplyComPortSettings;
    var
      //Device Control Block (= dcb)
      dcb: TDCB;
    begin
      if not Connected then
        Exit;
      FillChar(dcb,sizeOf(dcb),0);
      dcb.DCBlength := sizeOf(dcb);
     
      dcb.Flags := dcb_Binary or dcb_RtsControlEnable;
      dcb.BaudRate := Win32BaudRates[FComPortBaudRate];
     
      case FComportHwHandshaking  of
        hhNONE  : ;
        hhRTSCTS:
          dcb.Flags := dcb.Flags or dcb_OutxCtsFlow or dcb_RtsControlHandshake;
      end;
     
      case FComportSwHandshaking of
        shNONE   : ;
        shXONXOFF:
          dcb.Flags := dcb.Flags or dcb_OutX or dcb_Inx;
      end;
     
      dcb.XonLim   := FComportInputBufferSize div 4;
      dcb.XoffLim  := 1;
      dcb.ByteSize := 5 + ord(FComportDataBits);
      dcb.Parity   := ord(FComportParity);
      dcb.StopBits := ord(FComportStopBits);
      dcb.XonChar  := #17;
      dcb.XoffChar := #19;
      SetCommState(FComportHandle,dcb);
      SetupComm(FComportHandle,FComPortInputBufferSize,FComPortOutputBufferSize);
    end;
     
    function TComportDriverThread.ReadString(var Str: string): Integer;
    var
      BytesTrans, nRead: DWORD;
      Buffer           : String;
      i                : Integer;
      temp             : string;
    begin
      BytesTrans := 0;
      Str := '';
      SetLength(Buffer,1);
      ReadFile(FComportHandle,PChar(Buffer)^, 1, nRead, nil);
      while nRead > 0 do
      begin
        temp := temp + PChar(Buffer);
        ReadFile(FComportHandle,PChar(Buffer)^, 1, nRead, nil);
      end;
      //Remove the end token.
      BytesTrans := Length(temp);
      SetLength(str,BytesTrans-2);
      for i:=0 to BytesTrans-2 do
      begin
        str[i] := temp[i];
      end;
     
      Result := BytesTrans;
    end;
     
    function TComportDriverThread.SendData(DataPtr: Pointer;
      DataSize: Integer): Boolean;
    var
      nsent : DWORD;
    begin
      Result := WriteFile(FComportHandle,DataPtr^,DataSize,nsent,nil);
      Result := Result and (nsent = DataSize);
    end;
     
    function TComportDriverThread.SendString(Input: String): Boolean;
    begin
      if not Connected then
        if not Connect then
          raise Exception.CreateHelp('Could not connect to COM-port !',101);
      Result := SendData(PChar(Input),Length(Input));
      if not Result then
        raise Exception.CreateHelp('Could not send to COM-port !',102);
    end;
     
    procedure TComportDriverThread.TimerEvent;
    var
      InQueue, OutQueue: Integer;
      Buffer : String;
      nRead : DWORD;
     
      procedure DataInBuffer(Handle: THandle; var aInQueue, aOutQueue: Integer);
      var
        ComStat : TComStat;
        e       : Cardinal;
      begin
        aInQueue  := 0;
        aOutQueue := 0;
        if ClearCommError(Handle,e,@ComStat) then
        begin
          aInQueue  := ComStat.cbInQue;
          aOutQueue := ComStat.cbOutQue;
        end;
      end;
    begin
      if csDesigning in ComponentState then
        Exit;
      if not Connected then
        if not Connect then
          raise Exception.CreateHelp('TimerEvent: Could not connect to COM-port !',101);
      Application.ProcessMessages;
      if Connected then
      begin
        DataInBuffer(FComportHandle,InQueue,OutQueue);
        if InQueue > 0 then
        begin
          if (Assigned(FOnReceiveData) ) then
          begin
            FReceiving := True;
            FOnReceiveData(Self);
          end;
        end;
      end;
    end;
     
    procedure TComportDriverThread.SetComportBaudRate(Value: TComPortBaudRate);
    begin
      FComportBaudRate := Value;
      if Connected then
        ApplyComPortSettings;
    end;
     
    procedure TComportDriverThread.SetComportDataBits(Value: TComPortDataBits);
    begin
      FComportDataBits := Value;
      if Connected then
        ApplyComPortSettings;
    end;
     
    procedure TComportDriverThread.SetComportHwHandshaking(Value: TComportHwHandshaking);
    begin
      FComportHwHandshaking := Value;
      if Connected then
        ApplyComPortSettings;
    end;
     
    procedure TComportDriverThread.SetComportInputBufferSize(Value: Word);
    begin
      FreeMem(FTempInputBuffer,FComportInputBufferSize);
      FComportInputBufferSize := Value;
      GetMem(FTempInputBuffer,FComportInputBufferSize);
      if Connected then
        ApplyComPortSettings;
    end;
     
    procedure TComportDriverThread.SetComportNumber(Value: TComPortNumber);
    begin
      if Connected then
        exit;
      FComportNumber := Value;
    end;
     
    procedure TComportDriverThread.SetComportOutputBufferSize(Value: Word);
    begin
      FComportOutputBufferSize := Value;
      if Connected then
        ApplyComPortSettings;
    end;
     
    procedure TComportDriverThread.SetComportParity(Value: TComPortParity);
    begin
      FComportParity := Value;
      if Connected then
        ApplyComPortSettings;
    end;
     
    procedure TComportDriverThread.SetComportPollingDelay(Value: Word);
    begin
      FComportPollingDelay := Value;
    end;
     
    procedure TComportDriverThread.SetComportStopBits(Value: TComPortStopBits);
    begin
      FComportStopBits := Value;
      if Connected then
        ApplyComPortSettings;
    end;
     
    procedure TComportDriverThread.SetComportSwHandshaking(Value: TComPortSwHandshaking);
    begin
      FComportSwHandshaking := Value;
      if Connected then
        ApplyComPortSettings;
    end;
     
    procedure TComportDriverThread.DoDataReceived;
    begin
      if Assigned(FOnReceiveData) then FOnReceiveData(Self);
    end;
     
    procedure TComportDriverThread.SetComPortActive(Value: Boolean);
    var
      DumpString : String;
    begin
      FComPortActive := Value;
      if csDesigning in ComponentState then
        Exit;
      if FComPortActive then
      begin
        //Just dump the contents of the input buffer of the com-port.
        ReadString(DumpString);
        FTimer.Enabled := True;
      end
      else
        FTimer.Enabled := False;
      FTimer.SupRes;
    end;
     
    { TTimerThread }
     
    procedure TTimerThread.Execute;
    begin
      Priority := tpNormal;
      repeat
        Sleep(500);
        if Assigned(FOnTimer) then Synchronize(FOnTimer);
      until Terminated;
    end;
     
    procedure TTimerThread.SupRes;
    begin
      if not Suspended then
        Suspend;
      if FEnabled then
        Resume;
    end;
     
    end.

    procedure TCommPortDriver.SetActive(const Value: boolean);
    begin
      FActive := Value;
    end;
     
    end.

