---
Title: Передача текста любому окну, где стоит фокус
Author: Rouse\_
Date: 01.01.2007
---

Передача текста любому окну, где стоит фокус
============================================

::: {.date}
01.01.2007
:::

    procedure TForm1.Timer1Timer(Sender: TObject);

     
    var
      pgui: TGUIThreadinfo;
    begin
      pgui.cbSize := SizeOf(TGUIThreadinfo);
      GetGUIThreadInfo(GetWindowThreadProcessId(GetForegroundWindow), pgui);
      SendMessage(pgui.hwndFocus, WM_SETTEXT, Length(Edit1.Text), Integer(@Edit1.Text[1]));
    end;

Взято из <https://forum.sources.ru>

Автор: Rouse\_
