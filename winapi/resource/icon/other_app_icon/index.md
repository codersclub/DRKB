---
Title: Как получить иконку чужого окна?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---

Как получить иконку чужого окна?
================================

    { 
    First Start Notepad.exe and run this code: 
    }
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      hwindow : THandle;
      H: HIcon;
    begin
      hwindow := FindWindow('notepad',nil);
      H := CopyIcon(GetClassLong(hwindow, GCL_HICON ));
      DrawIcon(Canvas.Handle, 30, 30, H);
    end;

