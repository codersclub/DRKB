---
Title: Как сделать System Restore Point в Windows XP?
Date: 01.01.2007
---

Как сделать System Restore Point в Windows XP?
==============================================

::: {.date}
01.01.2007
:::

    {
      If you haven't installed the Microsoft Scripting Control yet
      (TScriptControl component),
      get it from http://www.msdn.microsoft.com/scripting/
     
      Once you've downloaded and run the installation, start Delphi and go to the
      Component | Import ActiveX Control... menu.
      Select "Microsoft Script Control 1.0" from the Listbox amd click "Install"
      to install the component into Delphi's palette.
      What you should end up with now is a TScriptControl component on your ActiveX tab.
      Start a new application, and drop a TButton, and a TScriptControl onto the main form.
      In the OnClick event of Button1, put the following code:
    }
     
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      sr: OLEVAriant;
    begin
      ScriptControl1.Language := 'VBScript';
      sr := ScriptControl1.Eval('getobject("winmgmts:\\.\root\default:Systemrestore")');
      if sr.CreateRestorePoint('Automatic Restore Point', 0, 100) = 0 then
        ShowMessage('New Restore Point successfully created.')
        // Wiederherstellungspunkt erfolgreich erstellt
      else
        ShowMessage('Restore Point creation Failed!');
        // Wiederherstellungspunkt Erstellung fehlgeschlagen.
    end;
     
     
     
    {*****************************************************}
     
    {2. Using the SRSetRestorePoint() API from SrClient.dll}
     
    // Translation from SRRestorePtAPI.h
    const
     // Type of Event
     BEGIN_SYSTEM_CHANGE = 100;
     END_SYSTEM_CHANGE  = 101;
     // Type of Restore Points
     APPLICATION_INSTALL =  0;
     CANCELLED_OPERATION = 13;
     MAX_DESC = 64;
     MIN_EVENT = 100;
     
    // Restore point information
    type
    PRESTOREPTINFOA = ^_RESTOREPTINFOA;
    _RESTOREPTINFOA = packed record
        dwEventType: DWORD;  // Type of Event - Begin or End
        dwRestorePtType: DWORD;  // Type of Restore Point - App install/uninstall
        llSequenceNumber: INT64;  // Sequence Number - 0 for begin
        szDescription: array [0..MAX_DESC] of CHAR; // Description - Name of Application / Operation
    end;
    RESTOREPOINTINFO = _RESTOREPTINFOA;
    PRESTOREPOINTINFOA = ^_RESTOREPTINFOA;
     
    // Status returned by System Restore
     
    PSMGRSTATUS = ^_SMGRSTATUS;
    _SMGRSTATUS = packed record
        nStatus: DWORD; // Status returned by State Manager Process
        llSequenceNumber: INT64;  // Sequence Number for the restore point
    end;
    STATEMGRSTATUS =  _SMGRSTATUS;
    PSTATEMGRSTATUS =  ^_SMGRSTATUS;
     
    function SRSetRestorePointA(pRestorePtSpec: PRESTOREPOINTINFOA; pSMgrStatus: PSTATEMGRSTATUS): Bool;
      stdcall; external 'SrClient.dll' Name 'SRSetRestorePointA';
     
    // Example how to create and cancel a previous restore point.
    // Ref: http://tinyurl.com/78pv
     
    procedure TForm1.Button1Click(Sender: TObject);
    const
     CR = #13#10;
    var
      RestorePtSpec: RESTOREPOINTINFO;
      SMgrStatus: STATEMGRSTATUS;
    begin
      // Initialize the RESTOREPOINTINFO structure
      RestorePtSpec.dwEventType := BEGIN_SYSTEM_CHANGE;
      RestorePtSpec.dwRestorePtType := APPLICATION_INSTALL;
      RestorePtSpec.llSequenceNumber := 0;
      RestorePtSpec.szDescription := 'SAMPLE RESTORE POINT';
     
      if (SRSetRestorePointA(@RestorePtSpec, @SMgrStatus)) then
      begin
        ShowMessage('Restore point set. Restore point data:' + CR+
          'Sequence Number: ' + Format('%d', [SMgrStatus.llSequenceNumber]) + CR+
          'Status: ' + Format('%u', [SMgrStatus.nStatus]));
     
          // Restore Point Spec to cancel the previous restore point.
          RestorePtSpec.dwEventType := END_SYSTEM_CHANGE;
          RestorePtSpec.dwRestorePtType  := CANCELLED_OPERATION;
          RestorePtSpec.llSequenceNumber := SMgrStatus.llSequenceNumber;
     
          // This is the sequence number returned by the previous call.
          // Canceling the previous restore point
          if (SRSetRestorePointA(@RestorePtSpec, @SMgrStatus)) then
            ShowMessage('Restore point canceled. Restore point data:' + CR+
            'Sequence Number: ' + Format('%d', [SMgrStatus.llSequenceNumber]) + CR+
            'Status: ' + Format('%u', [SMgrStatus.nStatus]))
     
          else
            ShowMessage('Could not cancel restore point.');
        end
        else
          ShowMessage('Could not set restore point.');
      end;
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
