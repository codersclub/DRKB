---
Title: Как найти SMTP Mail Server по умолчанию?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как найти SMTP Mail Server по умолчанию?
========================================

    { 
      Here is some code I successfully used te determine 
      the DEFAULT mailaccount, which is used in 
      Outlook Express, to send outgoing mail via SMTP. 
    } 
     
    procedure TForm1.ReadRegistryDefaults; 
    var 
      Registry: TRegistry; 
      AccountStr: string; 
    begin 
      Registry := TRegistry.Create; 
      try 
        Registry.RootKey := hkey_CURRENT_USER; 
        if Registry.OpenKey('software\microsoft\internet account manager', False) then  {} 
        begin 
          AccountStr := Registry.ReadString('default mail account'); 
          Registry.CloseKey; 
          if (AccountStr <> '') then 
            if Registry.OpenKey('software\microsoft\internet account manager\accounts\' + 
              AccountStr, False) then  {} 
            begin 
              Edit_Server.Text  := Registry.ReadString('SMTP Server'); 
              Edit_Account.Text := Registry.ReadString('SMTP Email Address'); 
              Registry.CloseKey; 
            end; 
        end; 
      finally 
        Registry.Free; 
      end; 
    end; 

