---
Title: Exception при попытке создать обьект класса TPrinter
Date: 01.01.2007
Source: DELPHI VCL FAQ Перевод с английского
---

Exception при попытке создать обьект класса TPrinter
====================================================

В создании обьекта класса TPrinter с использованием TPrinter.Create нет
необходимости, так как обьект класса TPrinter (называемый Printer) автоматически
создается при использовании модуля Printers.

Пример:

    uses Printers;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      Printer.BeginDoc;
      Printer.Canvas.TextOut(100, 100, 'Hello World!');
      Printer.EndDoc;
    end;


Подборку, перевод и адаптацию материала подготовил Aziz(JINX)

специально для [Королевства Дельфи](https://delphi.vitpc.com/)
