---
Title: Using TAPI
Date: 01.01.2007
---


Using TAPI
==========

> How can I use TAPI to dial the telephone for a voice call?

The following example shows how to interface with tapi to make a voice
call.

    {tapi Errors}
     const TAPIERR_CONNECTED          = 0;
     const TAPIERR_DROPPED            = -1;
     const TAPIERR_NOREQUESTRECIPIENT = -2;
     const TAPIERR_REQUESTQUEUEFULL   = -3;
     const TAPIERR_INVALDESTADDRESS   = -4;
     const TAPIERR_INVALWINDOWHANDLE  = -5;
     const TAPIERR_INVALDEVICECLASS   = -6;
     const TAPIERR_INVALDEVICEID      = -7;
     const TAPIERR_DEVICECLASSUNAVAIL = -8;
     const TAPIERR_DEVICEIDUNAVAIL    = -9;
     const TAPIERR_DEVICEINUSE        = -10;
     const TAPIERR_DESTBUSY           = -11;
     const TAPIERR_DESTNOANSWER       = -12;
     const TAPIERR_DESTUNAVAIL        = -13;
     const TAPIERR_UNKNOWNWINHANDLE   = -14;
     const TAPIERR_UNKNOWNREQUESTID   = -15;
     const TAPIERR_REQUESTFAILED      = -16;
     const TAPIERR_REQUESTCANCELLED   = -17;
     const TAPIERR_INVALPOINTER       = -18;
     
    {tapi size constants}
     const TAPIMAXDESTADDRESSSIZE      = 80;
     const TAPIMAXAPPNAMESIZE          = 40;
     const TAPIMAXCALLEDPARTYSIZE      = 40;
     const TAPIMAXCOMMENTSIZE          = 80;
     const TAPIMAXDEVICECLASSSIZE      = 40;
     const TAPIMAXDEVICEIDSIZE         = 40;
     
    function tapiRequestMakeCallA(DestAddress : PAnsiChar;
                                  AppName : PAnsiChar;
                                  CalledParty : PAnsiChar;
                                  Comment : PAnsiChar) : LongInt;
      stdcall; external 'TAPI32.DLL';
     
    function tapiRequestMakeCallW(DestAddress : PWideChar;
                                  AppName : PWideChar;
                                  CalledParty : PWideChar;
                                  Comment : PWideChar) : LongInt;
      stdcall; external 'TAPI32.DLL';
     
    function tapiRequestMakeCall(DestAddress : PChar;
                                 AppName : PChar;
                                 CalledParty : PChar;
                                 Comment : PChar) : LongInt;
      stdcall; external 'TAPI32.DLL';
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      DestAddress : string;
      CalledParty : string;
      Comment : string;
    begin
      DestAddress := '1-555-555-1212';
      CalledParty := 'Frank Borland';
      Comment := 'Calling Frank';
      tapiRequestMakeCall(pChar(DestAddress),
                          PChar(Application.Title),
                          pChar(CalledParty),
                          PChar(Comment));
     
    end;
     
    end.
