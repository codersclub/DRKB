<h1>Работа с Photoshop</h1>
<div class="date">01.01.2007</div>


<pre>
 
uses
  ComObj, ActiveX, PhotoShopTypeLibrary_TLB;
 
var
  PS: IPhotoShopApplication;
  Unknown: IUnknown;
begin
  Result := GetActiveObject(CLASS_PhotoshopApplication, nil, Unknown);
  if (Result = MK_E_UNAVAILABLE) then
    PS := CoPhotoshopApplication.Create
  else
  begin
    { make sure no other error occurred }
    OleCheck(Result);
    OleCheck(Unknown.QueryInterface(IPhotoShopApplication, PS));
  end;
  PS.Visible := True;
end;
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
