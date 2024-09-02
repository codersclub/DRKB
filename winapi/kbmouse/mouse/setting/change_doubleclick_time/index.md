---
Title: Как прочитать и изменить doubleclick time?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как прочитать и изменить doubleclick time?
==========================================

    // Set example:
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      // will reset after system start
      SetDoubleClickTime(1500);
    end;
     
    // Get example:
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      ShowMessage(IntToStr(GetDoubleClickTime));
    end;

