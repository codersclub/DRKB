---
Title: Exception при попытке создать обьект класса TPrinter
Date: 01.01.2007
---

Exception при попытке создать обьект класса TPrinter
====================================================

::: {.date}
01.01.2007
:::

В создании обьекта класса TPrinter с использованием TPrinter.Create нет
необходимости,

так как обьект класса TPrinter (называемый Printer) автоматически
создается при

использовании модуля Printers.

Пример:

    uses Printers;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      Printer.BeginDoc;
      Printer.Canvas.TextOut(100, 100, 'Hello World!');
      Printer.EndDoc;
    end;

Взято из

DELPHI VCL FAQ Перевод с английского      

Подборку, перевод и адаптацию материала подготовил Aziz(JINX)

специально для [Королевства Дельфи](https://delphi.vitpc.com/)
