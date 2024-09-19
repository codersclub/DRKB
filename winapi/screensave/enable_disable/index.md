---
Title: Как включить / отключить хранитель экрана?
Date: 01.01.2007
---

Как включить / отключить хранитель экрана?
==========================================

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      {Turn it off}
      SystemParametersInfo(SPI_SETSCREENSAVEACTIVE, 0, nil, 0);
      {Turn it on}
      SystemParametersInfo(SPI_SETSCREENSAVEACTIVE, 1, nil, 0);
    end;
