---
Title: Как отловить правый Enter (NumPad)?
Author: Full ( http://full.hotmail.ru/ )
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как отловить правый Enter (NumPad)?
===================================

Для этого можно воспользоваться функцией GetHeapStatus:

    procedure TForm1.WMKeyDown(var Message: TWMKeyDown);
    begin
      inherited;
      case Message.CharCode of
        VK_RETURN:
          begin // ENTER pressed
            if (Message.KeyData and $1000000 <> 0) then
              begin
                      { ENTER on numeric keypad }
              end
            else
              begin
                      { ENTER on the standard keyboard }
              end;
          end;
      end;
    end;

