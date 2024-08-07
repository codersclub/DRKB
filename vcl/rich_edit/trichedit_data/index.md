---
Title: Как поместить данные в TRichEdit-контролл?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как поместить данные в TRichEdit-контролл?
==========================================

    unit dbrich; 
    interface 
     
    uses 
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs, 
      StdCtrls, ComCtrls, DB, DBTables, Menus, ExtCtrls, Mask, Buttons, DBCtrls; 
     
    //Замечание: вызывать Tablex.Edit необходимо перед изменением свойства paragraph
     
    type 
      TDBRichEdit = class(TRichEdit) 
      private 
        FDataLink: TFieldDataLink; 
        FAutoDisplay: Boolean; 
        FFocused: Boolean; 
        FMemoLoaded: Boolean; 
        FPaintControl: TPaintControl; 
        procedure DataChange(Sender: TObject); 
        procedure EditingChange(Sender: TObject); 
        function  GetDataField: string; 
        function  GetDataSource: TDataSource; 
        function  GetField: TField; 
        function  GetReadOnly: Boolean; 
        procedure SetDataField(const Value: string); 
        procedure SetDataSource(Value: TDataSource); 
        procedure SetReadOnly(Value: Boolean); 
        procedure SetAutoDisplay(Value: Boolean); 
        procedure SetFocused(Value: Boolean); 
        procedure UpdateData(Sender: TObject); 
        procedure WMCut(var Message: TMessage); message WM_CUT; 
        procedure WMPaste(var Message: TMessage); message WM_PASTE; 
        procedure CMEnter(var Message: TCMEnter); message CM_ENTER; 
        procedure CMExit(var Message: TCMExit); message CM_EXIT; 
        procedure WMLButtonDblClk(var Message: TWMLButtonDblClk); 
          message WM_LBUTTONDBLCLK; 
        procedure WMPaint(var Message: TWMPaint); message WM_PAINT; 
        procedure CMGetDataLink(var Message: TMessage); message CM_GETDATALINK; 
      protected 
        procedure Change; override; 
        procedure KeyDown(var Key: Word; Shift: TShiftState); override; 
        procedure KeyPress(var Key: Char); override; 
        procedure Notification(AComponent: TComponent; 
          Operation: TOperation); override; 
        procedure WndProc(var Message: TMessage); override; 
      public 
        constructor Create(AOwner: TComponent); override; 
        destructor Destroy; override; 
        procedure  LoadMemo; 
        property   Field: TField read GetField; 
      published 
        property AutoDisplay: Boolean read FAutoDisplay write SetAutoDisplay 
          default True; 
        property DataField: string read GetDataField write SetDataField; 
        property DataSource: TDataSource read GetDataSource write SetDataSource; 
        property ReadOnly: Boolean read GetReadOnly write SetReadOnly 
          default False; 
      end; 
     
    procedure Register; 
     
    implementation 
     
    procedure Register; 
    begin 
      RegisterComponents('Data Controls', [TDBRichEdit]); 
    end; 
     
    {Mostly copied from DBMemo} 
     
    constructor TDBRichEdit.Create(AOwner: TComponent); 
    begin 
      inherited Create(AOwner); 
      inherited ReadOnly := True; 
      FAutoDisplay := True; 
      FDataLink := TFieldDataLink.Create; 
      FDataLink.Control := Self; 
      FDataLink.OnDataChange := DataChange; 
      FDataLink.OnEditingChange := EditingChange; 
      FDataLink.OnUpdateData := UpdateData; 
      FPaintControl := TPaintControl.Create(Self, 'EDIT'); 
    end; 
     
    destructor TDBRichEdit.Destroy; 
    begin 
      FPaintControl.Free; 
      FDataLink.Free; 
      FDataLink := nil; 
      inherited Destroy; 
    end; 
     
    procedure TDBRichEdit.Notification(AComponent: TComponent; 
      Operation: TOperation); 
    begin 
      inherited Notification(AComponent, Operation); 
      if (Operation = opRemove) and (FDataLink <> nil) and 
        (AComponent = DataSource) then DataSource := nil; 
    end; 
     
    procedure TDBRichEdit.KeyDown(var Key: Word; Shift: TShiftState); 
    begin 
      inherited KeyDown(Key, Shift); 
      if FMemoLoaded then 
      begin 
        if (Key = VK_DELETE) or ((Key = VK_INSERT) and (ssShift in Shift)) then 
          FDataLink.Edit; 
      end else 
        Key := 0; 
    end; 
     
    procedure TDBRichEdit.KeyPress(var Key: Char); 
    begin 
      inherited KeyPress(Key); 
      if FMemoLoaded then 
      begin 
        if (Key in [#32..#255]) and (FDataLink.Field <> nil) and 
          not FDataLink.Field.IsValidChar(Key) then 
        begin 
          MessageBeep(0); 
          Key := #0; 
        end; 
        case Key of 
          ^H, ^I, ^J, ^M, ^V, ^X, #32..#255: 
            FDataLink.Edit; 
          #27: 
            FDataLink.Reset; 
        end; 
      end else 
      begin 
        if Key = #13 then LoadMemo; 
        Key := #0; 
      end; 
    end; 
     
    procedure TDBRichEdit.Change; 
    begin 
      with FdataLink do 
      begin 
        {if Assigned(FdataLink) and (Assigned(DataSource))and 
         (DataSource.State = dsBrowse) then 
          Edit; } {make sure edits on Attributes change} 
        if FMemoLoaded then Modified; 
      end; 
      FMemoLoaded := True; 
      inherited Change; 
    end; 
     
    function TDBRichEdit.GetDataSource: TDataSource; 
    begin 
      Result := FDataLink.DataSource; 
    end; 
     
    procedure TDBRichEdit.SetDataSource(Value: TDataSource); 
    begin 
      FDataLink.DataSource := Value; 
      if Value <> nil then Value.FreeNotification(Self); 
    end; 
     
    function TDBRichEdit.GetDataField: string; 
    begin 
      Result := FDataLink.FieldName; 
    end; 
     
    procedure TDBRichEdit.SetDataField(const Value: string); 
    begin 
      FDataLink.FieldName := Value; 
    end; 
     
    function TDBRichEdit.GetReadOnly: Boolean; 
    begin 
      Result := FDataLink.ReadOnly; 
    end;

