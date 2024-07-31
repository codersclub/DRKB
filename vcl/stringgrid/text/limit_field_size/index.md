---
Title: Ограничение длины поля TStringGrid
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Ограничение длины поля TStringGrid
==================================

Вероятно, это не очень эффективное решение, но оно будет работать:
поместите следующий код в обработчик события onKeyPress:

    if key <> #8 then 
    begin {допускаем backspace/Del}
      len := length(grid.cells[grid.col, grid.row]);
      if len >= ваша желаемая максимальная длина then 
      begin
        messageBeep (0);
        key := #0;
      end;
    end;

После получения вышеуказанным кодом строки s проверяется условие и,

    if Length(s) > maxlengthoffield then exit;

