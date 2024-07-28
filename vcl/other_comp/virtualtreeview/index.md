---
Title: VirtualTreeView, FAQ по компоненту
Author: Smike and Jack128
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


VirtualTreeView, FAQ по компоненту
==================================

**Что такое VirtualTreeView?**

Это компонент, заменяющий стандартные TTreeView, TStringGrid, TListView,
отличается высокой скоростью и удобством работы, а также имеет много
расширений.

Найти сам компонент можно на сайте:
http://delphi-gems.com/VirtualTreeview/

Существует хорошее расширение компонента для работы отображения файлов,
аналогично Windows Explorer: https://www.mustangpeak.net/

**Основы работы с компонентом**

Рассмотрим пример простейшего приложения с использованием этого
компонента, где он будет использоваться только для отображения данных.
Думаю, он будет полезен тем, кто начинает работу с этим компонентом.

Если компоненты правильно установлены в среде Дельфи, то для начала
нужно найти в палитре компонентов найти вкладку VirtualControls, а в ней
компонент VirtualStringTree и положить его на форму. Назовем его VST.

Компонент не хранит названий элементов дерева. Но зато каждому элементу
можно сопоставить указатель на любую структуру данных, где можно хранить
название элемента и не только. В связи с этим создадим простую запись,
где будет храниться название элемента и его порядковый номер:

    type
      PVSTRecord = ^TVSTRecord;
      TVSTRecord = record
        ElementName: string;
        ElementNumber: Integer;
      end;

Теперь укажем компоненту, с каким размером данных он будет работать:

    procedure TForm1.FormCreate(Sender: TObject);
    begin
      VST.NodeDataSize := SizeOf(TVSTRecord);
    end;

И, наконец, займемся самым главным - заполним дерево:

    procedure TForm1.Button1Click(Sender: TObject);
    var
      RootNode, ChildNode: PVirtualNode;
      I: Integer;
      Data: PVSTRecord;
    begin
      RootNode := VST.AddChild(VST.RootNode);
      if not (vsInitialized in RootNode.States) then
        VST.ReinitNode(RootNode, False);
      Data := VST.GetNodeData(RootNode);
      Data.ElementName := 'Корневой элемент';
      Data.ElementNumber := 0;
      for I := 1 to 10 do
      begin
        ChildNode := VST.AddChild(RootNode);
        if not (vsInitialized in ChildNode.States) then
           VST.ReinitNode(ChildNode, False);
        Data := VST.GetNodeData(ChildNode);
        Data.ElementName := 'Дочерний элемент';
        Data.ElementNumber := I;
      end;
    end;

Естественно названия элементов отображаться не будут. Для отображения
названий элементов нужно создать обработчик события OnGetText:

    procedure TForm1.VSTGetText(Sender: TBaseVirtualTree; Node: PVirtualNode;
      Column: TColumnIndex; TextType: TVSTTextType; var CellText: WideString);
    var
      Data: PVSTRecord;
    begin
      Data := Sender.GetNodeData(Node);
      if Assigned(Data) then
        CellText := Data.ElementName;
    end;

А теперь немного расширим функциональность нашего приложения: добавим
возможность отображения порядковых номеров элементов, которые хранятся в
TVSTRecord.ElementNumber:

    procedure TForm1.VSTGetText(Sender: TBaseVirtualTree; Node: PVirtualNode;
      Column: TColumnIndex; TextType: TVSTTextType; var CellText: WideString);
    var
      Data: PVSTRecord;
    begin
      Data := Sender.GetNodeData(Node);
      if Assigned(Data) then
        CellText := Data.ElementName + #32 + IntToStr(Data.ElementNumber);
    end;

И в завершение необходимо создать обработчик события OnFreeNode, где
должна освобождаться память, выделенная под TVSTRecord или любые другие
данные, связанные с деревом:

    procedure TForm1.VSTFreeNode(Sender: TBaseVirtualTree; Node: PVirtualNode);
    var
      Data: PVSTRecord;
    begin
      Data := Sender.GetNodeData(Node);
      if Assigned(Data) then
        Finalize(Data^);
    end;

Освобождение элементов особенно актуально, если в дереве будут
динамически создаваться и удаляться элементы.

**Создание многострочного дерева**

Одним из преимуществ компонента является возможность создавать деревья с
многострочными элементами. Теперь рассмотрим, как можно создать такое
дерево. За основу возьмем пример из поста #2. Но для того чтобы
получить многострочные названия элементов немного подправим процедуру
занесения данных в дерево:

    procedure TForm1.Button1Click(Sender: TObject);
    var
      RootNode, ChildNode: PVirtualNode;
      I: Integer;
      Data: PVSTRecord;
    begin
      RootNode := VST.AddChild(VST.RootNode);
      if not (vsInitialized in RootNode.States) then
        VST.ReinitNode(RootNode, False);
      Data := VST.GetNodeData(RootNode);
      Data.ElementName := 'Корневой элемент с очень, очень, очень, очень, очень, очень, очень длинным названием';
      Data.ElementNumber := 0;
      for I := 1 to 10 do
      begin
        ChildNode := VST.AddChild(RootNode);
        if not (vsInitialized in ChildNode.States) then
          VST.ReinitNode(ChildNode, False);
     
        Data := VST.GetNodeData(ChildNode);
        Data.ElementName := 'Дочерний элемент с очень, очень, очень, очень, очень, очень, очень длинным названием';
        Data.ElementNumber := I;
      end;
    end;

Следующим шагом нужно добавить хотя бы одну колонку в дерево, причем
желательно выставить опцию hoAutoResize в True в VST.Header.Options.

И наконец создаем обработчики двух событий - OnInitNode и OnMeasureItem:

    procedure TForm1.VSTInitNode(Sender: TBaseVirtualTree; ParentNode,
      Node: PVirtualNode; var InitialStates: TVirtualNodeInitStates);
    begin
      Include(InitialStates, ivsMultiline);
    end;
     
    procedure TForm1.VSTMeasureItem(Sender: TBaseVirtualTree;
      TargetCanvas: TCanvas; Node: PVirtualNode; var NodeHeight: Integer);
    begin
      if Sender.MultiLine[Node] then
      begin
        TargetCanvas.Font := Sender.Font;
        NodeHeight := VST.ComputeNodeHeight(TargetCanvas, Node, 0) + 10;
      end;
    end;

Что приведет к отображению дерева с многострочными элементами.

**Многострочные деревья в Win9x**

В AdvancedDemo компонента на странице демонстрации многострочных
элементов встречаем следующую огорчающую надпись:

Цитата:

> Since Virtual Treeview uses Unicode for text display it is not easy to
> provide multiline support on Windows 9x/Me systems. Under Windows NT
> (4.0, 2000, XP) there is support by the operation system and so full
> word breaking is possible there. Otherwise you have to insert line
> breaks manually to have multiline captions. Of course there is no
> difference in handling between multiline and single line nodes (except
> for the vertical alignment of the latter).

Но не все так страшно, если не рассчитывать на отображение юникода, а
только, скажем, английского или русского текста. Для этого достаточно
только поменять в файле VirtualTrees.pas текст процедуры DrawTextW на:

    procedure DrawTextW(DC: HDC; lpString: PWideChar; nCount: Integer; var lpRect: TRect; uFormat: Cardinal;
      AdjustRight: Boolean);
    begin
      Windows.DrawText(DC, PChar(String(lpString)), nCount, lpRect, uFormat);
    end;

После этого VirtualTreeView будет нормально переносить текст под Win9x,
а не только под 2000/XP.

**Сортировка VirtualStringTree**

Нужно написать обработчики событий OnCompareNodes и OnHeaderClick:

    {.$DEFINE SortMainColumnOnly} // Для разрешения сортировки только первого столбца
     
    procedure TForm1.VSTHeaderClick(Sender: TVTHeader; Column: TColumnIndex;
      Button: TMouseButton; Shift: TShiftState; X, Y: Integer);
    begin
      if Button = mbLeft then
      begin
        with Sender do
        begin
          {$IFDEF SortMainColumnOnly}
          if Column <> MainColumn then
            SortColumn := NoColumn
          else
          begin
            if SortColumn = NoColumn then
            begin
              SortColumn := Column;
              SortDirection := sdAscending;
            end
            else
          {$ELSE}
            SortColumn := Column;
          {$ENDIF}
              if SortDirection = sdAscending then
                SortDirection := sdDescending
              else
                SortDirection := sdAscending;
            Treeview.SortTree(SortColumn, SortDirection, False);
          {$IFDEF SortMainColumnOnly}
          end;
          {$ENDIF}
        end;
      end;
    end;
     
    procedure TForm1.VSTCompareNodes(Sender: TBaseVirtualTree; Node1,
      Node2: PVirtualNode; Column: TColumnIndex; var Result: Integer);
    begin
      with TVirtualStringTree(Sender) do
        Result := AnsiCompareText(Text[Node1, Column], Text[Node2, Column]);
    end;

Перемещение узлов в VirtualTree с помощью Drag&Drop

    procedure TForm1.VSTDragOver(Sender: TBaseVirtualTree; Source: TObject;
      Shift: TShiftState; State: TDragState; Pt: TPoint; Mode: TDropMode;
      var Effect: Integer; var Accept: Boolean);
    begin
      Accept := Sender.DropTargetNode  <> Sender.FocusedNode; // Drop'ать узел сам на себя нельзя
    end;
     
    procedure TForm1.VSTDragDrop(Sender: TBaseVirtualTree; Source: TObject;
      DataObject: IDataObject; Formats: TFormatArray; Shift: TShiftState;
      Pt: TPoint; var Effect: Integer; Mode: TDropMode);
    begin
      if Sender.DropTargetNode = nil then Exit;
      Sender.MoveTo(Sender.FocusedNode, Sender.DropTargetNode, amInsertAfter, False); // перемещаем узел
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      VST.DragType := dtVCL; // VirtualTree поддерживает так же и OLE Drag&Drop, поэтому явно указываем, что будем использовать механизм, реализованный в VCL
      VST.DragMode := dmAutomatic;
      VST.NodeDataSize := SizeOf(Integer);
      VST.RootNodeCount := 10;
      Randomize;
    end;
     
    procedure TForm1.VSTInitNode(Sender: TBaseVirtualTree; ParentNode,
      Node: PVirtualNode; var InitialStates: TVirtualNodeInitStates);
    begin
      PInteger(Sender.GetNodeData(Node))^ := Random(100);
    end;
     
    procedure TForm1.VSTGetText(Sender: TBaseVirtualTree; Node: PVirtualNode;
      Column: TColumnIndex; TextType: TVSTTextType; var CellText: WideString);
    begin
      CellText := 'Node# ' + IntToStr(PInteger(Sender.GetNodeData(Node))^)
    end;

Также нужно отметить событие OnDragAllowed, в котором можно указать
какие узлы можно перемещать, а какие нет. Это событие вызывается только
при ручном режиме Drag&Drop\'а

    procedure TForm1.FormCreate(Sender: TObject);
    begin
      VST.DragType := dtVCL; // VirtualTree поддерживает так же и OLE Drag&Drop, поэтому явно указываем, что будем использовать механизм, реализованный в VCL
      VST.DragMode := dmManual;
      VST.NodeDataSize := SizeOf(Integer);
      VST.RootNodeCount := 10;
      Randomize;
    end;
     
    procedure TForm1.VSTDragAllowed(Sender: TBaseVirtualTree;
      Node: PVirtualNode; Column: TColumnIndex; var Allowed: Boolean);
    begin
      Allowed := (Node.Index mod 2) = 0; // Указываем, что данный узел можно drag'ать
    end;

Предыдущий пример был для случая

    TreeOptions.SelectionOptions := TreeOptions.SelectionOptions - [toMultiSelect]

В случае мультивыделения код изменяется следующим образом

    procedure TForm1.VSTInitNode(Sender: TBaseVirtualTree; ParentNode,
      Node: PVirtualNode; var InitialStates: TVirtualNodeInitStates);
    begin

      PInteger(Sender.GetNodeData(Node))^ := Random(100);
      if Sender.GetNodeLevel(Node) < 2 then
        include(InitialStates, ivsHasChildren);
    end;
     
    procedure TForm1.VSTInitChildren(Sender: TBaseVirtualTree;
      Node: PVirtualNode; var ChildCount: Cardinal);
    begin
      ChildCount := 10;
    end;
     
    procedure TForm1.VSTDragOver(Sender: TBaseVirtualTree; Source: TObject;
      Shift: TShiftState; State: TDragState; Pt: TPoint; Mode: TDropMode;
      var Effect: Integer; var Accept: Boolean);
    var
      i: Integer;
      SelectNodes: TNodeArray;
    begin
      Accept := True;
      SelectNodes := Sender.GetSortedSelection(True);
      for i := low(SelectNodes) to high(SelectNodes) do
        if Sender.HasAsParent(Sender.DropTargetNode, SelectNodes[i]) then
        begin
          Accept := False;
          Exit;
        end;
    end;
     
    procedure TForm1.VSTDragDrop(Sender: TBaseVirtualTree; Source: TObject;
      DataObject: IDataObject; Formats: TFormatArray; Shift: TShiftState;
      Pt: TPoint; var Effect: Integer; Mode: TDropMode);
    var
      SelectNodes: TNodeArray;
      PredNode: PVirtualNode;
      i: Integer;
    begin
      if Sender.DropTargetNode = nil then Exit;
      SelectNodes := Sender.GetSortedSelection(True);
      PredNode := Sender.DropTargetNode;
      for i := low(SelectNodes) to high(SelectNodes) do
      begin
        Sender.MoveTo(SelectNodes[i], PredNode, amInsertAfter, False); // перемещаем узлы
        PredNode := SelectNodes[i]
      end;
    end;

Запретить скроллинг, когда строка шире, чем дерево
Если название узла очень длинное и не влезает по ширине в дерево, то
появляется горизонтальный скроллбар. И когда выделяешь такой узел то он
центруется по горизонтали.

В стандартном дереве с этим сталкиваться не приходилось никому.
Поскольку это поведение является достаточно необычным, то возникает
вопрос, как это побороть.

Отключить это можно опцией
TreeOptions.AutoOptions -\>
`toDisableAutoscrollOnFocus = True` (см. скриншот)

**Сохранение и загрузка**

    procedure WriteString(Stream: TStream; const S: string);
    var
      SavePos: Integer;
      Len: Integer;
    begin
      SavePos := Stream.Position;
      try
        Len := Length(s);
        Stream.WriteBuffer(Len, SizeOf(Len));
        Stream.WriteBuffer(PChar(s)^, Len);
      except
        Stream.Position := SavePos;
        raise;
      end;
    end;
     
    function ReadString(Stream: TStream): string;
    var
      SavePos: Integer;
      Len: Integer;
    begin
      SavePos := Stream.Position;
      try
        Stream.ReadBuffer(Len, SizeOf(Len));
        SetLength(Result, Len);
        Stream.ReadBuffer(PChar(Result)^, Len);
      except
        Stream.Position := SavePos;
        raise;
      end;
    end;

**Глюк при отображении многострочного текста**

В VirtualTreeView 4.3.1 допущена досадная ошибка при вычислении высоты
многострочного текста, что приводит к тому, что текст отображается
частично, с 3-мя точками в конце. Все дело в том, что в функции
вычисления высоты строки ComputeNodeHeight не вычитается размер границы
текста (TextMargin). Для того, чтобы эта функция работала правильно, ее
нужно изменить следующим образом:

    function TCustomVirtualStringTree.ComputeNodeHeight(Canvas: TCanvas; Node: PVirtualNode; Column: TColumnIndex;
      S: WideString): Integer;
     
    // Default node height calculation for multi line nodes. This method can be used by the application to delegate the
    // computation to the string tree.
    // Canvas is used to compute that value by using its current font settings.
    // Node and Column describe the cell to be used for the computation.
    // S is the string for which the height must be computed. If this string is empty the cell text is used instead.
     
    var
      R: TRect;
      DrawFormat: Cardinal;
      BidiMode: TBidiMode;
      Alignment: TAlignment;
      PaintInfo: TVTPaintInfo;
      Dummy: TColumnIndex;
     
    begin
      if Length(S) = 0 then
        S := Text[Node, Column];
      R := GetDisplayRect(Node, Column, True);
      DrawFormat := DT_TOP or DT_NOPREFIX or DT_CALCRECT or DT_WORDBREAK;
      if Column <= NoColumn then
      begin
        BidiMode := Self.BidiMode;
        Alignment := Self.Alignment;
      end
      else
      begin
        BidiMode := Header.Columns[Column].BidiMode;
        Alignment := Header.Columns[Column].Alignment;
      end;
     
      if BidiMode <> bdLeftToRight then
        ChangeBidiModeAlignment(Alignment);
     
      InflateRect(R, -FTextMargin, 0);
     
      // Allow for autospanning.
      PaintInfo.Node := Node;
      PaintInfo.BidiMode := BidiMode;
      PaintInfo.Column := Column;
      PaintInfo.CellRect := R;
      AdjustPaintCellRect(PaintInfo, Dummy);
     
      if BidiMode <> bdLeftToRight then
        DrawFormat := DrawFormat or DT_RIGHT or DT_RTLREADING
      else
        DrawFormat := DrawFormat or DT_LEFT;
      if IsWinNT then
        Windows.DrawTextW(Canvas.Handle, PWideChar(S), Length(S), PaintInfo.CellRect, DrawFormat)
      else
        DrawTextW(Canvas.Handle, PWideChar(S), Length(S), PaintInfo.CellRect, DrawFormat, False);
      Result := PaintInfo.CellRect.Bottom - PaintInfo.CellRect.Top;
    end;

