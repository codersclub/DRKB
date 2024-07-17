---
Title: TCheckBox в TDBGrid
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


TCheckBox в TDBGrid
===================

    procedure DrawGridCheckBox(Canvas: TCanvas; Rect: TRect; Checked: boolean);
    var
      DrawFlags: Integer;
    begin
      Canvas.TextRect(Rect, Rect.Left + 1, Rect.Top + 1, ' ');
      DrawFrameControl(Canvas.Handle, Rect, DFC_BUTTON, DFCS_BUTTONPUSH or DFCS_ADJUSTRECT);
      DrawFlags := DFCS_BUTTONCHECK or DFCS_ADJUSTRECT;// DFCS_BUTTONCHECK
      if Checked then
        DrawFlags := DrawFlags or DFCS_CHECKED;
      DrawFrameControl(Canvas.Handle, Rect, DFC_BUTTON, DrawFlags);
    end; 

На событие OnDrawColumnCell повесьте вызов процедуры DrawGridCheckBox():

    procedure TForm1.DBGrid1DrawColumnCell(Sender: TObject; const Rect: TRect;
      DataCol: Integer; Column: TColumn; State: TGridDrawState);
    begin
      if Column.FieldName = 'WEIGHT' then // Модифицируйте под себя
        if Column.Field.AsInteger > 10 then
          DrawGridCheckBox(DBGrid1.Canvas, Rect, true)
        else
          DrawGridCheckBox(DBGrid1.Canvas, Rect, false)
    end;

Кроме этого, для скрытия текста в ячейках с CheckBox-ом от отображения
значения при вводе с клавиатуры определите реакцию на событие
OnColumnEnter:

    procedure TfrmMain.DBGrid1ColEnter(Sender: TObject);
    begin
      with TDBGrid(Sender) do
        if SelectedField.FieldName = 'Weight' then // Модифицируйте под себя
          Options := Options - [dgEditing]
        else
          Options := Options + [dgEditing]
    end;

