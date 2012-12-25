---
Title: Отключить реакцию на события мыши
Date: 01.01.2007
---


Отключить реакцию на события мыши
=================================

::: {.date}
01.01.2007
:::

    procedure TForm1.ApplicationEvents1Message(var Msg: tagMSG;
      var Handled: Boolean);
    begin
      Handled := (msg.wParam = vk_lButton) or
                 (msg.wParam = vk_rButton) or
                 (msg.wParam = vk_mButton);
    end;
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
