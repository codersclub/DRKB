---
Title: Свойства шрифта Style и Color в виде строки
Author: Dennis Passmore
Date: 01.01.2007
---

Свойства шрифта Style и Color в виде строки
===========================================

::: {.date}
01.01.2007
:::

Автор: Dennis Passmore

Как мне получить значение Font.Style и Font.Color в виде строки, я хотел
бы присвоить его заголовку компонента Label, но style и color не
являются строковыми величинами.

Есть масса способов это сделать, но я использую следующий способ:

    const
      fsTextName: array[TFontStyle] of string[11] = ('fsBold', 'fsItalic', 'fsUnderline', 'fsStrikeOut');
      fpTextName: array[TFontPitch] of string[10] = ('fpDefault','fpVariable','fpFixed');

Позже, в коде, я так использую эти имена:

    var
      TFPitch: TFontPitch;
      TFStyle: TFontStyle;
      FString: String;
    ...
     
    FString := '';
    for TFStyle := fsBold to fsStrikeOut do
      if TFStyle in Canvas.Font.Style then
        Fstring := Fstring+fsTextName[TFStyle]+',';
    if FString<>'' then
      dec(FString[0]); { убираем лишний разделитель ',' }
    something := FString;
     
    FString := fpTextName[Canvas.Font.Pitch];
    something := FString;

Примерно также нужно поступить и с именованными цветами типа TColor.

Взято с <https://delphiworld.narod.ru>

---
Примечание Vit

Описанный здесь способ относится скорее к тем,
которые указывают как не надо делать.
Эта задача решается намного изящнее здесь:

[Как получить строковое значение перечисляемого типа?](/language/classinfo/2e7d713e29554829/)
