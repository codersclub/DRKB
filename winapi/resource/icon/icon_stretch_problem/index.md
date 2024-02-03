---
Title: Проблемы с TCanvas.StretchDraw при рисовании иконок
Date: 01.01.2007
---

Проблемы с TCanvas.StretchDraw при рисовании иконок
===================================================

::: {.date}
01.01.2007
:::

При попытке использовать метод TCanvas.StretchDraw чтобы нарисовать
иконку

увеличенной ее размер не изменяется. Что делать?

Иконки всегда рисуются размером принятым в системе по умолчанию. Чтобы
показать увеличенный вид иконки скоприуйте ее на bitmap, а зате
используйте метод TCanvas.StretchDraw.

    procedure TForm1.Button1Click(Sender: TObject);
    var
      TheBitmap: TBitmap;
    begin
      TheBitmap := TBitmap.Create;
      TheBitmap.Width := Application.Icon.Width;
      TheBitmap.Height := Application.Icon.Height;
      TheBitmap.Canvas.Draw(0, 0, Application.Icon);
      Form1.Canvas.StretchDraw(Rect(0, 0, TheBitmap.Width * 3, TheBitmap.Height * 3),
        TheBitmap);
      TheBitmap.Free;
    end;
