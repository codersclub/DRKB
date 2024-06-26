---
Title: Допустимые периоды истечения времени
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Допустимые периоды истечения времени
====================================

    { 
      Retrieves information about the time-out period associated 
      with the accessibility features. 
      The pvParam parameter must point to an ACCESSTIMEOUT 
      structure that receives the information. 
      Set the cbSize member of this structure and the 
      uiParam parameter to SizeOf(ACCESSTIMEOUT). 
    }
     
     
     // ACCESSTIMEOUT structure 
    type
       TAccessTimeOut = record
         cbSize: UINT;
         dwFlags: DWORD;
         iTimeOutMSec: DWORD;
       end;
     
     procedure GetAccessTimeOut(var bTimeOut: Boolean; var bFeedBack: Boolean;
       var iTimeOutTime: Integer);
       // bTimeOut: the time-out period for accessibility features. 
      // bFeedBack: the operating system plays a descending 
      //            siren sound when the time-out period elapses and the 
      //            Accessibility features are turned off. 
      // iTimeOutTime: Timeout in ms 
    var
       AccessTimeOut: TAccessTimeOut;
     begin
       ZeroMemory(@AccessTimeOut, SizeOf(TAccessTimeOut));
       AccessTimeOut.cbSize := SizeOf(TAccessTimeOut);
     
       SystemParametersInfo(SPI_GETACCESSTIMEOUT, SizeOf(AccessTimeOut), @AccessTimeOut, 0);
     
       bTimeOut := (AccessTimeOut.dwFlags and ATF_TIMEOUTON) = ATF_TIMEOUTON;
       bFeedBack := (AccessTimeOut.dwFlags and ATF_ONOFFFEEDBACK) = ATF_ONOFFFEEDBACK;
       iTimeOutTime := AccessTimeOut.iTimeOutMSec;
     end;
     
     // Test it: 
     
    procedure TForm1.Button2Click(Sender: TObject);
     var
       bTimeOut, bFeedBack: Boolean;
       iTimeOutTime: Integer;
     begin
       GetAccessTimeOut(bTimeOut, bFeedBack, iTimeOutTime);
       label1.Caption := IntToStr(Ord(bTimeOut));
       Label2.Caption := IntToStr(Ord(bFeedBack));
       Label3.Caption := IntToStr(iTimeOutTime);
     end;
     
     { 
      Sets the time-out period associated with the accessibility features. 
      The pvParam parameter must point to anACCESSTIMEOUT structure that 
      contains the new parameters. 
      Set the cbSize member of this structure and the uiParam 
      parameter to sizeof(ACCESSTIMEOUT). 
    }
     
     { 
      Setzt Informationen zu den ACCESSEDTIMEOUT-Eigenschaften. 
      "uiParam" erwartet die Gro?e der ACCESSEDTIMEOUT-Struktur, 
      die in "pvParam" ubergeben werden muss. 
    }
     
     procedure SetAccessTimeOut(bTimeOut, bFeedBack: Boolean; iTimeOutTime: Integer);
       // bTimeOut: If true, a time-out period has been set for accessibility features. 
      // bFeedBack: If true, the operating system plays a descending 
      //                    siren sound when the time-out period elapses and the 
      //                    accessibility features are turned off. 
      // iTimeOutTime: Timeout in ms 
    var
       AccessTimeOut: TAccessTimeOut;
     begin
       ZeroMemory(@AccessTimeOut, SizeOf(TAccessTimeOut));
       AccessTimeOut.cbSize := SizeOf(TAccessTimeOut);
     
       case bTimeOut of
         True: AccessTimeOut.dwFlags  := ATF_TIMEOUTON;
         False: AccessTimeOut.dwFlags := 0;
       end;
     
       if bFeedBack then
         AccessTimeOut.dwFlags := AccessTimeOut.dwFlags or ATF_ONOFFFEEDBACK;
     
       AccessTimeOut.iTimeOutMSec := iTimeOutTime;
     
       SystemParametersInfo(SPI_SETACCESSTIMEOUT, SizeOf(AccessTimeOut),
         @AccessTimeOut, SPIF_UPDATEINIFILE or SPIF_SENDWININICHANGE);
     end;
     
     // Test it: 
    procedure TForm1.Button1Click(Sender: TObject);
     begin
       SetAccessTimeOut(True, True, 600000); // 10 min. timeout 
    end;

