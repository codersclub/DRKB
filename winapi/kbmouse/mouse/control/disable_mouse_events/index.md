---
Title: Отключить реакцию на события мыши
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Отключить реакцию на события мыши
=================================

    procedure TForm1.ApplicationEvents1Message(var Msg: tagMSG;
      var Handled: Boolean);
    begin
      Handled := (msg.wParam = vk_lButton) or
                 (msg.wParam = vk_rButton) or
                 (msg.wParam = vk_mButton);
    end;

