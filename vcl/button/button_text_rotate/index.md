---
Title: Как текст на кнопке расположить под заданным углом?
Date: 01.01.2007
---


Как текст на кнопке расположить под заданным углом?
===================================================

::: {.date}
01.01.2007
:::

Как выдать текст под наклоном?

Чтобы вывести под любым углом текст необходимо использовать TrueType
Fonts (например «Arial»). Например:

    var
      LogFont: TLogFont;
    begin
      GetObject(Canvas.Font.Handle, SizeOf(TLogFont), @LogFont);
      {Вывести текст 1/10 градуса против часовой стрелки}
      LogFont.lfEscapement := Angle * 10;
      Canvas.Font.Handle := CreateFontIndirect(LogFont);
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
