---
Title: Список handle всех окон моего приложения
Date: 01.01.2007
---


Список handle всех окон моего приложения
========================================

::: {.date}
01.01.2007
:::

    function EnumProc(wnd: HWND; var count: DWORD): Bool; stdcall;
    begin
      Inc(count);
      result := True;
      EnumChildWindows(wnd, @EnumProc, integer(@count));
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      count: DWORD;
    begin
      count := 0;
      EnumThreadWindows(GetCurrentThreadID, @EnumProc, Integer(@count));
      Caption := Format('%d window handles in use', [count]);
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
