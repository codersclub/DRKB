---
Title: Ускорение работы TTreeView
Date: 01.01.2007
---


Ускорение работы TTreeView
==========================

Вариант 1:

Source: <https://delphiworld.narod.ru>

Представляем вашему вниманию немного переработанный компонент TreeView,
работающий быстрее своего собрата из стандартной поставки Delphi. Кроме
того, была добавлена возможность вывода текста узлов и пунктов в жирном
начертании (были использованы методы TreeView, хотя, по идее, необходимы
были свойства TreeNode. Мне показалось, что это будет удобнее).

Для сравнения:

TreeView:

- 128 сек. для загрузки 1000 элементов (без сортировки)*
- 270 сек. для сохранения 1000 элементов (4.5 минуты!!!)

HETreeView:

- 1.5 сек. для загрузки 1000 элементов - ускорение около 850%!!!  
  (2.3 секунды без сортировки = stText)*
- 0.7 сек. для сохранения 1000 элементов - ускорение около 3850%!!!

**\* Примечание:**

Все операции выполнялись на медленной машине 486SX 33 Mгц, 20 Mб RAM.

Если TreeView пуст, загрузка происходит за 1.5 секунды, плюс 1.5 секунды
на стирание 1000 элементов (общее время загрузки составило 3 секунды). В
этих условиях стандартный компонент TTreeView показал общее время 129.5
секунд. Очистка компонента осуществлялась вызовом функции
SendMessage(hwnd, TVM\_DELETEITEM, 0, Longint(TVI\_ROOT)).

Проведите несколько приятных минут, развлекаясь с компонентом.

    unit HETreeView;
    {$R-}
     
    // Описание: Реактивный TreeView
    (*
     
    TREEVIEW:
    128 сек. для загрузки 1000 элементов (без сортировки)*
    270 сек. для сохранения 1000 элементов (4.5 минуты!!!)
     
    HETREEVIEW:
    1.5 сек. для загрузки 1000 элементов - ускорение около 850%!!!
      (2.3 секунды без сортировки = stText)*
    0.7 сек. для сохранения 1000 элементов - ускорение около 3850%!!!
     
    NOTES:
    - Все операции выполнялись на медленной машине 486SX 33 Mгц, 20 Mб RAM.
     
    - * Если TTreeView пуст, загрузка происходит за 1.5 секунды,
    плюс 1.5 секунды на стирание 1000 элементов
      (общее время загрузки составило 3 секунды).
    В этих условиях стандартный компонент TreeView показал общее время 129.5 секунд.
    Очистка компонента осуществлялась вызовом функции
    SendMessage(hwnd, TVM_DELETEITEM, 0, Longint(TVI_ROOT)).
    *)
     
    interface
     
    uses
     
      SysUtils, Windows, Messages, Classes, Graphics,
      Controls, Forms, Dialogs, ComCtrls, CommCtrl;
     
    type
     
      THETreeView = class(TTreeView)
      private
        FSortType: TSortType;
        procedure SetSortType(Value: TSortType);
      protected
        function GetItemText(ANode: TTreeNode): string;
      public
        constructor Create(AOwner: TComponent); override;
        function AlphaSort: Boolean;
        function CustomSort(SortProc: TTVCompare; Data: Longint): Boolean;
        procedure LoadFromFile(const AFileName: string);
        procedure SaveToFile(const AFileName: string);
        procedure GetItemList(AList: TStrings);
        procedure SetItemList(AList: TStrings);
        //Жирное начертание шрифта 'Bold' должно быть свойством TTreeNode, но...
        function IsItemBold(ANode: TTreeNode): Boolean;
        procedure SetItemBold(ANode: TTreeNode; Value: Boolean);
      published
        property SortType: TSortType read FSortType write SetSortType default
          stNone;
      end;
     
    procedure Register;
     
    implementation
     
    function DefaultTreeViewSort(Node1, Node2: TTreeNode; lParam: Integer): Integer;
      stdcall;
    begin
     
      {with Node1 do
      if Assigned(TreeView.OnCompare) then
      TreeView.OnCompare(Node1.TreeView, Node1, Node2, lParam, Result)
      else}
      Result := lstrcmp(PChar(Node1.Text), PChar(Node2.Text));
    end;
     
    constructor THETreeView.Create(AOwner: TComponent);
    begin
     
      inherited Create(AOwner);
      FSortType := stNone;
    end;
     
    procedure THETreeView.SetItemBold(ANode: TTreeNode; Value: Boolean);
    var
     
      Item: TTVItem;
      Template: Integer;
    begin
     
      if ANode = nil then
        Exit;
     
      if Value then
        Template := -1
      else
        Template := 0;
      with Item do
      begin
        mask := TVIF_STATE;
        hItem := ANode.ItemId;
        stateMask := TVIS_BOLD;
        state := stateMask and Template;
      end;
      TreeView_SetItem(Handle, Item);
    end;
     
    function THETreeView.IsItemBold(ANode: TTreeNode): Boolean;
    var
     
      Item: TTVItem;
    begin
     
      Result := False;
      if ANode = nil then
        Exit;
     
      with Item do
      begin
        mask := TVIF_STATE;
        hItem := ANode.ItemId;
        if TreeView_GetItem(Handle, Item) then
          Result := (state and TVIS_BOLD) <> 0;
      end;
    end;
     
    procedure THETreeView.SetSortType(Value: TSortType);
    begin
     
      if SortType <> Value then
      begin
        FSortType := Value;
        if ((SortType in [stData, stBoth]) and Assigned(OnCompare)) or
          (SortType in [stText, stBoth]) then
          AlphaSort;
      end;
    end;
     
    procedure THETreeView.LoadFromFile(const AFileName: string);
    var
     
      AList: TStringList;
    begin
     
      AList := TStringList.Create;
      Items.BeginUpdate;
      try
        AList.LoadFromFile(AFileName);
        SetItemList(AList);
      finally
        Items.EndUpdate;
        AList.Free;
      end;
    end;
     
    procedure THETreeView.SaveToFile(const AFileName: string);
    var
     
      AList: TStringList;
    begin
     
      AList := TStringList.Create;
      try
        GetItemList(AList);
        AList.SaveToFile(AFileName);
      finally
        AList.Free;
      end;
    end;
     
    procedure THETreeView.SetItemList(AList: TStrings);
    var
     
      ALevel, AOldLevel, i, Cnt: Integer;
      S: string;
      ANewStr: string;
      AParentNode: TTreeNode;
      TmpSort: TSortType;
     
      function GetBufStart(Buffer: PChar; var ALevel: Integer): PChar;
      begin
        ALevel := 0;
        while Buffer^ in [' ', #9] do
        begin
          Inc(Buffer);
          Inc(ALevel);
        end;
        Result := Buffer;
      end;
     
    begin
     
      // Удаление всех элементов - в обычной ситуации
      // подошло бы Items.Clear, но уж очень медленно
      SendMessage(handle, TVM_DELETEITEM, 0, Longint(TVI_ROOT));
      AOldLevel := 0;
      AParentNode := nil;
     
      //Снятие флага сортировки
      TmpSort := SortType;
      SortType := stNone;
      try
        for Cnt := 0 to AList.Count - 1 do
        begin
          S := AList[Cnt];
          if (Length(S) = 1) and (S[1] = Chr($1A)) then
            Break;
     
          ANewStr := GetBufStart(PChar(S), ALevel);
          if (ALevel > AOldLevel) or (AParentNode = nil) then
          begin
            if ALevel - AOldLevel > 1 then
              raise Exception.Create('Неверный уровень TreeNode');
          end
          else
          begin
            for i := AOldLevel downto ALevel do
            begin
              AParentNode := AParentNode.Parent;
              if (AParentNode = nil) and (i - ALevel > 0) then
                raise Exception.Create('Неверный уровень TreeNode');
            end;
          end;
          AParentNode := Items.AddChild(AParentNode, ANewStr);
          AOldLevel := ALevel;
        end;
      finally
        //Возвращаем исходный флаг сортировки...
        SortType := TmpSort;
      end;
    end;
     
    procedure THETreeView.GetItemList(AList: TStrings);
    var
     
      i, Cnt: integer;
      ANode: TTreeNode;
    begin
     
      AList.Clear;
      Cnt := Items.Count - 1;
      ANode := Items.GetFirstNode;
      for i := 0 to Cnt do
      begin
        AList.Add(GetItemText(ANode));
        ANode := ANode.GetNext;
      end;
    end;
     
    function THETreeView.GetItemText(ANode: TTreeNode): string;
    begin
     
      Result := StringOfChar(' ', ANode.Level) + ANode.Text;
    end;
     
    function THETreeView.AlphaSort: Boolean;
    var
     
      I: Integer;
    begin
     
      if HandleAllocated then
      begin
        Result := CustomSort(nil, 0);
      end
      else
        Result := False;
    end;
     
    function THETreeView.CustomSort(SortProc: TTVCompare; Data: Longint): Boolean;
    var
     
      SortCB: TTVSortCB;
      I: Integer;
      Node: TTreeNode;
    begin
     
      Result := False;
      if HandleAllocated then
      begin
        with SortCB do
        begin
          if not Assigned(SortProc) then
            lpfnCompare := @DefaultTreeViewSort
          else
            lpfnCompare := SortProc;
          hParent := TVI_ROOT;
          lParam := Data;
          Result := TreeView_SortChildrenCB(Handle, SortCB, 0);
        end;
     
        if Items.Count > 0 then
        begin
          Node := Items.GetFirstNode;
          while Node <> nil do
          begin
            if Node.HasChildren then
              Node.CustomSort(SortProc, Data);
            Node := Node.GetNext;
          end;
        end;
      end;
    end;
     
    //Регистрация компонента
     
    procedure Register;
    begin
     
      RegisterComponents('Win95', [THETreeView]);
    end;
     
    end.


------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    Try
      LockWindowUpdate(TreeView1.Handle);
      ...
    finally
      LockWindowUpdate(0);


Выключите свойство сортировки (установите sort в off).

Я много работаю с TTreeView. За раз обычно я манипулирую сотнями, а то и
тысячами узлов. Для сокращения времени обработки воспользуйтесь моим
опытом и советами:

Используйте TreeView1.BeginUpdate и TreeView1.EndUpdate перед и после
того, как делаете много изменений и добавлений.

Установите SortType на stNone по умолчанию. (Запрещаем дереву делать
автоматическую сортировку при каждом добавлении или изменении узлов.
Это, вероятно, будет самой большой экономией временных затрат.)

Если вам необходимо отсортировать ваши узлы, то сохранить время
сортировки можно сортировкой только в случае их видимости. Поскольку вы
добавляете элементы к дереву сами, вы можете решить выбрать сортировку
по умолчанию, а сортировать только детей (при раскрытии родительского
узла). Вот как это я делаю в обработчике события OnExpanded:

    procedure TForm1.TreeView1Expanded(Sender: TObject; Node: TTreeNode);
    begin
      Node.Alphasort;  {Сортируем дочерние узлы и _только_ дочерние узлы}
    end;

Данный код позаботится о сортировки каждого уровня, кроме корневого. Я
не знаю способа сообщить TTreeView о необходимости сортировки только
корневых узлов. TreeView1.Alphasort сортирует _каждый_ элемент дерева
(тратится много времени). Если вам нужно сортировать элементы корневого
уровня, не сортируя все узлы дерева, вы должны делать это сами.
Вероятно, необходимо начать с QuickSort или InsertionSort, и метода
TTreeNode.MoveTo.

Поместите ваш код для работы с TreeView между вызовами
TreeView1.Items.BeginUpdate и TreeView1.Items.EndUpdate. И убедитесь в
том, что дерево неотсортировано.


