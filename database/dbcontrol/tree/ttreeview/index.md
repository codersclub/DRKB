---
Title: TTreeView - компонент для показа dataset в виде дерева с сохранением
Author: Валентин, visor123@ukr.net
Date: 09.04.2003
---


TTreeView - компонент для показа dataset в виде дерева с сохранением
=====================================================================

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> TreeView - компонент для показа dataset в виде дерева с сохранением
     
    Цель создания: необходимость быстрого выбора товара из справочника в виде дерева.
    Компонент для визуализации дерева из таблицы. привязка к полям не ведется.
    Ключевое поле находится в node.stateindex.
     
    Использует 4 иконки для узлов и позиций, где 0 - невыбранный узел,
    1 - выбранный узел, 2 - невыбранный пункт, 3 - выбранный пункт.
     
    Необходимо выбрать datasource. вписать id, parentid.
    Заполнение методом MRRefresh.
    Сохранение в файл методом
    MRPSaveToFile(ProgPath+'NameTree.tree').
    Загрузка из файла соответственно MRPLoadFromFile(ProgPath+'NameTree.tree').
    Кроме того поддерживаются метода последовательно поиска в обоих направлениях.
     
    Зависимости: Windows, Messages, SysUtils, Classes, Controls, ComCtrls,DB,DBCtrls
    Автор:       Валентин, visor123@ukr.net, Днепропетровск
    Copyright:   Собственная разработка.
    Дата:        9 апреля 2003 г.
    ***************************************************** }
     
    unit GRTreeView;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Controls, ComCtrls, DB, DBCtrls,
      Dialogs;
     
    type
      TMRGroupRec = record
        ID, MasterID, Level: integer;
        MainName: string;
      end;
      TMRGroup = class(TPersistent)
      private
        fCount: integer;
      protected
        procedure SetCount(value: integer);
      public
        items: array of TMRGroupRec;
        property Count: integer read fCount write SetCount;
        constructor Create;
        destructor destroy; override;
        procedure Clear;
        procedure Add(AID, AMasterID: integer; AMainName: string);
        function GetIndexByMasterID(AMasterID: integer): integer;
      end;
      TGRTreeView = class(TTreeView)
      private
        { Private declarations }
        fDataSource: TDataLink;
        fFeyField: TFieldDataLink;
        fMasterFeyField: TFieldDataLink;
        fNameField: TFieldDataLink;
        // fRootName:string;
        fSeparator: Char;
        fLock: Boolean;
        fSearchIndex: integer;
        function GetBufStart(Buffer: PChar; var Level: Integer): PChar;
      protected
        { Protected declarations }
        function GetDataSource: TDataSource;
        procedure SetDataSource(value: TDataSource);
        function GetKeyField: string;
        procedure SetKeyField(value: string);
        function GetMasterKeyField: string;
        procedure SetMasterKeyField(value: string);
        function GetNameField: string;
        procedure SetNameField(value: string);
        procedure SetSeparator(value: char);
        procedure GetImageIndex(Node: TTreeNode); override;
      public
        { Public declarations }
        constructor Create(AOwner: TComponent); override;
        destructor destroy; override;
        function MRRefresh: Boolean;
        procedure MRPLoadFromFile(const FileName: string); overload;
        procedure MRPLoadFromFile(const FileName: string; RootName: string);
          overload;
        procedure MRPLoadFromStream(Stream: TStream);
        procedure MRPSaveToFile(const FileName: string);
        procedure MRPSaveToStream(Stream: TStream);
        function MRGetIndexByText(AText: string): integer;
        function MRGetIndexByMasterID(MasterID: integer): integer;
        function MRGetIndexByMasterIDRecurse(MasterID: integer): integer;
        function MRSearchByText(AText: string; Next: Boolean = True; UseSearchIndex:
          Boolean = false): integer;
      published
        { Published declarations }
        property Separator: char read fSeparator write SetSeparator;
        property DataSource: TDataSource read GetDataSource write SetDataSource;
        property KeyField: string read GetKeyField write SetKeyField;
        property MasterField: string read GetMasterKeyField write SetMasterKeyField;
        property NameField: string read GetNameField write SetNameField;
      end;
     
    procedure Register;
     
    implementation
    //var
    // MGRGroup:array of TMRGroup;
     
    procedure Register;
    begin
      RegisterComponents('Visor', [TGRTreeView]);
    end;
     
    { TGRTreeView }
     
    constructor TGRTreeView.Create(AOwner: TComponent);
    begin
      inherited Create(AOwner);
      fDataSource := TDataLink.Create;
      fFeyField := TFieldDataLink.Create;
      fFeyField.Control := self;
      fMasterFeyField := TFieldDataLink.Create;
      fMasterFeyField.Control := self;
      fNameField := TFieldDataLink.Create;
      fNameField.Control := self;
      fSeparator := '^';
      fLock := false;
      HideSelection := false;
      fSearchIndex := -1;
    end;
     
    destructor TGRTreeView.destroy;
    begin
      fNameField.Free;
      fNameField := nil;
      fFeyField.Free;
      fFeyField := nil;
      fDataSource.Free;
      fDataSource := nil;
      inherited;
    end;
     
    function TGRTreeView.GetBufStart(Buffer: PChar; var Level: Integer): PChar;
    begin
      Level := 0;
      while Buffer^ in [' ', #9] do
      begin
        Inc(Buffer);
        Inc(Level);
      end;
      Result := Buffer;
    end;
     
    function TGRTreeView.GetDataSource: TDataSource;
    begin
      Result := fDataSource.DataSource;
    end;
     
    procedure TGRTreeView.MRPLoadFromFile(const FileName: string);
    var
      Stream: TStream;
      FNT, FNR, Ex: string;
    begin
      if not FileExists(FileName) then
        Exit;
      Ex := ExtractFileExt(FileName);
      if Ex = '' then
      begin
        FNT := ExtractFileName(FileName) + '.tree';
        FNR := ExtractFileName(FileName) + '.ini';
      end
      else
      begin
        FNT := ExtractFileName(FileName);
        FNT := Copy(FNT, 0, pos('.', FNT) - 1);
        FNR := FNT + '.ini';
        FNT := FNT + '.tree';
      end;
      FNT := ExtractFilePath(FileName) + FNT;
      FNR := ExtractFilePath(FileName) + FNR;
      Stream := TFileStream.Create(FNT, fmOpenRead);
      try
        MRPLoadFromStream(Stream);
      finally
        Stream.Free;
      end;
    end;
     
    function TGRTreeView.MRGetIndexByText(AText: string): integer;
    var
      i: integer;
    begin
      if Items.Count = 0 then
      begin
        Result := -1;
        Exit;
      end;
      for i := 0 to Items.Count - 1 do
      begin
        if Items.Item[i].Text = AText then
        begin
          Result := i;
          Exit;
        end;
      end;
      Result := -1;
    end;
     
    procedure TGRTreeView.MRPLoadFromFile(const FileName: string;
      RootName: string);
    var
      FNT, FNR, Ex: string;
      ANode: TTreeNode;
    begin
      if not FileExists(FileName) then
        Exit;
      Ex := ExtractFileExt(FileName);
      if Ex = '' then
      begin
        FNT := ExtractFileName(FileName) + '.tree';
        FNR := ExtractFileName(FileName) + '.ini';
      end
      else
      begin
        FNT := ExtractFileName(FileName);
        FNT := Copy(FNT, 0, pos('.', FNT) - 1);
        FNR := FNT + '.ini';
        FNT := FNT + '.tree';
      end;
      FNT := ExtractFilePath(FileName) + FNT;
      FNR := ExtractFilePath(FileName) + FNR;
      if (not FileExists(FNT)) or (not FileExists(FNR)) then
      begin
        ANode := Items.Add(nil, RootName);
        ANode.StateIndex := 0;
        Self.MRPSaveToFile(FileName);
      end
      else
      begin
        MRPLoadFromFile(FileName);
      end;
    end;
     
    procedure TGRTreeView.MRPLoadFromStream(Stream: TStream);
    var
      List: TStringList;
      ANode, NextNode: TTreeNode;
      ALevel, i, AStateIndex: Integer;
      CurrStr, Buff: string;
    begin
      Items.Clear;
      List := TStringList.Create;
      Items.BeginUpdate;
      try
        try
          List.Clear;
          List.LoadFromStream(Stream);
          ANode := nil;
          for i := 0 to List.Count - 1 do
          begin
            CurrStr := GetBufStart(PChar(List[i]), ALevel);
            AStateIndex := -1;
            if pos(fSeparator, CurrStr) > 0 then
            begin
              Buff := Copy(CurrStr, pos(fSeparator, CurrStr) + 1, length(CurrStr) -
                pos(fSeparator, CurrStr));
              if Buff <> '' then
                AStateIndex := StrToInt(Buff);
              // Delete(CurrStr,pos(CurrStr,fSeparator),length(CurrStr)-pos(CurrStr,fSeparator)-1);
              buff := Copy(CurrStr, 0, pos(fSeparator, CurrStr) - 1);
              CurrStr := Buff;
            end;
            if ANode = nil then
            begin
              ANode := Items.AddChild(nil, CurrStr);
              if AStateIndex <> -1 then
                ANode.StateIndex := AStateIndex;
            end
            else if ANode.Level = ALevel then
            begin
              ANode := Items.AddChild(ANode.Parent, CurrStr);
              if AStateIndex <> -1 then
                ANode.StateIndex := AStateIndex;
            end
            else if ANode.Level = (ALevel - 1) then
            begin
              ANode := Items.AddChild(ANode, CurrStr);
              if AStateIndex <> -1 then
                ANode.StateIndex := AStateIndex;
            end
            else if ANode.Level > ALevel then
            begin
              NextNode := ANode.Parent;
              while NextNode.Level > ALevel do
                NextNode := NextNode.Parent;
              ANode := Items.AddChild(NextNode.Parent, CurrStr);
              if AStateIndex <> -1 then
                ANode.StateIndex := AStateIndex;
            end;
            // else TreeViewErrorFmt(sInvalidLevelEx, [ALevel, CurrStr]);
          end;
        finally
          Items.EndUpdate;
          List.Free;
        end;
      except
        Items.Owner.Invalidate; // force repaint on exception see VCL
        raise;
      end;
      if Items.Count > 0 then
        Items.Item[0].Expand(false);
    end;
     
    procedure TGRTreeView.MRPSaveToFile(const FileName: string);
    var
      Stream: TStream;
      FNT, FNR, Ex: string;
    begin
      Ex := ExtractFileExt(FileName);
      if Ex = '' then
      begin
        FNT := ExtractFileName(FileName) + '.tree';
        FNR := ExtractFileName(FileName) + '.ini';
      end
      else
      begin
        FNT := ExtractFileName(FileName);
        FNT := Copy(FNT, 0, pos('.', FNT) - 1);
        FNR := FNT + '.ini';
        FNT := FNT + '.tree';
      end;
      FNT := ExtractFilePath(FileName) + FNT;
      FNR := ExtractFilePath(FileName) + FNR;
      Stream := TFileStream.Create(FNT, fmCreate);
      try
        flock := True;
        MRPSaveToStream(Stream);
      finally
        Stream.Free;
        flock := false;
      end;
    end;
     
    procedure TGRTreeView.MRPSaveToStream(Stream: TStream);
    const
      TabChar = #9;
      EndOfLine = #13#10;
    var
    i: Integer;
      ANode: TTreeNode;
      NodeStr: string;
    begin
      if Items.Count > 0 then
      begin
        ANode := Items.Item[0];
        while ANode <> nil do
        begin
          NodeStr := '';
          for i := 0 to ANode.Level - 1 do
            NodeStr := NodeStr + TabChar;
          NodeStr := NodeStr + ANode.Text + fSeparator + IntToStr(ANode.StateIndex)
            + EndOfLine;
          Stream.Write(Pointer(NodeStr)^, Length(NodeStr));
          ANode := ANode.GetNext;
        end;
      end;
    end;
     
    function TGRTreeView.MRRefresh: boolean;
    var
      i: integer;
      ANode, NextNode: TTreeNode;
      MGroup: TMRGroup;
    begin
      if (fDataSource.DataSet = nil) or (KeyField = '') or (MasterField = '') or
        (NameField = '') then
      begin
        Result := false;
        Exit;
      end;
      if not fDataSource.DataSet.Active then
        fDataSource.DataSet.Open
      else
      begin
        fDataSource.DataSet.Close;
        fDataSource.DataSet.Open;
      end;
     
      fDataSource.DataSet.DisableControls;
      MGroup := TMRGroup.Create;
      MGroup.Clear;
      try
        while not fDataSource.DataSet.Eof do
        begin
          MGroup.Add(DataSource.DataSet.FieldByName(KeyField).AsInteger,
            DataSource.DataSet.FieldByName(MasterField).AsInteger,
            DataSource.DataSet.FieldByName(NameField).AsString);
          fDataSource.DataSet.Next;
        end;
        items.Clear;
        Items.BeginUpdate;
        fLock := True;
        ANode := nil;
        for i := 0 to MGroup.Count - 1 do
        begin
          if ANode = nil then
          begin
            ANode := Items.AddChild(nil, MGroup.Items[i].MainName);
            ANode.StateIndex := MGroup.items[i].ID;
          end
          else if ANode.Level = (MGroup.items[i].Level) then
          begin
            ANode := items.AddChild(ANode.Parent, MGroup.items[i].MainName);
            ANode.StateIndex := MGroup.items[i].ID;
          end
          else if ANode.Level = (MGroup.items[i].Level - 1) then
          begin
            ANode := Items.AddChild(ANode, MGroup.items[i].MainName);
            ANode.StateIndex := MGroup.items[i].ID;
          end
          else if ANode.Level > MGroup.items[i].Level then
          begin
            NextNode := ANode.Parent;
            while NextNode.Level > MGroup.items[i].Level do
              NextNode := NextNode.Parent;
            ANode := Items.AddChild(NextNode.Parent, MGroup.items[i].MainName);
            ANode.StateIndex := MGroup.items[i].ID;
          end;
          { else if ANode.Level > MGroup.items[i].Level then
                  begin
                    NextNode := ANode.Parent;
                    while NextNode.Level > MGroup.items[i].Level do
                      NextNode := NextNode.Parent;
                    ANode := Items.AddChild(NextNode.Parent, MGroup.items[i].MainName);
                    ANode.StateIndex:=MGroup.items[i].ID;
                  end;}
        end;
      finally
        fDataSource.DataSet.First;
        fDataSource.DataSet.EnableControls;
        //ShowMessage('Tree count='+IntToStr(Items.Count)+' MGroup count='+IntToStr(MGroup.Count));
        MGroup.Free;
        fLock := false;
      end;
      Items.EndUpdate;
      if Items.Count > 0 then
        Items.Item[0].Expand(false);
      Result := True;
    end;
     
    procedure TGRTreeView.SetDataSource(value: TDataSource);
    begin
      fDataSource.DataSource := value;
    end;
     
    function TGRTreeView.MRGetIndexByMasterID(MasterID: integer): integer;
    var
      i: integer;
    begin
      if Items.Count = 0 then
      begin
        Result := -1;
        exit;
      end;
      for i := 0 to Items.Count - 1 do
      begin
        if Items.Item[i].StateIndex = MasterID then
        begin
          Result := i;
          Exit;
        end;
      end;
      Result := -1;
    end;
     
    function TGRTreeView.GetKeyField: string;
    begin
      Result := fFeyField.FieldName;
    end;
     
    function TGRTreeView.GetMasterKeyField: string;
    begin
      Result := fMasterFeyField.FieldName;
    end;
     
    function TGRTreeView.GetNameField: string;
    begin
      Result := fNameField.FieldName;
    end;
     
    procedure TGRTreeView.SetKeyField(value: string);
    begin
      fFeyField.FieldName := value;
    end;
     
    procedure TGRTreeView.SetMasterKeyField(value: string);
    begin
      fMasterFeyField.FieldName := value;
    end;
     
    procedure TGRTreeView.SetNameField(value: string);
    begin
      fNameField.FieldName := value;
    end;
     
    procedure TGRTreeView.SetSeparator(value: char);
    begin
      fSeparator := value;
    end;
     
    procedure TGRTreeView.GetImageIndex(Node: TTreeNode);
    begin
      if fLock then
        Exit;
      inherited;
      if Node.getFirstChild <> nil then
      begin
        Node.ImageIndex := 0;
        Node.SelectedIndex := 1;
      end
      else
      begin
        Node.ImageIndex := 2;
        Node.SelectedIndex := 3;
      end;
    end;
     
    function TGRTreeView.MRGetIndexByMasterIDRecurse(
      MasterID: integer): integer;
    var
      i: integer;
    begin
      if Items.Count = 0 then
      begin
        Result := -1;
        exit;
      end;
      for i := Items.Count - 1 downto 0 do
      begin
        if Items.Item[i].StateIndex = MasterID then
        begin
          Result := i;
          Exit;
        end;
      end;
      Result := -1;
    end;
     
    function TGRTreeView.MRSearchByText(AText: string; Next: Boolean = True;
      UseSearchIndex: Boolean = false): integer;
    var
      i, iStart, iEnd: integer;
      sel: TList;
      f: boolean;
    begin
      if Items.Count = 0 then
      begin
        Result := -1;
        fSearchIndex := -1;
        Exit;
      end;
      if Next then
      begin
        if (UseSearchIndex) and (fSearchIndex <> -1) then
          iStart := fSearchIndex + 1
        else
          iStart := 0;
        iEnd := Items.Count - 1;
      end
      else
      begin
        if (UseSearchIndex) and (fSearchIndex <> -1) then
          iStart := fSearchIndex - 1
        else
          iStart := Items.Count - 1;
        iEnd := 0;
      end;
      i := iStart;
      f := true;
      repeat
        if pos(AnsiUpperCase(AText), AnsiUpperCase(Items.Item[i].Text)) > 0 then
        begin
          Result := i;
          fSearchIndex := i;
          sel := TList.Create;
          sel.Add(Items.Item[i]);
          Select(Sel);
          sel.Free;
          Exit;
        end;
        if Next then
        begin
          inc(i);
          if i > iEnd then
            f := false;
        end
        else
        begin
          dec(i);
          if i < iEnd then
            f := false;
        end;
      until f <> true;
      Result := -1;
      fSearchIndex := -1;
    end;
     
    { TMRGroup }
     
    procedure TMRGroup.Add(AID, AMasterID: integer; AMainName: string);
    var
      idx: integer;
    begin
      inc(fCount);
      SetLength(items, fCount);
      items[fCount - 1].ID := AID;
      items[fCount - 1].MasterID := AMasterID;
      items[fCount - 1].MainName := AMainName;
      idx := GetIndexByMasterID(AMasterID);
      if idx = -1 then
      begin
        items[idx].Level := 0;
      end
      else
      begin
        items[fCount - 1].Level := items[idx].Level + 1;
      end;
    end;
     
    procedure TMRGroup.Clear;
    begin
      items := nil;
      fCount := 0;
    end;
     
    constructor TMRGroup.Create;
    begin
      inherited;
      fCount := 0;
    end;
     
    destructor TMRGroup.destroy;
    begin
      items := nil;
      inherited;
    end;
     
    function TMRGroup.GetIndexByMasterID(AMasterID: integer): integer;
    var
      i: integer;
    begin
      if (fCount = 0) then
      begin
        Result := -1;
        Exit;
      end;
      for i := 0 to fCount - 1 do
      begin
        if items[i].ID = AMasterID then
        begin
          Result := i;
          Exit;
        end;
      end;
      Result := -1;
    end;
     
    procedure TMRGroup.SetCount(value: integer);
    begin
      fCount := value;
    end;
     
    end.
