---
Title: Как запустить другое приложение?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как запустить другое приложение?
================================

    uses 
      libc; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    var 
      iPrg: Integer; 
    begin 
      //Execute kcalc - A calculator for KDE 
      iPrg := libc.system('kcalc'); 
      if iPrg = -1 then 
        ShowMessage('Error executing your program'); 
    end; 

