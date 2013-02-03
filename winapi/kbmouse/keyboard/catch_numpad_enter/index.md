---
Title: Как отловить правый Enter (NumPad)
Date: 01.01.2007
---


Как отловить правый Enter (NumPad)
==================================

::: {.date}
01.01.2007
:::

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

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
