<h1>Как скрыть / показать ActiveDesktop?</h1>
<div class="date">01.01.2007</div>


<pre>
uses
  ComObj, ShlObj, ActiveX;
 
procedure EnableActiveDesktop(bValue: Boolean);
const
  CLSID_ActiveDesktop: TGUID = (D1: $75048700; D2: $EF1F; D3: $11D0;
    D4: ($98, $88, $00, $60, $97, $DE, $AC, $F9));
var
  MyObject: IUnknown;
  ActiveDesk: IActiveDesktop;
  twpoComponentOpt: TComponentsOpt;
begin
  MyObject := CreateComObject(CLSID_ActiveDesktop);
  ActiveDesk := MyObject as IActiveDesktop;
  with twpoComponentOpt do
  begin
    ZeroMemory(@twpoComponentOpt, SizeOf(TComponentsOpt));
    dwSize := SizeOf(twpoComponentOpt);
    fEnableComponents := bValue;
    // fActiveDesktop := True;
  end;
  ActiveDesk.SetDesktopItemOptions(twpoComponentOpt, 0);
  ActiveDesk.ApplyChanges(AD_APPLY_ALL);
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
