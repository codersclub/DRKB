---
Title: Предотвратить запуск screensaver\'a при работе программы
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---

Предотвратить запуск screensaver\'a при работе программы
========================================================

    interface
     
    private
      procedure AppMessage(var Msg: TMsg; var handled: Boolean);
    end;
    
    implementation
    
    
    procedure TForm1.AppMessage(var Msg: TMsg; var handled: Boolean);
    begin
      if (Msg.Message = WM_SYSCOMMAND) and (Msg.wParam = SC_SCREENSAVE) then
        Handled := True;
    end;
    
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      Application.OnMessage := AppMessage;
    end;
    
    { 
     Note: The Screensaver is only disabled during the lifespan of 
     your application. 
    }

