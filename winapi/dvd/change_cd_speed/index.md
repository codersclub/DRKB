---
Title: Изменение скорости привода CD-ROM
Author: Rouse\_
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Изменение скорости привода CD-ROM
=================================

Находим в интернете файл ASPI.pas (еще есть wnaspi32.pas), подключаем
его к проекту, пишем следующий код:

    function SetCDSpeed(Host,Target:byte;Speed:integer):BOOL;
     
    var
      dwASPIStatus: DWORD;
      hEvent: THandle;
      srbExec: SRB_ExecSCSICmd;
    begin
      if Speed<176 then result:=false
      else
      begin
      hEvent:=CreateEvent(nil, true, false, nil);
      Fillchar(srbExec,sizeof(SRB_ExecSCSICmd),0);
      srbExec.SRB_Cmd:= SC_EXEC_SCSI_CMD;
      srbExec.SRB_Flags:= SRB_DIR_OUT or SRB_EVENT_NOTIFY;
      srbExec.SRB_Target:= Target;
      srbExec.SRB_HaId:= Host;
      srbExec.SRB_Lun:= 0;
      srbExec.SRB_SenseLen:= SENSE_LEN;
      srbExec.SRB_CDBLen:= 12;
      srbExec.SRB_PostProc:=Pointer(hEvent);
      srbExec.CDBByte[0]:= $BB; // команда изменения скорости привода
      srbExec.CDBByte[2]:= Speed shr 8;
      srbExec.CDBByte[3]:= Speed;
      srbExec.CDBByte[4]:= $FF;
      srbExec.CDBByte[5]:= $FF;
      ResetEvent(hEvent);
      dwASPIStatus:= SendASPI32Command(@srbExec);
      if dwASPIStatus=SS_PENDING
      then
      begin
        WaitForSingleObject(hEvent,INFINITE);
      end;
      if srbExec.SRB_Status<>SS_COMP
      then
      begin
        MessageBox(0,'Error processing the SRB.','Error',MB_OK);
        result:=false;
      end
      else
      result:=true;
      end;
    end;

Какие параметры передавать - написано в том же ASPI.pas

