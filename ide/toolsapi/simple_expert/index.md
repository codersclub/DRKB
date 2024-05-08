---
Title: Как создать простейший эксперт?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как создать простейший эксперт?
===============================

    { 
    This unit can be compiled into a package and will then appear in the Delphi 
    Help menu. 
    } 
    unit SDCSimpleExpert; 
     
    interface 
     
    uses ToolsApi; 
     
    type 
      TSDCSimpleExpert = class(TNotifierObject, IOTAMenuWizard, IOTAWizard) 
      public 
        function GetIDString: string; 
        function GetName: string; 
        function GetState: TWizardState; 
        procedure Execute; 
        function GetMenuText: string; 
      end; 
     
    procedure Register; 
     
    implementation 
     
    uses Dialogs; 
     
    procedure Register; 
    begin 
      {register expert} 
      RegisterPackageWizard(TSDCSimpleExpert.Create); 
    end; 
     
    { TSDCSimpleExpert } 
     
    procedure TSDCSimpleExpert.Execute; 
    begin 
      {code to execute when menu item is clicked} 
      ShowMessage('Hello SwissDelphiCenter Simple Expert.'); 
    end; 
     
    function TSDCSimpleExpert.GetIDString: string; 
    begin 
      {unique expert identifier} 
      Result := 'SwissDelphiCenter.SimpleExpert'; 
    end; 
     
    function TSDCSimpleExpert.GetMenuText: string; 
    begin 
      {caption of menu item in help menu} 
      Result := 'SwissDelphiCenter Simple Expert'; 
    end; 
     
    function TSDCSimpleExpert.GetName: string; 
    begin 
      {name of the expert} 
      Result := 'SwissDelphiCenter Simple Expert'; 
    end; 
     
    function TSDCSimpleExpert.GetState: TWizardState; 
    begin 
      Result := [wsEnabled]; 
    end; 
     
    end. 

