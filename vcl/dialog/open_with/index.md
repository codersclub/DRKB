---
Title: Как показать Open With диалог?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как показать Open With диалог?
==============================

    { 
      This code displays the application/file "Open With" dialog 
      Passing the full file path and name as a parameter will cause the 
      dialog to display the line "Click the program you want to use to open 
      the file 'filename'". 
    } 
     
    uses 
      ShellApi; 
     
    procedure OpenWith(FileName: string); 
    begin 
      ShellExecute(Application.Handle, 'open', PChar('rundll32.exe'), 
        PChar('shell32.dll,OpenAs_RunDLL ' + FileName), nil, SW_SHOWNORMAL); 
    end; 
     
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      if Opendialog1.Execute then 
        OpenWith(Opendialog1.FileName); 
    end; 

