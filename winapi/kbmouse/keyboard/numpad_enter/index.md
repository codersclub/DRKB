---
Title: Как отловить правый Enter (NumPad)?
Author: Full ( http://full.hotmail.ru/ )
Date: 01.01.2007
---


Как отловить правый Enter (NumPad)?
===================================

::: {.date}
01.01.2007
:::

Автор: Full ( http://full.hotmail.ru/ )

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

Взято из <https://forum.sources.ru>
