---
Title: How to send and receive email
Date: 01.01.2007
ID: 04453
---


How to send and receive email
=============================

This code activates the Tools\|Send and Receive\|All accounts menu item:

    uses Office_TLB; // Office97 for D5 users
    var
      ToolsMenu: CommandBar;
      SendRecMenuItem, AllAccs: CommandBarControl;
    begin
      ToolsMenu := (Outlook.ActiveExplorer.CommandBars as CommandBars).Item['Tools'];
     
      // D5 users can omit the underscore after 'Controls' in the next two lines
      SendRecMenuItem := ToolsMenu.Controls_['Send and Receive'];
      AllAccs := (SendRecMenuItem.Control as CommandBarPopup).Controls_['All Accounts'];
      AllAccs.Execute;

 

If you\'re using Outlook 2000, you\'ll have to change \'Send and
Receive\', perhaps to \'Send/Receive\'. (I\'ve had one report that this
works, one that it doesn\'t - perhaps there are spaces around the \'/\'?
Any clarification of this would be very welcome! Pointless menu changes
don\'t make automation any easier...)
