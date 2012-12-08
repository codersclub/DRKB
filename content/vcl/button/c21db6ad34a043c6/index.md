---
Title: Можно ли использовать иконку как картинку на кнопке TSpeedButton?
Date: 01.01.2007
---


Можно ли использовать иконку как картинку на кнопке TSpeedButton?
=================================================================

::: {.date}
01.01.2007
:::

    uses ShellApi;
     
    procedure TForm1.FormShow(Sender: TObject);
    var
      Icon: TIcon;
    begin
      Icon := TIcon.Create;
      Icon.Handle := ExtractIcon(0, 'C:\WINDOWS\NOTEPAD.EXE', 1);
      SpeedButton1.Glyph.Width := Icon.Width;
      SpeedButton1.Glyph.Height := Icon.Height;
      SpeedButton1.Glyph.Canvas.Draw(0, 0, Icon);
      Icon.Free;
    end;
