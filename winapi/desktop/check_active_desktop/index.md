---
Title: Как проверить, включен ли ActiveDesktop?
Date: 01.01.2007
ID: 01819
---


Как проверить, включен ли ActiveDesktop?
========================================

Вариант 1:

Source: <https://forum.sources.ru>


    function IsActiveDeskTopOn: Boolean; 
    var 
      h: hWnd; 
    begin 
      h := FindWindow('Progman', nil); 
      h := FindWindowEx(h, 0, 
                 'SHELLDLL_DefView', nil); 
      h := FindWindowEx(h, 0, 
           'Internet Explorer_Server', nil); 
      Result := h <> 0; 
    end; 

------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    uses
       ComObj, ShlObj, ActiveX;
     
    // Check if Active Desktop is enabled (2) 
    function IsActiveDesktopEnable: Boolean;
    const
      CLSID_ActiveDesktop: TGUID = '{75048700-EF1F-11D0-9888-006097DEACF9}';
    var
      ActiveDesk: IActiveDesktop;
      ComponentsOpt: TComponentsOpt;
      hr: HRESULT;
      dwReserved: DWORD;
    begin
      ZeroMemory(@ComponentsOpt, SizeOf(TComponentsOpt));
      ComponentsOpt.dwSize := SizeOf(TComponentsOpt);
      hr := CoCreateInstance(CLSID_ActiveDesktop, nil, CLSCTX_INPROC_SERVER,
        CLSID_ActiveDesktop, ActiveDesk);
      if SUCCEEDED(hr) then
      begin
        hr := ActiveDesk.GetDesktopItemOptions(ComponentsOpt, dwReserved);
        // ActiveDesk._Release; 
      end;
      Result := ComponentsOpt.fActiveDesktop;
    end;

