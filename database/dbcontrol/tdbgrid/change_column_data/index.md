---
Title: Как заменить данные в столбце компонента TDBGrid?
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Как заменить данные в столбце компонента TDBGrid?
=================================================

Нередко в колонке DBGrid нужно вывести не реальное значение, хранящееся
в поле соответствующей таблицы, а другие данные, соответствующие
имеющимся (например, символьную строку вместо ее числового кода). В этом
случае также используется метод TextOut свойства Canvas компонента
TDBGrid:

Соответствующий код для Delphi имеет вид:

    procedure TForm1.DBGridDrawColumnCell(Sender: TObject; const Rect: TRect;
    DataCol: Integer; Column: TColumn;  State: TGridDrawState);
    begin
      if Column.FieldName = 'VenueNo' then
        with DBGrid1.Canvas do
        begin
          Brush.Color := clWhite;
          FillRect(Rect);
          if Table.FieldByName('VanueNo').Value = 1 then
          begin
            Font.Color := clRed;
            TextOut(Rect.Right - 2 - DBGrid1.Canvas.TextWidth('our vanue'),
            Rect.Top + 2, 'our vanue');
          end
          else
            TextOut(Rect.Right - 2 - DBGrid1.Canvas.TextWidth('other vanue'),
            Rect.Top + 2, 'other vanue');
        end;
    end;

Еще один пример - использование значков из шрифтов Windings или
Webdings в качестве подставляемой строки.

Соответствующий код для Delphi имеет вид:

    procedure TForm1.DBGridDrawColumnCell(Sender: TObject; const Rect: TRect;
    DataCol: Integer; Column: TColumn;  State: TGridDrawState);
    begin
      if Column.FieldName = 'VenueNo' then
        with DBGrid1.Canvas do
        begin
          Brush.Color := clWhite;
          FillRect(Rect);
          Font.name := 'Windings';
          Font.Size := -14;
          if Table.FieldByName('VanueNo').Value = 1 then
          begin
            Font.Color := clRed;
            TextOut(Rect.Right - 2 - DBGrid1.Canvas.TextWidth('J'),
            Rect.Top + 2, 'J');
          end
          else
            TextOut(Rect.Right - 2 - DBGrid1.Canvas.TextWidth('F'),
            Rect.Top + 2, 'F');
        end;
    end;

