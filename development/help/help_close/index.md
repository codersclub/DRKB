---
Title: Как закрыть help при закрытии приложения?
Date: 01.01.2007
---


Как закрыть help при закрытии приложения?
=========================================

Вариант 1:

    procedure TForm1.FormDestroy(Sender: TObject); 
    begin 
      Application.HelpCommand(HELP_QUIT, 0); 
    end; 

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>

------------------------------------------------------------------------
Вариант 2:

    procedure TMainForm.FormClose(Sender: TObject; var Action: TCloseAction);
    begin
      Winhelp(Handle, 'WINHELP.HLP', HELP_QUIT, 0);
      Action := caFree;
    end;
