---
Title: Обработать момент вставки и вытаскивания CD
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Обработать момент вставки и вытаскивания CD
===========================================

    { 
      Some applications need to know when the user inserts or 
      removes a compact disc or DVD from a CD-ROM drive without 
      polling for media changes. Windows provide a way to notify these 
      applications through the WM_DEVICECHANGE message. 
    }
     
    type
      TForm1 = class(TForm)
      private
        procedure WMDeviceChange(var Msg: TMessage); message WM_DEVICECHANGE;
      public
    
      end;
     
    {...}
    
    implementation
    
    {$R *.DFM}
    
    procedure TForm1.WMDeviceChange(var Msg: TMessage);
    const
      DBT_DEVICEARRIVAL = $8000; // system detected a new device 
      DBT_DEVICEREMOVECOMPLETE = $8004;  // device is gone 
    var
       myMsg: string;
    begin
      inherited;
      case Msg.wParam of
        DBT_DEVICEARRIVAL: myMsg  := 'CD inserted!';
        DBT_DEVICEREMOVECOMPLETE: myMsg := 'CD removed!';
      end;
      ShowMessage(myMsg);
    end;
    
    
    {*********************************************}
    
    // Advanced Code: 
    // When the device is of type volume, then we can get some device specific 
    // information, namely specific information about a logical volume. 
    // by Juergen Kantz 
     
    unit Unit1;
     
    interface
    
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls;
    
    type
      TForm1 = class(TForm)
        Button1: TButton;
        label1: TLabel;
      private
        procedure WMDeviceChange(var Msg: TMessage); message WM_DeviceChange;
        { Private declarations }
      public
        { Public declarations }
      end;
    
    const
       DBT_DeviceArrival = $8000;
       DBT_DeviceRemoveComplete = $8004;
       DBTF_Media = $0001;
       DBT_DevTyp_Volume = $0002;
     
     type
       PDevBroadcastHdr = ^TDevBroadcastHdr;
       TDevBroadcastHdr = packed record
         dbcd_size: DWORD;
         dbcd_devicetype: DWORD;
         dbcd_reserved: DWORD;
       end;
     
     type
       PDevBroadcastVolume = ^TDevBroadcastVolume;
       TDevBroadcastVolume = packed record
         dbcv_size: DWORD;
         dbcv_devicetype: DWORD;
         dbcv_reserved: DWORD;
         dbcv_unitmask: DWORD;
         dbcv_flags: Word;
       end;
     
     var
       Form1: TForm1;
     
     
     implementation
     
     {$R *.dfm}
     
     
     function GetDrive(pDBVol: PDevBroadcastVolume): string;
     var
       i: Byte;
       Maske: DWORD;
     begin
       if (pDBVol^.dbcv_flags and DBTF_Media) = DBTF_Media then
       begin
         Maske := pDBVol^.dbcv_unitmask;
         for i := 0 to 25 do
         begin
           if (Maske and 1) = 1 then
             Result := Char(i + Ord('A')) + ':';
           Maske := Maske shr 1;
         end;
       end;
     end;
     
     procedure TForm1.WMDeviceChange(var Msg: TMessage);
     var
       Drive: string;
     begin
       case Msg.wParam of
         DBT_DeviceArrival:
           if PDevBroadcastHdr(Msg.lParam)^.dbcd_devicetype = DBT_DevTyp_Volume then
           begin
             Drive := GetDrive(PDevBroadcastVolume(Msg.lParam));
             label1.Caption := 'CD inserted in Drive ' + Drive;
           end;
         DBT_DeviceRemoveComplete:
           if PDevBroadcastHdr(Msg.lParam)^.dbcd_devicetype = DBT_DevTyp_Volume then
           begin
             Drive := GetDrive(PDevBroadcastVolume(Msg.lParam));
             label1.Caption := 'CD removed from Drive ' + Drive;
           end;
       end;
     end;
     
     
     end.

