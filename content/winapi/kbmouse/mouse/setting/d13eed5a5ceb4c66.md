Как прочитать и изменить doubleclick time?
==========================================

::: {.date}
01.01.2007
:::

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

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
