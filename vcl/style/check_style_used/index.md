---
Title: Как определить, использует ли пользователь стили?
Date: 01.01.2007
---


Как определить, использует ли пользователь стили?
=================================================

Вариант 1:

Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>

    function _IsThemeActive: Boolean;
    // Returns True if the user uses XP style
    const
      themelib = 'uxtheme.dll';
    type
      TIsThemeActive = function: BOOL; stdcall;
    var
      IsThemeActive: TIsThemeActive;
      huxtheme: HINST;
    begin
      Result := False;
      // Check if XP or later Version
      if (Win32Platform  = VER_PLATFORM_WIN32_NT) and
         (((Win32MajorVersion = 5) and (Win32MinorVersion >= 1)) or
          (Win32MajorVersion > 5)) then
      begin
        huxtheme := LoadLibrary(themelib);
        if huxtheme <> 0 then
        begin
          try
            IsThemeActive := GetProcAddress(huxtheme, 'IsThemeActive');
            Result := IsThemeActive;
          finally
           if huxtheme > 0 then
              FreeLibrary(huxtheme);
          end;
        end;
      end;
    end;
     
    // Example Call:
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
     if _IsThemeActive then
       ShowMessage('Windows Themes are active.');
    end;


------------------------------------------------------------------------

Вариант 2:

Author: Alex

Source: Vingrad.ru <https://forum.vingrad.ru>

    uses
    Themes;
    ...
    if ThemeServices.ThemesEnabled then // Тема использется

