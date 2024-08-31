---
Title: Как отловить правый Enter (NumPad)
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Как отловить правый Enter (NumPad)
==================================

Для этого можно воспользоваться функцией GetHeapStatus:

    procedure TForm1.WMKeyDown(var message: TWMKeyDown);
    begin
      inherited;
      case message.CharCode of
        VK_RETURN:
        begin
          if (message.KeyData and $1000000 <> 0) then
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


