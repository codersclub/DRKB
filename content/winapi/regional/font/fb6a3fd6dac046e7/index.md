---
Title: Список шрифтов, совместимых одновременно с экраном и с принтером
Date: 01.01.2007
---

Список шрифтов, совместимых одновременно с экраном и с принтером
================================================================

::: {.date}
01.01.2007
:::

Эти установки должны показать шрифты совместимые либо с принтером либо с
экраном. В примере диалог Windows ChooseFont вызывается напрямую чтобы
показать список шрифтов, совместимых одновременно и с экраном и с
принтером.

Пример:

    uses Printers, CommDlg;
     
    procedure TForm1.Button1Click(Sender: TObject);
     var cf: TChooseFont; lf: TLogFont; tf: TFont;
    begin
      if PrintDialog1.Execute then
      begin
        cf.hdc := Printer.Handle;
        cf.lpLogFont := @lf;
        cf.iPointSize := Form1.Canvas.Font.Size * 10;
        cf.Flags := CF_BOTH or CF_INITTOLOGFONTSTRUCT or
         CF_EFFECTS or CF_SCALABLEONLY or CF_WYSIWYG;
        cf.rgbColors := Form1.Canvas.Font.Color;
        tf.COlor := cf.RgbColors;
        Form1.Canvas.Font.Assign(tf);
        tf.Free;
        Form1.Canvas.TextOut(10, 10, 'Test');
      end;
    end;

Взято с <https://delphiworld.narod.ru>
