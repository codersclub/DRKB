---
Title: Работа с Photoshop
Date: 01.01.2007
---


Работа с Photoshop
==================

::: {.date}
01.01.2007
:::

     
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

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
