---
Title: Как получить иконку чужого окна?
Date: 01.01.2007
---

Как получить иконку чужого окна?
================================

::: {.date}
01.01.2007
:::

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

Взято с сайта: <https://www.swissdelphicenter.ch>
