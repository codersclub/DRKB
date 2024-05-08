---
Title: Как создать свой пункт меню в Delphi IDE?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как создать свой пункт меню в Delphi IDE?
=========================================

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

