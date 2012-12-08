---
Title: Как скрыть / показать ActiveDesktop?
Date: 01.01.2007
---


Как скрыть / показать ActiveDesktop?
====================================

::: {.date}
01.01.2007
:::

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

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
