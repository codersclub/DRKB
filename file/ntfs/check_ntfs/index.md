---
Title: Как определить, является ли диск NTFS?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как определить, является ли диск NTFS?
======================================

    uses 
      ComObj; 
     
    function IsNTFS(AFileName: string): Boolean; 
    var 
      fso, drv: OleVariant; 
    begin 
      IsNTFS := False; 
      fso := CreateOleObject('Scripting.FileSystemObject'); 
      drv := fso.GetDrive(fso.GetDriveName(AFileName)); 
      IsNTFS := drv.FileSystem = 'NTFS' 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      if IsNTFS('X:\Temp\File.doc') then 
        ShowMessage('File is on NTFS File System') 
      else 
        ShowMessage('File is not on NTFS File System') 
    end; 

