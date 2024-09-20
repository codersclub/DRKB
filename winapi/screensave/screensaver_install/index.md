---
Title: Инсталляция screensaver\'a
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---

Инсталляция screensaver\'a
==========================

    uses
       shellapi;
     
     procedure InstallScreenSaver(const FileName: string);
     begin
       { Set this screensaver as default screensaver and open the properties dialog}
       ShellExecute(Application.Handle, 'open', PChar('rundll32.exe'),
         PChar('desk.cpl,InstallScreenSaver ' + FileName), nil, SW_SHOWNORMAL);
     end;
     
     procedure TForm1.Button1Click(Sender: TObject);
     begin
       InstallScreenSaver('c:\YourScreenSaverFile.scr');
     end;

