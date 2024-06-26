---
Title: Как поместить графическое изображение в TDBGrid?
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Как поместить графическое изображение в TDBGrid?
================================================

Использование свойства Canvas компонента TDBGrid в методе
OnDrawColumnCell позволяет не только выводить в ячейке текст методом
TextOut, но и размещать в ячейках графические изображения. В этом случае
используется метод Draw свойства Canvas.

Модифицируем наш пример, добавив в форму компонент TImageList и поместив
в него несколько изображений.

Модифицируем код нашего приложения:

Соответствующий код для Delphi имеет вид:

    procedure TForm1.DBGridDrawColumnCell(Sender: TObject; const Rect: TRect;
    DataCol: Integer; Column: TColumn;  State: TGridDrawState);
    var
      Im1: TBitmap;
    begin
      Im1 := TBitmap.Create;
      if Column.FieldName = 'VenueNo' then
        with DBGrid1.Canvas do
        begin
          Brush.Color := clWhite;
          FillRect(Rect);
          if Table.FieldByName('VanueNo').Value = 1 then
            ImageList1.GetBitmap(0, Im1)
          else
            ImageList1.GetBitmap(2, Im1);
          Draw(round((Rect.Left + Rect.Right - Im1.Width) / 2), Rect.Top, Im1);
        end;
    end;

Теперь в TDBGrid в колонке VenueNo находятся графические изображения.

