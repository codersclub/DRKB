---
Title: Частота мигания каретки
Date: 01.01.2007
---

Частота мигания каретки
=======================

::: {.date}
01.01.2007
:::

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      Label1.Caption := Format('Caret blink time is: %d ms', [GetCaretBlinkTime]);
    end;
     
     
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      // Set caret blink time to 2000ms
      SetCaretBlinkTime(2000);
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
