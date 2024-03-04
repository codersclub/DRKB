---
Title: TDBGrid.DefaultDrawDataCell
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


TDBGrid.DefaultDrawDataCell
===========================

TDBGrid имеет недокументированный в электронной справке метод
DefaultDrawDataCell.

Вот пример его использования:

    procedure TForm1.DBGrid1DrawDataCell(Sender: TObject;
    const Rect: TRect; Field: TField; State: TGridDrawState);
    begin
      with Sender as TDBGrid do
      begin
        Canvas.Font.Color := clRed;
        DefaultDrawDataCell(Rect, Field, State);
      end;
    end;

