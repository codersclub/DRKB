---
Title: Как получить имя текщего стиля и имя цветовой схемы?
Date: 01.01.2007
---


Как получить имя текщего стиля и имя цветовой схемы?
====================================================

::: {.date}
01.01.2007
:::

    uses ComObj, SyncObjs;
     
    var
      GetCurrentThemeName: function (pszThemeFileName: LPWSTR; cchMaxNameChars: Integer;
        pszColorBuff: LPWSTR; cchMaxColorChars: Integer; pszSizeBuff: LPWSTR;
        cchMaxSizeChars: Integer): HRESULT; stdcall;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      FileName, ColorScheme, SizeName: WideString;
      hThemeLib: THandle;
    begin
      try
        hThemeLib := LoadLibrary('uxtheme.dll');
        if hThemeLib > 0 then
          GetCurrentThemeName := GetProcAddress(hThemeLib, 'GetCurrentThemeName');
        if Assigned(GetCurrentThemeName) then
        begin
          SetLength(FileName, 255);
          SetLength(ColorScheme, 255);
          SetLength(SizeName, 255);
          OleCheck(GetCurrentThemeName(PWideChar(FileName), 255,
            PWideChar(ColorScheme), 255, PWideChar(SizeName), 255));
          // show the the theme path and file name.
          ShowMessage(PWideChar(FileName));
          // show the color scheme name
          ShowMessage(PWideChar(ColorScheme));
          // show the size name
          ShowMessage(PWideChar(SizeName));
        end;
      finally
        FreeLibrary(hThemeLib);
      end;
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
