---
Title: Хранение стилей шрифта
Date: 01.01.2007
---

Хранение стилей шрифта
======================

::: {.date}
01.01.2007
:::

> Как мне сохранить свойство шрифта Style, ведь он же набор?

Вы можете получать и устанавливать FontStyle через его преобразование к
типу byte.

Для примера,

    Var
      Style: TFontStyles;
    begin
      { Сохраняем стиль шрифта в байте }
      Style := Canvas.Font.Style; {необходимо, поскольку Font.Style - свойство}
      ByteValue := Byte ( Style );
      { Преобразуем значение byte в TFontStyles }
      Canvas.Font.Style := TFontStyles ( ByteValue );
    end;

Для восстановления шрифта, вам необходимо сохранить параметры Color,
Name, Pitch, Style и Size в базе данных и назначить их соответствующим
свойствам при загрузке.

Взято с <https://delphiworld.narod.ru>
