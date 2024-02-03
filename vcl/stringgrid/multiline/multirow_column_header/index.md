---
Title: Многострочность в заголовках колонок TStringGrid
Author: Rick Rogers
Date: 01.01.2007
---


Многострочность в заголовках колонок TStringGrid
================================================

::: {.date}
01.01.2007
:::

Автор: Rick Rogers

У меня есть StringGrid, который выглядит очень красивым, за исключением
заголовков колонок, где я хотел бы иметь их размер равным 1 ячейке, но с
заголовком, размещенным в нескольких строках, например,

Индекс Фондовой Биржи

показывалось бы как

    Индекс
    Фондовой
    Биржи

было бы классно, если можно было этот заголовок размещать еще и по
центру.

Рисовать сами ячейки вы можете в обработчике события OnDrawCell. Для
определения ячейки (заголовок?), обрабатываемой в текущий момент,
используйте параметр GridState.

Я выводил тест с помощью обычных методов рисования (которые хорошо
"приживаются" в данном компоненте), с поддержкой вертикального
выравнивания, полей и переноса слов. Вот сам код:

    TFTVerticalAlignment = (vaTop, vaMiddle, vaBottom);
     
    procedure DrawTextAligned(const Text: string; Canvas: TCanvas;
      var Rect: TRect; Alignment: TAlignment; VerticalAlignment:
      TFTVerticalAlignment; WordWrap: Boolean);
    var
      P: array[0..255] of Char;
      H: Integer;
      T: TRect;
      F: Word;
    begin
      StrPCopy(P, Text);
      T := Rect;
      with Canvas, Rect do
      begin
        F := DT_CALCRECT or DT_EXPANDTABS or DT_VCENTER or
          TextAlignments[Alignment];
        if WordWrap then
          F := F or DT_WORDBREAK;
        H := DrawText(Handle, P, -1, T, F);
        H := MinInt(H, Rect.Bottom - Rect.Top);
        if VerticalAlignment = vaMiddle then
        begin
          Top := ((Bottom + Top) - H) div 2;
          Bottom := Top + H;
        end
        else if VerticalAlignment = vaBottom then
          Top := Bottom - H - 1;
        F := DT_EXPANDTABS or DT_VCENTER or TextAlignments[Alignment];
        if WordWrap then
          F := F or DT_WORDBREAK;
        DrawText(Handle, P, -1, Rect, F);
      end;
    end;
     
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
