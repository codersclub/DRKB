---
Title: Как создать свой пункт меню в Delphi IDE?
Date: 01.01.2007
---


Как создать свой пункт меню в Delphi IDE?
=========================================

::: {.date}
01.01.2007
:::

    {....} 
     
    uses ToolsApi, Menus; 
     
    {....} 
     
    var 
      item: TMenuItem; 
    begin 
      {get reference to delphi's mainmenu. You can handle it like a common TMainMenu} 
      with (BorlandIDEServices as INTAServices).GetMainMenu do 
      begin 
        item := TMenuItem.Create(nil); 
        item.Caption := 'A Mewn caption'; 
        Items.Add(item); 
      end; 
    end; 

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
