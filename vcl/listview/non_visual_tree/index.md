---
Title: Невизуальное дерево
Author: Малышев Владимир aka "мыш" (feedback@ectosoft.com)
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Невизуальное дерево
===================

    unit EctoSoftTree;
     
    {===============================================================================
     Класс TEctoSoftTree представляет собой невизуальное дерево для манипулирования
     древоподобными структурами в памяти. Мной в очередной раз из любви к искусству
     был изобретен велосипед :))), который тем не менее получился вполне съедобным
     и несмотря на наличие других вариантов решения задачи будет использоваться мной
     хотя бы назло врагам :) Буду рад если еще кому-то он придется по вкусу.
     
     Просьба при внесении изменений и дополнений в код, а также обнаружении ошибок
     (которых здесь нет ;) уведомить автора, т.е. меня
     
     Малышев Владимир aka "мыш"
     feedback@ectosoft.com
     http://www.EctoSoft.com
    ================================================================================}
     
    interface
     
    uses SysUtils, {EctoSysUtils,} Classes {EctoTypes,};
     
    {  TEctoTreeNode class --------------------------------------------------------}
    type TEctoSoftTree = class;
     
    TEctoTreeNode = class(TObject)
      private
        FParentNode: TEctoTreeNode;
     
        function GetDescendantCount(): integer;
        function GetAbsoluteIndex(): integer;
        function GetChildIndex(): integer;
        function GetLevel(): integer;
        function GetPrevSibling(): TEctoTreeNode;
        function GetNextSibling(): TEctoTreeNode;
        function GetLastDescendant(): TEctoTreeNode;
        procedure SetParent(NewParentNode: TEctoTreeNode);
     
      public
        ParentTree: TEctoSoftTree;
        Children: TList;
        Data: Pointer;
        Caption: string;
        destructor Destroy(); override;
        constructor Create();
     
        function GetPrevChild(TargetChildNode: TEctoTreeNode): TEctoTreeNode;
        function GetNextChild(TargetChildNode: TEctoTreeNode): TEctoTreeNode;
        function GetLastChild(): TEctoTreeNode;
        function GetNext(): TEctoTreeNode;
        function GetPrev(): TEctoTreeNode;
        function IsRoot(): boolean;
        function IsParentOf(Node: TEctoTreeNode): boolean;
     
        procedure MoveUp();
        procedure MoveDown();
        procedure MoveLeft();
        procedure MoveRight();
        procedure Sort(Compare: TListSortCompare; SortSubtrees: boolean);
     
        property AbsoluteIndex: integer read GetAbsoluteIndex;
        property Index: integer read GetChildIndex;
        property PrevSibling: TEctoTreeNode read GetPrevSibling;
        property NextSibling: TEctoTreeNode read GetNextSibling;
        property LastDescendant: TEctoTreeNode read GetLastDescendant;
        property DescendantCount: integer read GetDescendantCount;
        property Level: integer read GetLevel;
        property ParentNode: TEctoTreeNode read FParentNode write SetParent;
    end;
     
    TOnFreeNodeEvent = procedure(Node: TEctoTreeNode) of object;
     
    {  TEctoSoftTree class --------------------------------------------------------}
    TEctoSoftTree = class(TObject)
      private
        FOnFreeNodeEvent: TOnFreeNodeEvent;
     
        function GetNodeFromIndex(Index:integer): TEctoTreeNode;
        function GetNodeCount(): integer;
      public
        Root: TEctoTreeNode;
        function FindNode(FindCaption: string): TEctoTreeNode;
        procedure DeleteNode(Index: integer); overload;
        procedure DeleteNode(DeletingNode: TEctoTreeNode); overload;
        function AddNode(aParentNode:TEctoTreeNode):
          TEctoTreeNode; overload;
        function AddNode(aParentNode:TEctoTreeNode; Caption: string):
          TEctoTreeNode; overload;
        function AddNode(aParentNode:TEctoTreeNode; Data: Pointer):
          TEctoTreeNode; overload;
        function AddNode(aParentNode:TEctoTreeNode; Caption: string; Data: Pointer):
          TEctoTreeNode; overload;
        procedure Clear();  
     
        destructor Destroy; override;
     
        property Nodes[Index:integer] : TEctoTreeNode read GetNodeFromIndex;
        property NodeCount: integer read GetNodeCount;
        property OnFreeNode: TOnFreeNodeEvent read FOnFreeNodeEvent write
          FOnFreeNodeEvent;
    end;
     
    implementation
     
    { TEctoSoftTree }
     
    function TEctoSoftTree.AddNode(aParentNode: TEctoTreeNode; Caption: string;
      Data: Pointer): TEctoTreeNode;
    var
      NewNode: TEctoTreeNode;
    begin
      NewNode := TEctoTreeNode.Create;
     
      if Root=nil then
      begin
        NewNode.FParentNode := nil;
        Root := NewNode;
      end
      else
      begin
        if aParentNode=nil then
          Raise EInvalidOperation.Create('Parent node must exists');
     
        NewNode.FParentNode := aParentNode;
        aParentNode.Children.Add(NewNode);
      end;
     
      NewNode.Caption := Caption;
      NewNode.Data := Data;
      NewNode.ParentTree := self;
     
      result := NewNode;    
    end;
     
    function TEctoSoftTree.AddNode(aParentNode: TEctoTreeNode): TEctoTreeNode;
    begin
      result := AddNode(aParentNode,'',nil);
    end;
     
    function TEctoSoftTree.AddNode(aParentNode: TEctoTreeNode;
      Caption: string): TEctoTreeNode;
    begin
      result := AddNode(aParentNode,Caption,nil);
    end;
     
    function TEctoSoftTree.AddNode(aParentNode: TEctoTreeNode;
      Data: Pointer): TEctoTreeNode;
    begin
      result := AddNode(aParentNode,'',Data);
    end;
     
    procedure TEctoSoftTree.Clear;
    begin
      if Root=nil then exit;
      Root.Free;
      Root := nil;
    end;
     
    procedure TEctoSoftTree.DeleteNode(Index: integer);
    begin
      DeleteNode(Nodes[Index]);
    end;
     
    procedure TEctoSoftTree.DeleteNode(DeletingNode: TEctoTreeNode);
    begin
      if DeletingNode.IsRoot then
          // Рут не нужно исключать из родительского списка,
          // поэтому просто освобождаем
          FreeAndNil(Root)
        else
        begin
          // обращение к ParentNode без проверки на его существование обусловлено тем,
          // что раз это не Root, значит у него обязательно есть Parent
          DeletingNode.FParentNode.Children.Delete
            (DeletingNode.FParentNode.Children.IndexOf(DeletingNode));
          FreeAndNil(DeletingNode);
        end;
    end;
     
     
    destructor TEctoSoftTree.Destroy;
    begin
      Clear();
      inherited;
    end;
     
    { функция FindNode пока ищет только первое вхождение узла с заданным сaption
      - надо доработать}
    function TEctoSoftTree.FindNode(FindCaption: string): TEctoTreeNode;
     
      procedure FindNode_(TargetNode: TEctoTreeNode);
      var
        i:integer;
      begin
     
        // выходим из всех рекурсий,
        // если где-то в одной из них ранее уже был найден узел
        if result<>nil then exit;
     
        { проверяем вызванный узел TargetNode на соответствие }
        if TargetNode.Caption = FindCaption then
        begin
          result := TargetNode;
          exit;
        end;
        { /проверяем вызванный узел TargetNode на соответствие }
     
        { вызываем всех детей узела TargetNode для их проверки }
        i:=0;
        while i<TargetNode.Children.Count do
        begin
          FindNode_(TEctoTreeNode(TargetNode.Children.Items[i]));
          inc(i);
        end;
        { /вызываем всех детей узела TargetNode для их проверки }
      end;
     
    begin
      result := nil;
      FindNode_(Root);
    end;
     
     
    function TEctoSoftTree.GetNodeCount: integer;
    begin
      if Root=nil then result := 0 else                                            
        result := Root.GetDescendantCount+1;  // +1 - Учитываем Root
    end;
     
    { функция GetNodeFromIndex - "движок" для Nodes[Index:integer] }
    function TEctoSoftTree.GetNodeFromIndex(Index: integer): TEctoTreeNode;
    var
      IndexCounter: integer;
     
      procedure CompareNodeIndex(Node: TEctoTreeNode);
      var
        i:integer;
      begin
        { блок 1 проверяем вызванный узел }
        inc(IndexCounter);
        if IndexCounter=Index then
          begin
            result := Node;
            exit;
          end;
        { / блок 1 проверяем вызванный узел }
     
        { вызываем дочерние узлы чтобы выполнить в них предыдущий блок - блок 1  }
        i:=0;  
        while i<Node.Children.Count do
        begin
          CompareNodeIndex(TEctoTreeNode(Node.Children[i]));
          inc(i);
        end;
        { /вызываем дочерние узлы чтобы выполнить в них предыдущий блок - блок 1  }
      end;
     
    begin
      IndexCounter := -1;
      result := nil;
      CompareNodeIndex(Root);
      if (result=nil) then  Raise EInvalidOperation.Create('Wrong index');
    end;
     
    { TEctoTreeNode }
     
    constructor TEctoTreeNode.Create;
    begin
      Children := TList.Create;
    end;
     
    destructor TEctoTreeNode.Destroy;
    var
      i:integer;
    begin
      if assigned(ParentTree.FOnFreeNodeEvent) then
        ParentTree.FOnFreeNodeEvent(self);
      i:=0;
      while i<Children.Count do
      begin
        TEctoTreeNode(Children.Items[i]).Free;
        inc(i);
      end;
      Children.Free;
      inherited;
    end;
     
    function TEctoTreeNode.GetAbsoluteIndex: integer;
    var
      Node: TEctoTreeNode;
    begin
      if IsRoot then Result := 0
        else
        begin
          Result := -1;
          Node := Self;
          while Node <> nil do
          begin
            Inc(Result);
            Node := Node.GetPrev;
          end;
        end;
    end;
     
    { функция GetDescendantCount возвращает количество всех потомков данного узла,
      включая дочерние узлы и их потомки }
    function TEctoTreeNode.GetChildIndex: integer;
    begin
      result := -1;
      if IsRoot then exit;
      result := ParentNode.Children.IndexOf(self);
    end;
     
    function TEctoTreeNode.GetDescendantCount: integer;
    var
      Node: TEctoTreeNode;
    begin
      result := 0;
      Node := Self.GetLastDescendant;
      if Node = nil then exit;
     
      while (Node <> self) do
      begin
        inc(result);
        Node := Node.GetPrev;
      end;
    end;
     
    { функция GetLastChild возвращает последний дочерний узел текущего. Возвращает
      nil в случае если узел не имеет дочерних узлов, что и обуславливает
      необходимость данной функции }
    function TEctoTreeNode.GetLastChild: TEctoTreeNode;
    begin
      result := nil;
      if Children.Count>0 then
        result := TEctoTreeNode(Children[Children.Count-1]);
    end;
     
    { функция GetLastDescendant возвращает последнего потомка текущего узла. Учитываются не только
      прямые потомки (дочерние узлы) но и дальние (их потомки) }
    function TEctoTreeNode.GetLastDescendant(): TEctoTreeNode;
    var
      Node: TEctoTreeNode;
    begin
      Node := self;
      while Node.GetLastChild<>nil do
        Node := Node.GetLastChild();
      if Node = self then Node := nil;
      result := Node;
    end;
     
    function TEctoTreeNode.GetLevel: integer;
    var
      Node: TEctoTreeNode;
    begin
      result := 0;
      if IsRoot then exit;
     
      Node := self;
      while Node<>ParentTree.Root do
      begin
        inc(result);
        Node := Node.FParentNode;
      end;
    end;
     
    { GetNext возвращает следующий узел по ходу "рекурсивного" обхода дерева }
    function TEctoTreeNode.GetNext: TEctoTreeNode;
    var
      Node : TEctoTreeNode;
    begin
      result := nil;
     
      if Children.Count>0 then
        result := TEctoTreeNode(Children[0]);
        // Если у узла есть дочерние узлы,
        // то следующим за ним будет очевидно первый дочерний
     
      if result = nil then          // Если дочерних нет...
        result := GetNextSibling(); // то следующим будет следующий сестринский узел
     
      if (result = nil) and (not IsRoot) then // Если и дочерних и сестринских нет,
                                              // а также это не рут, то следующим будет 
                                              // первый сестринский узел родителя
      begin
        Node := FParentNode;
        while (Node.GetNextSibling = nil) and (not Node.IsRoot) do
          // У родителя может не оказаться сестринских узлов,
          // тогда проводим поиск (идя назад) первого родителя
          // (беря "родителя родителя") у которого будет сестринский узел
          Node := Node.FParentNode;
        if not Node.IsRoot then
          result := Node.GetNextSibling;
      end;    
    end;
     
    { функция GetNextChild возвращает следующией дочерний узел отсчитывая от
      заданного дочернего узла. Если заданный узел является последним дочерним
      узлом, функция возвращает nil }
    function TEctoTreeNode.GetNextChild(TargetChildNode: TEctoTreeNode): TEctoTreeNode;
    var
      NextChildIndex:integer;
    begin
      result := nil;
      NextChildIndex := Children.IndexOf(TargetChildNode)+1;
      if (NextChildIndex<Children.Count) and (NextChildIndex>0)
        then result := TEctoTreeNode(Children[NextChildIndex]);
    end;
     
    function TEctoTreeNode.GetNextSibling: TEctoTreeNode;
    begin
      if IsRoot then result := nil
        else result := FParentNode.GetNextChild(Self);
    end;
     
    { GetPrev возвращает предыдущий узел по ходу рекурсивного обхода дерева }
    function TEctoTreeNode.GetPrev: TEctoTreeNode;
    var
      Node: TEctoTreeNode;
    begin
      result := nil;
      if IsRoot then
        exit;
      result := GetPrevSibling();         // получаем предыдущий сестринский узел
      if result=nil then
        result := FParentNode             // если его нет, значит наш узел первый,
                                          // значит предыдущим будет его родитель
      else
      begin                               // а если есть...
        Node := result.LastDescendant;    // получаем последнего потомка
        if Node<>nil then result := Node; // если такой существует (если вообще есть потомки)
                                          // то он и будет предыдущим.
                                          // Если же не существует, то result остается со значением,
                                          // полученным в строке result := GetPrevSibling();
      end
     
     
    end;
     
    { функция GetPrevChild возвращает предыдущий дочерний узел отсчитывая от
      заданного дочернего узла. Если заданный узел является первым дочерним
      узлом, функция возвращает nil }
    function TEctoTreeNode.GetPrevChild(TargetChildNode: TEctoTreeNode): TEctoTreeNode;
    var
      PrevChildIndex:integer;
    begin
      result := nil;
      PrevChildIndex := Children.IndexOf(TargetChildNode)-1;
      if PrevChildIndex>-1 then result := TEctoTreeNode(Children[PrevChildIndex]);
    end;
     
    function TEctoTreeNode.GetPrevSibling: TEctoTreeNode;
    begin
      if IsRoot then result := nil
        else result := FParentNode.GetPrevChild(Self);
    end;
     
    { функция IsParentOf возвращает true если узел является предком заданного
      в независимости от их уровня }
    function TEctoTreeNode.IsParentOf(Node: TEctoTreeNode): boolean;
    var
      TempNode : TEctoTreeNode;
    begin
      result := false;
      TempNode := Node.FParentNode;
     
      while TempNode<>nil do
      begin
        if TempNode = self then
        begin
          result := true;
          exit;
        end;
        TempNode := TempNode.FParentNode;
      end;
    end;
     
    function TEctoTreeNode.IsRoot: boolean;
    begin
      result := (Self=ParentTree.Root);
    end;
     
    { процедура MoveDown перемещает узел вниз. Перемещение возможно только в
      пределах сестринских узлов, если узел является последним в списке детей
      текущего родителя, то перемещение невозможно }
    procedure TEctoTreeNode.MoveDown;
    var
      Temp: Pointer;
      ChildIndex: integer;
    begin
      if IsRoot then exit;
      if NextSibling<>nil then
      begin
        ChildIndex := Index; // временная переменная ChildIndex нужна
                             // т.к. Index - расчетное свойство, 
                             // незачем лишние вызовы.
                             // Кроме того после первого оператора индекс теряется
        Temp := ParentNode.Children[ChildIndex];
        ParentNode.Children[ChildIndex] := ParentNode.Children[ChildIndex+1];
        ParentNode.Children[ChildIndex+1] := Temp;
      end;
    end;
     
    { процедура MoveLeft перемещает узел влево. Перемещение идет по принципу:
      новым родителем становится родитель родителя, а узел вставляется в список
      дочерних узлов родителя родителя таким образом, чтобы оказаться сразу после
      текущего родителя (текущий родитель после перемещения становится предыдущим
      сестринским узлом) }
    procedure TEctoTreeNode.MoveLeft;
    begin
      if (ParentNode.IsRoot) or (IsRoot) then exit;
      ParentNode.ParentNode.Children.Insert(ParentNode.Index+1,self);
      ParentNode.Children.Delete(ParentNode.Children.IndexOf(self));
      FParentNode := ParentNode.ParentNode;
      // FParentNode используем вместо ParentNode потому
      // что нам не нужен вызов всей процедуры присваивания родителя,
      // мы всю работу делаем здесь сами и она специфична.
    end;
     
    { процедура MoveRight перемещает узел вправо. Перемещение идет по принципу:
      новым родителем становится предыдущий сестринский узел. Если предыдущего
      сестринского узла нет, перемещение считается невозможным }
    procedure TEctoTreeNode.MoveRight;
    begin
      if (IsRoot) or (PrevSibling=nil) then exit; // Если нет сестринского узла перед этим,
                                                  // то невозможно движение вправо
      ParentNode := PrevSibling;                  // Здесь вызов процедуры присваивания родителя.
    end;
     
    { процедура MoveUp перемещает узел вверх. Перемещение идет по принципу:
      если у узла есть сестринские узлы выше него, то узел просто встает выше
      предыдущего сестринского узла. Если же сестринских узлов выше нет (узел первый
      дочерний у родителя), то узел становится выше родительского, т.е. в конец
      дочерних узлов предыдущего сестринского узла родителя. }
    procedure TEctoTreeNode.MoveUp;
    var
      Temp: Pointer;
      ChildIndex: integer;
    begin
      if IsRoot then exit;
      if PrevSibling<>nil then
      begin
        ChildIndex := Index;
        // временная переменная ChildIndex нужна
        // т.к. Index - расчетное свойство, незачем лишние вызовы.
        // Кроме того после первого оператора индекс теряется
        Temp := ParentNode.Children[ChildIndex];
        ParentNode.Children[ChildIndex] := ParentNode.Children[ChildIndex-1];
        ParentNode.Children[ChildIndex-1] := Temp;
      end
      else
      begin
        if not ParentNode.IsRoot then
        begin
          ParentNode := ParentNode.ParentNode;
          // Это присваивание автоматически добавит узел в конец, последним дочерним.
          MoveUp;
        end;
      end;
    end;
     
    { установка нового родителя функцией SetParent фактически означает перенос
      ветви дерева в другую ветвь }
    procedure TEctoTreeNode.SetParent(NewParentNode: TEctoTreeNode);
    begin
      if (NewParentNode=nil) or (NewParentNode=self) then exit;
      ParentNode.Children.Delete(ParentNode.Children.IndexOf(self));
      NewParentNode.Children.Add(self);
      self.FParentNode := NewParentNode;
    end;
     
    procedure TEctoTreeNode.Sort(Compare: TListSortCompare; SortSubtrees: boolean);
    var
      i,j,CompareResult: integer;
      Temp : Pointer;
    begin
      j:=0;
      while j<Children.Count do
      begin
     
        i:=Children.Count-1;
        while i>j do
        begin
          if i>j then
          begin
            CompareResult := Compare(Children[i],Children[i-1]);
            if CompareResult>0 then
            begin
              Temp := Children[i-1];
              Children[i-1] := Children[i];
              Children[i] := Temp;
            end;
          end;
          dec(i);
        end;
     
        if SortSubtrees then
          TEctoTreeNode(Children[j]).Sort(Compare,true);
     
        inc(j);
      end;
    end;
     
    end.

