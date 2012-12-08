---
Title: Как заставить дополнительную клавиатуру всегда работать в режиме цифр?
Date: 01.01.2007
---


Как заставить дополнительную клавиатуру всегда работать в режиме цифр?
======================================================================

::: {.date}
01.01.2007
:::

Для этого необходимо написать процедуру-обработчик для
Application.OnMessage:

    procedure TForm1.FormCreate(Sender: TObject);
    begin
      Application.OnMessage := AppOnMessage;
    end;
     
    procedure TForm1.AppOnMessage(var Msg: TMsg; var Handled: Boolean);
    var  ccode: Word;
    begin
      case Msg.Message of
        WM_KEYDOWN, WM_KEYUP:
        begin 
          If (GetKeyState( VK_NUMLOCK ) >= 0)  //NumLock не включён
              and ((Msg.lparam and  $1000000) = 0)
          then
          begin
            ccode := 0;
            case Msg.wparam of
              VK_HOME:  ccode := VK_NUMPAD7;
              VK_UP  :  ccode := VK_NUMPAD8;
              VK_PRIOR: ccode := VK_NUMPAD9;
              VK_LEFT:  ccode := VK_NUMPAD4;
              VK_CLEAR: ccode := VK_NUMPAD5;
              VK_RIGHT: ccode := VK_NUMPAD6;
              VK_END  : ccode := VK_NUMPAD1;
              VK_DOWN : ccode := VK_NUMPAD2;
              VK_NEXT : ccode := VK_NUMPAD3;
              VK_INSERT:ccode := VK_NUMPAD0;
              VK_DELETE:ccode := VK_DECIMAL;
            end;
            If ccode <> 0 then Msg.Wparam := ccode;
          end;
        end;
      end;
    end;

Взято из <https://forum.sources.ru>
