---
Title: Как использовать проверку грамматики?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как использовать проверку грамматики?
=====================================

    { 
      If you are using Delphi 2+ and have the ActiveX component TVSSpell, it is very 
      simple to add a spell checker to your TMemo applications. 
      (Note: Do not use this component with a Rich Edit application because of text 
      formatting problems.) 
    } 
     
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      if Memo1.Text = '' then Exit; 
     
      VSSpell1.CheckText := Memo1.Text; 
      if VSSpell1.ResultCode = 0 then 
        Memo1.Text := VSSpell1.Text; 
    end; 
     
     
    { 
      To distribute a VisualSpeller application you have to include the following 
      files: 
     
    } 
     
    { 
    - VsSpell.HLP 
    - VSPELL32.OCX 
    - VSPELL32.DLL 
    - AMERICAN.VTD 
    - VSPELL.HLP 
    } 

