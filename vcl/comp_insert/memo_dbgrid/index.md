---
Title: TMemo в TDBGrid
Author: Klaus Herrmann 
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


TMemo в TDBGrid
===============

Распространенной проблемой при работе с DBGrid является то, что этот компонент не может отображать поля TMemo, многострочные столбцы, графику...

Есть несколько хороших бесплатных компонентов для решения этой проблемы.
Лучшим из них, безусловно, является «DBGRIDPLUS», который поставляется с полными исходными кодами.
Однако этот компонент не позволяет редактировать текст в полях-метках.

Поклонники Delphi, купившие версию Delphi, поставляемую с исходными кодами VCL, могут решить эту проблему:

Откройте dbgrids.pas и внесите следующие изменения:
(Чтобы иметь возможность редактирования заметок в вашем приложении,
вам нужно просто добавить измененную версию dbgrids.pas в раздел использования)

    {
    A common problem when working with DBGrid is, that this component can't display TMemo fields,
    multiline columns, Graphics...
    There are a few good freeware components around to solve this problem.
    The best one is definitly "DBGRIDPLUS", which comes with full sources.
    However, this component does not allow to edit the text in memo fields.
    The delphi fans out there who bought a delphi version that comes with the VCL sources can
    fix this problem:
    Open dbgrids.pas and make the following changes:
    (To have memo editing in your app you must just add the modifyed version of dbgrids.pas to your uses clause)
    }
     
    function TCustomDBGrid.GetEditLimit: Integer;
    begin
      Result := 0;
      if Assigned(SelectedField) and (SelectedField.DataType in [ftString, ftWideString, ftMemo]) then // <-- Add
        Result := SelectedField.Size;
    end;
     
    function TCustomDBGrid.GetEditText(ACol, ARow: Longint): string;
    begin
      Result := '';
      if FDatalink.Active then
      with Columns[RawToDataColumn(ACol)] do
        if Assigned(Field) then
          Result := Field.AsString; // <-- Change this.
      FEditText := Result;
    end;
     
    {
    Просто сравните эти отредактированные функции с исходными, и вы поймете, что нужно изменить.
    Чтобы получить поддержку многострочных ячеек (не в полях с заметками!) для DBGridPlus,
     пришлите мне электронное письмо, и я смогу выслать вам измененный файл DBGridPlus.pas.
    }

