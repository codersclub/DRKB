<h1>Как создать простейший эксперт?</h1>
<div class="date">01.01.2007</div>


<pre>
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
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
