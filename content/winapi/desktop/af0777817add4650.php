<h1>Как проверить, включен ли ActiveDesktop?</h1>
<div class="date">01.01.2007</div>


<pre>
function IsActiveDeskTopOn: Boolean; 
var 
  h: hWnd; 
begin 
  h := FindWindow('Progman', nil); 
  h := FindWindowEx(h, 0, 
             'SHELLDLL_DefView', nil); 
  h := FindWindowEx(h, 0, 
       'Internet Explorer_Server', nil); 
  Result := h &lt;&gt; 0; 
end; 
</pre>

&copy;Drkb::01819 </p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<hr />
<pre>
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
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

