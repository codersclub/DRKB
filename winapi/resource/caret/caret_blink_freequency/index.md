---
Title: Частота мигания каретки
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---

Частота мигания каретки
=======================

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      Label1.Caption := Format('Caret blink time is: %d ms', [GetCaretBlinkTime]);
    end;
     
     
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      // Set caret blink time to 2000ms
      SetCaretBlinkTime(2000);
    end;

