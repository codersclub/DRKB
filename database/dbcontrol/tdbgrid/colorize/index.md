---
Title: TDBGrid компонент c разными цветами: удаленные, обновленные и добавленные записи
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


TDBGrid компонент c разными цветами: удаленные, обновленные и добавленные записи
================================================================================

    unit atcDBGrid; 
    { 
      (c) Aveen Tech 
      2001 - 2002 
     
      FileName: atcDBGrid.pas 
     
      Version        Date            Author              Comment 
      1.0            13/06/2000      Majid Vafai Jahan  Create. 
     
    OVERVIEW 
      - This grid is inherited from DBGrid and add some required functionality to it. 
     
    Functionality: 
      - Record type are all records that may be modified, unmodified, inserted, deleted. 
      - Coloring according to Record type. 
      - show selected Record Type. 
     
    } 
     
    interface 
     
    uses 
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs, 
      Grids, DBGrids, dbTables, db; 
    const 
      AlignFlags : array [TAlignment] of Integer = 
        ( DT_LEFT or DT_WORDBREAK or DT_EXPANDTABS or DT_NOPREFIX, 
          DT_RIGHT or DT_WORDBREAK or DT_EXPANDTABS or DT_NOPREFIX, 
          DT_CENTER or DT_WORDBREAK or DT_EXPANDTABS or DT_NOPREFIX ); 
      RTL: array [Boolean] of Integer = (0, DT_RTLREADING); 
    type 
      TCachedShow = (csModify, csUnModify, csRemoved, csInserted, csAll, csNormal); 
      TatcDBGrid = class(TDBGrid) 
      private 
        FCachedShow: TCachedShow; 
        FModifiedColor: TColor; 
        FInsertedColor: TColor; 
        FDeletedColor: TColor; 
        procedure SetCachedShow(const Value: TCachedShow); 
      protected 
        procedure DrawDataCell(const Rect: TRect; Field: TField; 
          State: TGridDrawState); override; 
        procedure DrawColumnCell(const Rect: TRect; DataCol: Integer; 
          Column: TColumn; State: TGridDrawState); override; 
      public 
        constructor Create(AOwner: TComponent); override; 
      published 
        property atcCachedShow: TCachedShow read FCachedShow write SetCachedShow; 
        property atcDeletedColor: TColor read FDeletedColor write FDeletedColor; 
        property atcInsertedColor: TColor read FInsertedColor write FInsertedColor; 
        property atcModifiedColor: TColor read FModifiedColor write FModifiedColor; 
      end; 
     
    procedure Register; 
     
    implementation 
     
    procedure Register; 
    begin 
      RegisterComponents('ATC DB Compo', [TatcDBGrid]); 
    end; 
     
    constructor TatcDBGrid.Create(AOwner: TComponent); 
    {Description: Record Type Showing is All except Deletes. }
    begin 
      inherited; 
      FCachedShow := csNormal; 
      FDeletedColor := clGray; 
      FInsertedColor := clAqua; 
      FModifiedColor := clRed; 
    end; 
     
    procedure TatcDBGrid.DrawColumnCell(const Rect: TRect; DataCol: Integer; 
      Column: TColumn; State: TGridDrawState); 
    {Description: On Drawing Column Color Updated Records.}
    var 
      ARect: TRect; 
    begin 
      inherited; 
      if not Assigned(Column.Field) then 
        exit; 
      // Copy Rect into Variable. 
      CopyRect(ARect, Rect); 
      if Assigned(DataLink) and (DataLink.Active) and (DataLink.DataSet <> nil) then 
      begin 
        // если текущая запись изменена
        if DataLink.DataSet.UpdateStatus = usModified then 
        begin 
          Canvas.Brush.Color := atcModifiedColor; 
          Canvas.Font.Color := clBlack; 
          Canvas.FillRect(Rect); 
          DrawText(Canvas.Handle, PChar(Column.Field.Text), Length(Column.Field.Text), ARect, 
           AlignFlags[Column.Alignment] or RTL[UseRightToLeftAlignmentForField(Column.Field, Column.Alignment)]); 
        end 
        // если текущая запись добавлена.
        else if DataLink.DataSet.UpdateStatus = usInserted then 
        begin 
          Canvas.Brush.Color := atcInsertedColor; 
          Canvas.Font.Color := clBlack; 
          Canvas.FillRect(Rect); 
          DrawText(Canvas.Handle, PChar(Column.Field.Text), Length(Column.Field.Text), ARect, 
           AlignFlags[Column.Alignment] or RTL[UseRightToLeftAlignmentForField(Column.Field, Column.Alignment)]); 
        end 
        // если текущая запись удалена.
        else if DataLink.DataSet.UpdateStatus = usDeleted then 
        begin 
          Canvas.Brush.Color := atcDeletedColor; 
          Canvas.Font.Color := clWhite; 
          Canvas.FillRect(Rect); 
          DrawText(Canvas.Handle, PChar(Column.Field.Text), Length(Column.Field.Text), ARect, 
           AlignFlags[Column.Alignment] or RTL[UseRightToLeftAlignmentForField(Column.Field, Column.Alignment)]); 
        end; 
      end; 
    end; 
     
    procedure TatcDBGrid.DrawDataCell(const Rect: TRect; Field: TField; 
      State: TGridDrawState); 
    {Описание: Рисуем ячейки}
    var 
      ARect: TRect; 
    begin 
      inherited; 
      CopyRect(ARect, Rect); 
     
      if Assigned(DataLink) and (DataLink.Active) and (DataLink.DataSet <> nil) then 
      begin 
        // если текущая запись изменена
        if DataLink.DataSet.UpdateStatus = usModified then 
        begin 
          Canvas.Brush.Color := clRed; 
          Canvas.Font.Color := clBlack; 
          Canvas.FillRect(Rect); 
          DrawText(Canvas.Handle, PChar(Field.Text), Length(Field.Text), ARect, 
           AlignFlags[Field.Alignment] or RTL[UseRightToLeftAlignmentForField(Field, Field.Alignment)]); 
        end 
        // если текущая запись добавлена.
        else if DataLink.DataSet.UpdateStatus = usInserted then 
        begin 
          Canvas.Brush.Color := clAqua; 
          Canvas.Font.Color := clBlack; 
          Canvas.FillRect(Rect); 
          DrawText(Canvas.Handle, PChar(Field.Text), Length(Field.Text), ARect, 
           AlignFlags[Field.Alignment] or RTL[UseRightToLeftAlignmentForField(Field, Field.Alignment)]); 
        end 
        // если текущая запись удалена.
        else if DataLink.DataSet.UpdateStatus = usDeleted then 
        begin 
          Canvas.Brush.Color := clGray; 
          Canvas.Font.Color := clWhite; 
          Canvas.FillRect(Rect); 
          DrawText(Canvas.Handle, PChar(Field.Text), Length(Field.Text), ARect, 
           AlignFlags[Field.Alignment] or RTL[UseRightToLeftAlignmentForField(Field, Field.Alignment)]); 
        end; 
      end; 
    end; 
     
    procedure TatcDBGrid.SetCachedShow(const Value: TCachedShow); 
    {Description: Record type for showing in grid. 
     Parameters: Value cached record show. }
    begin 
      FCachedShow := Value; 
      if ComponentState = [csDesigning] then 
        exit; 
      if not Assigned(DataSource) or not Assigned(DataSource.DataSet) then 
        exit; 
      // для показа только выбранного типа записей.
      if Assigned(DataLink) and Assigned(DataLink.DataSet) and (DataLink.Active) then 
      begin 
        case FCachedShow of 
        csAll: 
          TBDEDataSet(DataSource.DataSet).UpdateRecordTypes := [rtModified, rtInserted, rtDeleted, rtUnmodified]; 
        csModify: 
          TBDEDataSet(DataSource.DataSet).UpdateRecordTypes := [rtModified]; 
        csUnModify: 
          TBDEDataSet(DataSource.DataSet).UpdateRecordTypes := [rtUnmodified]; 
        csInserted: 
          TBDEDataSet(DataSource.DataSet).UpdateRecordTypes := [rtInserted]; 
        csRemoved: 
          TBDEDataSet(DataSource.DataSet).UpdateRecordTypes := [rtDeleted]; 
        csNormal: 
          TBDEDataSet(DataSource.DataSet).UpdateRecordTypes := [rtModified, rtInserted, rtUnmodified]; 
        end; 
      end; 
    end; 
     
    end.

