---
Title: Дерево на базе MS SQL
Author: Пенов Сергей, spenov@narod.ru
Date: 06.09.2002
---


Дерево на базе MS SQL
=====================

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Дерево на базе MsSQL 7/2000 и DELPHI6 (BDE,ADO)
     
    Узел дерева описывается через idParent,idPrior,idNext,idFirstChild.
    В следствии такого подхода в многопользовательской среде достигается
    минимальное количество блокировок при изменении узлов дерева.
    Все функции реализованы в хранимых процедурах. Компанент, порожденный
    от TTreeView, является интерфейсом для работы с деревом в клиенте.
    Тексты хранимых процедур на странице
    http://spenov.narod.ru/DBTree/DBTreeView.html
     
    Зависимости: Classes,ComCtrls,CommCtrl,DB,DBTables,Controls,Messages,ADODB
    Автор:       Пенов Сергей, spenov@narod.ru, ICQ:122597033, Москва
    Copyright:   http://spenov.narod.ru/DBTree/DBTreeView.html
    Дата:        6 сентября 2002 г.
    ***************************************************** }
     
    //Тексты хранимых процедур на странице
    // http://spenov.narod.ru/DBTree/DBTreeView.html
    unit Un_TADODBTreeView;
     
    interface
     
    uses
      Classes, ComCtrls, CommCtrl, DB, DBTables, Controls, Messages, ADODB;
     
    type
      TADODBTreeNode = class(TTreeNode)
      private
        FIdNode: Integer;
      public
        property idNode: Integer read FIdNode;
      end;
     
      TADODBTreeView = class(TCustomTreeView)
      private
        FRootID: string;
        FOnEdited: TTVEditedEvent;
        FLDblCklick: Boolean; //показывает, что выполняется DblClick
        FDoExpColOnDblClick: Boolean;
        //Если True, то при DblClick не будет раскрываться/закрываться Node.
        FReopenOnExpand: Boolean;
        FConnection: TADOConnection;
        FRecordset: _Recordset;
        FIdTree: Integer;
        procedure SetRootID(Value: string);
        procedure SetConnection(Value: TADOConnection);
        procedure SetIdTree(const Value: Integer);
        procedure AddChildren(AParent: TTreeNode);
        procedure WMLButtonDblClk(var Message: TWMLButtonDblClk); message
          WM_LBUTTONDBLCLK;
        function GetSelectedID: Integer;
        procedure SetSelectedID(const Value: Integer);
      protected
        procedure Loaded; override;
        function CreateNode: TTreeNode; override;
        function CanExpand(Node: TTreeNode): Boolean; override;
        function CanCollapse(Node: TTreeNode): Boolean; override;
        procedure DoEdited(Sender: TObject; Node: TTreeNode; var S: string);
        procedure Notification(AComponent: TComponent; Operation: TOperation);
          override;
      public
        constructor Create(AOwner: TComponent); override;
        procedure dbLoadFirstLevel;
        function dbAddChild(AParent: TTreeNode; AText: string; idNode: Integer = 0):
          TTreeNode;
        procedure dbDeleteNode(Node: TTreeNode; ReQueryFromDB: Boolean = False);
        procedure dbMoveNode(DNode, SNode: TTreeNode; AsChild: Boolean = False;
          ReQueryFromDB: Boolean = False);
        property Items;
        property SelectedID: Integer read GetSelectedID write SetSelectedID;
      published
        property RootID: string read FRootID write SetRootID;
        property idDBTree: Integer read FIdTree write SetIdTree;
        property Connection: TADOConnection read FConnection write SetConnection;
        property DoExpColOnDblClick: Boolean read FDoExpColOnDblClick write
          FDoExpColOnDblClick default True;
        property OnEdited: TTVEditedEvent read FOnEdited write FOnEdited;
      published //Из TCustomTreeView
        property Align;
        property Anchors;
        property BevelEdges;
        property BevelInner;
        property BevelOuter;
        property BevelKind default bkNone;
        property BevelWidth;
        property BiDiMode;
        property BorderStyle;
        property BorderWidth;
        property ChangeDelay;
        property Color;
        property Ctl3D;
        property Constraints;
        property DragKind;
        property DragCursor;
        property DragMode;
        property Enabled;
        property Font;
        property HideSelection;
        property HotTrack;
        property Images;
        property PopupMenu;
        property StateImages;
        property ReadOnly;
        property RightClickSelect;
        property RowSelect;
        property ShowButtons;
        property ShowHint;
        property ShowLines;
        property ShowRoot;
        property OnAddition;
        property OnAdvancedCustomDraw;
        property OnAdvancedCustomDrawItem;
        property OnChange;
        property OnChanging;
        property OnClick;
        property OnCollapsed;
        property OnCollapsing;
        property OnCompare;
        property OnContextPopup;
        property OnCreateNodeClass;
        property OnCustomDraw;
        property OnCustomDrawItem;
        property OnDblClick;
        property OnDeletion;
        property OnDragDrop;
        property OnDragOver;
        property OnEditing;
        property OnEndDock;
        property OnEndDrag;
        property OnEnter;
        property OnExit;
        property OnExpanding;
        property OnExpanded;
        property OnGetImageIndex;
        property OnGetSelectedIndex;
        property OnKeyDown;
        property OnKeyPress;
        property OnKeyUp;
        property OnMouseDown;
        property OnMouseMove;
        property OnMouseUp;
        property OnStartDock;
        property OnStartDrag;
        //property Visible;
        { Items must be published after OnGetImageIndex and OnGetSelectedIndex }
        //property Items;
      end;
     
    procedure Register;
     
    implementation
     
    uses
      SysUtils, Variants, Forms, DBLogDlg;
     
    const
      SQLLoadLevel: string = 'EXEC upDBTreeGetChildren @idDBTree=%d,@idParent=%s';
      SQLAddChild: string =
      'EXEC upDBTreeAddNode @idDBTree=%d,@idParent=%s,@idPrior=%s,@idNext=%s,@Text=''%s'',@idNode=%s';
      SQLDeleteNode: string = 'EXEC upDBTreeDeleteNode @idDBTree=%d,@idNode=%d';
      SQLMoveNode: string =
      'EXEC upDBTreeMoveNode @idDBTree=%d,@idDNode=%d,@idSNode=%d,@AsChild=%d';
      SQLRenameNode: string =
      'EXEC upDBTreeRenameNode @idDBTree=%d,@idNode=%d,@NewText=''%s''';
      SQLGetFullPath: string = 'EXEC upDBTreeGetFullPath @idDBTree=%d,@idNode=%d';
     
    procedure Register;
    begin
      RegisterComponents('Penov', [TADODBTreeView]);
    end;
     
    { TADODBTreeView }
     
    procedure TADODBTreeView.AddChildren(AParent: TTreeNode);
    var
      NewNode: TADODBTreeNode;
      TheCursor: TCursor;
      Buf: TTVExpandedEvent;
    begin
      TheCursor := Screen.Cursor;
      Screen.Cursor := crHourGlass;
      try
        Buf := OnAddition;
        OnAddition := nil;
        try
          with FRecordset do
          begin
            if RecordCount > 0 then
              while not Eof do
              begin
                NewNode := Items.AddChild(AParent, Fields['Text'].Value) as
                  TADODBTreeNode;
                with NewNode do
                begin
                  HasChildren := not VarIsNull(Fields['idFirstChild'].Value);
                  FIdNode := Fields['idNode'].Value;
                end;
                if Assigned(Buf) then
                  Buf(Self, NewNode);
                MoveNext;
              end;
          end;
        finally
          OnAddition := Buf;
        end;
      finally
        Screen.Cursor := TheCursor;
      end;
    end;
     
    function TADODBTreeView.CanCollapse(Node: TTreeNode): Boolean;
    begin
      if FLDblCklick and not FDoExpColOnDblClick then
        Result := False
      else
      begin
        Result := inherited CanCollapse(Node);
        //Удаление вложенных узлов
        if Result and FReopenOnExpand and (Node is TADODBTreeNode) and
          Node.HasChildren then
        begin
          Items.BeginUpdate;
          try
            Node.DeleteChildren;
            Items.AddChild(Node, 'HasItems');
          finally
            Items.EndUpdate;
          end;
        end;
      end;
    end;
     
    function TADODBTreeView.CanExpand(Node: TTreeNode): Boolean;
    var
      crBuf: TCursor;
    begin
      if FLDblCklick and not FDoExpColOnDblClick then
        Result := False
      else
      begin
        //Загрузка вложенных узлов
        if FReopenOnExpand and (Node is TADODBTreeNode) and Node.HasChildren then
        begin
          Items.BeginUpdate;
          try
            Node.DeleteChildren;
            if (FIdTree <> 0) and Assigned(FConnection) then
            begin
              crBuf := Screen.Cursor;
              Screen.Cursor := crSQLWait;
              try
                FRecordset := FConnection.Execute(Format(SQLLoadLevel, [FIdTree,
                  IntToStr((Node as TADODBTreeNode).idNode)]));
              finally
                Screen.Cursor := crBuf;
              end;
              try
                AddChildren(Node);
              finally
                FRecordset := nil;
              end;
            end;
          finally
            Items.EndUpdate;
          end;
        end;
        Result := inherited CanExpand(Node);
      end;
    end;
     
    constructor TADODBTreeView.Create(AOwner: TComponent);
    begin
      FRootID := 'NULL';
      FReopenOnExpand := True;
      FDoExpColOnDblClick := True;
      inherited;
      inherited OnEdited := DoEdited;
    end;
     
    function TADODBTreeView.CreateNode: TTreeNode;
    begin
      if Assigned(OnCreateNodeClass) then
        Result := inherited CreateNode
      else
        Result := TADODBTreeNode.Create(Items);
    end;
     
    function TADODBTreeView.dbAddChild(AParent: TTreeNode; AText: string; idNode:
      Integer = 0): TTreeNode;
    var
      NewNode: TTreeNode;
      Buf: TTVExpandedEvent;
      crBuf: TCursor;
     
      function GetIdParent(Node: TTreeNode): string;
      begin
        if Assigned(Node.Parent) then
          Result := IntToStr((Node.Parent as TADODBTreeNode).idNode)
        else
          Result := FRootID;
      end;
      function GetIdPrior(Node: TTreeNode): string;
      var
        Prior: TTreeNode;
      begin
        Prior := Node.getPrevSibling;
        if Assigned(Prior) then
          Result := IntToStr((Prior as TADODBTreeNode).idNode)
        else
          Result := 'NULL';
      end;
      function GetIdNext(Node: TTreeNode): string;
      var
        Next: TTreeNode;
      begin
        Next := Node.getNextSibling;
        if Assigned(Next) then
          Result := IntToStr((Next as TADODBTreeNode).idNode)
        else
          Result := 'NULL';
      end;
      function GetIdNode(idNode: Integer): string;
      begin
        if idNode <> 0 then
          Result := IntToStr(idNode)
        else
          Result := 'NULL';
      end;
     
    begin
      Result := nil;
      Buf := OnAddition;
      OnAddition := nil;
      try
        Items.BeginUpdate;
        try
          if Assigned(AParent) and not AParent.Expanded then
            AParent.Expand(False);
          NewNode := Items.AddChild(AParent, AText);
          if (FIdTree <> 0) and Assigned(FConnection) then
          begin
            crBuf := Screen.Cursor;
            Screen.Cursor := crSQLWait;
            try
              FRecordset := FConnection.Execute(Format(SQLAddChild, [FIdTree,
                GetIdParent(NewNode), GetIdPrior(NewNode), GetIdNext(NewNode),
                  AText,
                  GetIdNode(idNode)]));
            finally
              Screen.Cursor := crBuf;
            end;
            try
              try
                if FRecordset.RecordCount > 0 then
                begin
                  (NewNode as TADODBTreeNode).FIdNode :=
                    FRecordset.Fields['NewId'].Value;
                  //Выделяем добавленный узел
                  FReopenOnExpand := False;
                  try
                    Selected := NewNode;
                  finally
                    FReopenOnExpand := True;
                  end;
                end
                else
                  raise
                    Exception.Create('TADODBTreeView.dbAddChild:Не получен идентификатор нового узла.');
              except
                NewNode.Delete;
                raise;
              end;
            finally
              FRecordset := nil;
            end;
          end;
        finally
          Items.EndUpdate;
        end;
        Result := NewNode;
        if Assigned(Buf) then
          Buf(Self, NewNode);
      finally
        OnAddition := Buf;
      end;
    end;
     
    procedure TADODBTreeView.dbDeleteNode(Node: TTreeNode; ReQueryFromDB: Boolean =
      False);
    var
      AParent: TTreeNode;
    begin
      if Node.HasChildren then
        raise
          Exception.Create('TADODBTreeView.dbDeleteNode:Этот узел удалить нельзя,т.к. есть вложеннные узлы.');
      FConnection.Execute(Format(SQLDeleteNode, [FIdTree, (Node as
          TADODBTreeNode).idNode]));
      if ReQueryFromDB then
      begin
        Items.BeginUpdate;
        try
          AParent := Node.Parent;
          if Assigned(AParent) then
          begin
            AParent.Collapse(False);
            AParent.Expand(False);
          end
          else
            dbLoadFirstLevel;
        finally
          Items.EndUpdate;
        end;
      end
      else
        Node.Delete;
    end;
     
    procedure TADODBTreeView.dbMoveNode(DNode, SNode: TTreeNode; AsChild: Boolean =
      False; ReQueryFromDB: Boolean = False);
    const
      BoolToInt: array[Boolean] of Integer = (0, 1);
    var
      DParent, SParent, Node: TTreeNode;
      TheNodeId: Integer;
    begin
      if not Assigned(DNode) or not Assigned(SNode) or (DNode = SNode) then
        Exit;
      if DNode.HasAsParent(SNode) then
        raise
          Exception.Create('TADODBTreeView.dbMoveNode:Узел не может быть перемещен.')
      else
      begin
        FConnection.Execute(Format(SQLMoveNode, [FIdTree, (DNode as
            TADODBTreeNode).idNode, (SNode as TADODBTreeNode).idNode,
          BoolToInt[AsChild]]));
        Items.BeginUpdate;
        try
          if ReQueryFromDB then
          begin
            TheNodeId := (SNode as TADODBTreeNode).idNode;
            DParent := DNode.Parent;
            SParent := SNode.Parent;
            if Assigned(DParent) and Assigned(SParent) then
            begin
              DParent.Collapse(False);
              DParent.Expand(False);
              if (DParent <> SParent) and not SParent.HasAsParent(DParent) then
              begin
                DParent.Collapse(False);
                DParent.Expand(False);
              end;
            end
            else
              dbLoadFirstLevel;
            if Assigned(DParent) then
              Node := DParent.getFirstChild
            else
              Node := Items.GetFirstNode;
            while Assigned(Node) and ((Node as TADODBTreeNode).idNode <> TheNodeId)
              do
              Node := Node.getNextSibling;
            if Assigned(Node) then
              Selected := Node;
          end
          else
          try
            if AsChild then
            begin
              if DNode.Expanded then
              begin
                FReopenOnExpand := False;
                SNode.MoveTo(DNode, naAddChild);
              end
              else
              begin
                Items.AddChildFirst(DNode, 'HasChildren');
                //Надо добавить узел,что бы DNode открылся.
                if CanExpand(DNode) then
                begin
                  SNode.Delete;
                  FReopenOnExpand := False;
                  DNode.GetLastChild.Selected := True;
                end;
              end;
            end
            else
            begin
              FReopenOnExpand := False;
              SNode.MoveTo(DNode, naInsert);
            end;
          finally
            FReopenOnExpand := True;
          end;
        finally
          Items.EndUpdate;
        end;
      end;
    end;
     
    procedure TADODBTreeView.Loaded;
    begin
      inherited;
      if not (csDesigning in ComponentState) then
        dbLoadFirstLevel;
    end;
     
    procedure TADODBTreeView.dbLoadFirstLevel;
    var
      crBuf: TCursor;
    begin
      Items.Clear;
      if not (csDesigning in Self.ComponentState) and not (csLoading in
        Self.ComponentState) and (FIdTree <> 0) and Assigned(FConnection) then
      begin
        crBuf := Screen.Cursor;
        Screen.Cursor := crSQLWait;
        try
          FRecordset := FConnection.Execute(Format(SQLLoadLevel, [FIdTree,
            FRootID]));
        finally
          Screen.Cursor := crBuf;
        end;
        try
          AddChildren(nil);
        finally
          FRecordset := nil;
        end;
      end;
    end;
     
    procedure TADODBTreeView.SetConnection(Value: TADOConnection);
    begin
      if Assigned(FConnection) and (FConnection.Owner <> Self.Owner) then
        FConnection.RemoveFreeNotification(Self);
      FConnection := Value;
      if Assigned(Value) then
      begin
        if Value.Owner <> Self.Owner then
          Value.FreeNotification(Self);
        dbLoadFirstLevel;
      end
      else
        Items.Clear;
    end;
     
    procedure TADODBTreeView.SetIdTree(const Value: Integer);
    begin
      FIdTree := Value;
      dbLoadFirstLevel;
    end;
     
    procedure TADODBTreeView.WMLButtonDblClk(var Message: TWMLButtonDblClk);
    begin
      FLDblCklick := True;
      inherited;
      FLDblCklick := False;
    end;
     
    function TADODBTreeView.GetSelectedID: Integer;
    begin
      if Assigned(Selected) and (Selected is TADODBTreeNode) then
        Result := (Selected as TADODBTreeNode).idNode
      else
        Result := 0;
    end;
     
    procedure TADODBTreeView.SetSelectedID(const Value: Integer);
    var
      TheNode: TTreeNode;
      ThePath: array of Integer;
      I: Integer;
      crBuf: TCursor;
    begin
      if (Items.Count > 0) and (Items[0] is TADODBTreeNode) then
      begin
        Items.BeginUpdate;
        try
          try
            TheNode := Items[0];
            crBuf := Screen.Cursor;
            Screen.Cursor := crSQLWait;
            try
              FRecordset := FConnection.Execute(Format(SQLGetFullPath, [FIdTree,
                Value]));
            finally
              Screen.Cursor := crBuf;
            end;
            try
              if FRecordset.RecordCount <= 0 then
                raise
                  Exception.Create('TADODBTreeView.SetSelectedID:Не получен путь к узлу ' + IntToStr(Value));
              SetLength(ThePath, FRecordset.RecordCount);
              I := 0;
              while not FRecordset.Eof do
              begin
                ThePath[I] := FRecordset.Fields['idNode'].Value;
                Inc(I);
                FRecordset.MoveNext;
              end;
            finally
              FRecordset := nil;
            end;
            for I := 0 to High(ThePath) do
            begin
              while Assigned(TheNode) and ((TheNode as TADODBTreeNode).idNode <>
                ThePath[I]) do
                TheNode := TheNode.getNextSibling;
              if not Assigned(TheNode) then
                raise Exception.Create('TADODBTreeView.SetSelectedID:Не найден узел '
                  + IntToStr(ThePath[I]));
              if I < High(ThePath) then
              begin
                TheNode.Expand(False);
                TheNode := TheNode.getFirstChild;
              end;
            end;
            if not Assigned(TheNode) then
              raise
                Exception.Create('TADODBTreeView.SetSelectedID:Не найден узел.');
            Selected := TheNode;
          finally
            ThePath := nil;
          end;
        finally
          Items.EndUpdate;
        end;
      end;
    end;
     
    { TADODBTreeNode }
     
    procedure TADODBTreeView.DoEdited(Sender: TObject; Node: TTreeNode; var S:
      string);
    var
      crBuf: TCursor;
    begin
      if Assigned(FOnEdited) then
        FOnEdited(Sender, Node, S);
      if (Node is TADODBTreeNode) and (Node.Text <> S) then
      try //Сохраняем изменения в базе
        crBuf := Screen.Cursor;
        Screen.Cursor := crSQLWait;
        try
          FRecordset := FConnection.Execute(Format(SQLRenameNode, [FIdTree, (Node as
              TADODBTreeNode).idNode, S]));
        finally
          Screen.Cursor := crBuf;
        end;
        try
          if FRecordset.RecordCount = 0 then
            raise
              Exception.Create('TADODBTreeView.DoEdited:Не получен результат переименования.');
          S := FRecordset.Fields['NewText'].Value;
        finally
          FRecordset := nil;
        end;
      except
        S := Node.Text;
        raise;
      end;
    end;
     
    procedure TADODBTreeView.SetRootID(Value: string);
    var
      I: Integer;
    begin
      if (UpperCase(Value) = 'NULL') or (Value = '') then
        FRootID := 'NULL'
      else
      begin
        for I := 1 to Length(Value) do
          if not (Value[I] in ['0'..'9']) then
            raise Exception.Create('"' + Value + '" - is not integer or NULL');
        FRootID := Value;
      end;
      dbLoadFirstLevel;
    end;
     
    procedure TADODBTreeView.Notification(AComponent: TComponent; Operation:
      TOperation);
    begin
      if (Operation = opRemove) and (AComponent = FConnection) then
        SetConnection(nil);
    end;
     
    { TADODBTreeNode }
     
    end.
