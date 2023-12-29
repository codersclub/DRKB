---
Title: Примеры использования Drag & Drop для различных визуальных компонентов
author: Борис Новгородов
Date: 01.01.2002
---


Примеры использования Drag & Drop для различных визуальных компонентов
======================================================================

::: {.date}
01.01.2007
:::

Перетаскивание информации с помощью мыши стало стандартом для программ,
работающих в Windows. Часто это бывает удобно и позволяет добиться более
быстрой работы. В данной статье я постарался показать максимальное
количество примеров использования данной технологии при разработке
приложений в среде Delphi. Конечно, результат может быть достигнут
различными путями, продемонстрированные приемы не являются единственными
и, возможно, не всегда самые оптимальные, но вполне работоспособны, и
указывают направление поиска. Надеюсь, что они побудят начинающих
программистов к более широкому использованию Drag\'n\'Drop в своих
программах, тем более что пользователи, особенно неопытные, быстро
привыкают к перетаскивание и часто его применяют.

Проще всего делать Drag из тех компонентов, для которых однозначно ясно,
что именно перетаскивать. Для этого устанавливаем у источника DragMode =
dmAutomatic, а у приемника пишем обработчики событий OnDragOver -
разрешение на прием, и OnDragDrop - действия, производимые при окончании
перетаскивания.

    procedure TForm1.StringGrid2DragOver(Sender, Source: TObject; X,
      Y: Integer; State: TDragState; var Accept: Boolean);
    begin
      Accept := Source = Edit1;
      // разрешено перетаскивание только из Edit1,
      // при работе программы меняется курсор
    end;
     
    procedure TForm1.StringGrid2DragDrop(Sender, Source: TObject; X,
      Y: Integer);
    var
      ACol, ARow: Integer;
    begin
      StringGrid2.MouseToCell( X, Y, ACol, ARow);
    // находим, над какой ячейкой произвели Drop
      StringGrid2.Cells[ Acol, Arow] := Edit1.Text;
    //  записываем в нее содержимое Edit1
    end;

Теперь рассмотрим копирование в упорядоченный список ListBox1 из другого
списка. В OnDragOver проверяем, выбран ли хоть один элемент в источнике:

    Accept := (Source = ListBox2) and (ListBox2.ItemIndex >= 0);

В OnDragDrop ищем отмеченные в источнике строки (установлен
множественный выбор) и добавляем только те, которых еще нет в приемнике:

    for i := 0 to ListBox2.Items.Count - 1 do
      if (ListBox2.Selected[i]) and (ListBox1.Items.IndexOf(ListBox2.Items[i])<0)
        then
          ListBox1.Items.Add(ListBox2.Items[i]);

Для ListBox2 реализуем перенос строк из ListBox1 и перестановку
элементов в желаемом порядке. В OnDragOver разрешаем Drag из любого
ListBox:

    Accept := (Source is TListBox) and ((Source as TListBox).ItemIndex >= 0);

А OnDragDrop будет выглядеть так:

    var
      s: string;
    begin
      if Source = ListBox1 then
      begin
        ListBox2.Items.Add(ListBox1.Items[ListBox1.ItemIndex]);
        ListBox1.Items.Delete(ListBox1.ItemIndex);
      //удаляем перенесенный элемент
      end
      else          //внутренняя перестановка
      begin
        s := ListBox2.Items[ListBox2.ItemIndex];
        ListBox2.Items.Delete(ListBox2.ItemIndex);
        ListBox2.Items.Insert(ListBox2.ItemAtPos(Point(X, Y), False), s);
      //находим, в какую позицию переносить и вставляем
      end;
    end;

Научимся переносить текст в Memo, вставляя его в нужное место. Поскольку
я выбрал в качестве источника любой из ListBox, подключим в Инспекторе
Объектов для OnDragOver уже написанный ранее обработчик
ListBox2DragOver, а в OnDragDrop напишем

    if not CheckBox1.Checked then  // при включении добавляется в конец текста
    begin
     Memo1.SelStart := LoWord(Memo1.Perform(EM_CHARFROMPOS, 0, MakeLParam(X,Y)));
        // устанавливаем позицию вставки согласно координатам мыши
     Memo1.SelText := TListBox(Source).Items[TListBox(Source).ItemIndex];
    end
      else
        memo1.lines.add(TListBox(Source).Items[TListBox(Source).ItemIndex]);

Замечу, что для RichEdit EM\_CHARFROMPOS работает несколько иначе, что
продемонстрировано в следующем примере. Перенос из Memo реализован с
помощью правой кнопки мыши, для того, чтобы не изменять стандартное
поведение Memo, и поскольку нажатие левой кнопки снимает выделение. Для
Memo1 установлено DragMode = dmManual, а перетаскивание инициируется в
OnMouseDown

    if (Button = mbRight) and (Memo1.SelLength > 0) then Memo1.BeginDrag(True);

Обработчик RichEdit1DragOver очевиден, а в RichEdit1DragDrop пишем

    var
      p: tpoint;
    begin
      if not CheckBox1.Checked then
      begin
        p := point(x, y);
        RichEdit1.SelStart := RichEdit1.Perform(EM_CHARFROMPOS, 0, Integer(@P));
        RichEdit1.SelText := Memo1.SelText;
      end
      else
        RichEdit1.Lines.Add(Memo1.SelText);
    end;

Рассмотрим теперь перетаскивание в ListView1 (ViewStyle = vsReport). В
OnDragOver разрешим прием из ListBox2 и из себя же:

    Accept := ((Source = ListBox2) and (ListBox2.ItemIndex >= 0)) or
      (Source = Sender);

А вот OnDragDrop теперь будет посложнее

    var
      Item, CurItem: TListItem;
    begin
      if Source = ListBox2 then
      begin
        Item := ListView1.DropTarget;
        if Item <> nil then
        //  случай перетаскивания на Caption
          if Item.SubItems.Count = 0 then
            Item.SubItems.Add(ListBox2.Items[ListBox2.ItemIndex])
        //  добавляем SubItem, если их еще нет
          else
            Item.SubItems[0]:=ListBox2.Items[ListBox2.ItemIndex]
        //  иначе заменяем имеющийся SubItem
        else
        begin
       // при перетаскивании на пустое место создаем новый элемент
          Item := ListView1.Items.Add;
          Item.Caption := ListBox2.Items[ListBox2.ItemIndex];
        end;
      end
     
      else // случай внутренней перестановки
      begin
        CurItem := ListView1.Selected;
    // запомним выбранный элемент
        Item := ListView1.GetItemAt(x, y);
    // другой метод определения элемента на который делаем Drop
        if Item <> nil then
          Item := ListView1.Items.Insert(Item.Index)
    // вставляем новый элемент перед найденным
        else
          Item := ListView1.Items.Add;
    // или добавляем новый элемент в конец
        Item.Assign(CurItem);
    // копируем исходный в новый
        CurItem.Free;
    // уничтожаем исходный
      end;
    end;

Для ListView2 установим ViewStyle = vsSmallIcon и покажем, как вручную
расставлять значки. В OnDragOver зададим условие

    Accept := (Sender = Source) and
        ([htOnLabel,htOnItem, htOnIcon] * ListView2.GetHitTestInfoAt(x, y) = []); 
    // пересечение множеств должно быть пустым - запрещаем накладывать элементы

а код в OnDragDrop очень простой:

    ListView2.Selected.SetPosition(Point(X,Y));

Перетаскивание в TreeView - довольно любопытная тема, здесь порой
приходится разрабатывать алгоритмы обхода ветвей для достижения
желаемого поведения. Для TreeView1 разрешим перестановку своих узлов в
другое положение. В OnDragOver проверим, не происходит ли перетаскивание
узла на свой же дочерний во избежание бесконечной рекурсии:

    var
      Node, SelNode: TTreeNode;
    begin
      Node := TreeView1.GetNodeAt(x, y);
    // находим узел-приемник
      Accept := (Sender = Source) and (Node <> nil);
      if not Accept then
        Exit;
      SelNode := Treeview1.Selected;
      while (Node.Parent <> nil) and (Node <> SelNode) do
      begin
        Node := Node.Parent;
        if Node = SelNode then
          Accept := False;
      end;

Код OnDragDrop выглядит так:

    var
      Node, SelNode: TTreeNode;
    begin
      Node := TreeView1.GetNodeAt(X, Y);
      if Node = nil then
        Exit;
      SelNode := TreeView1.Selected;
      SelNode.MoveTo(Node, naAddChild);
    // все уже встроено в TreeView
    end;

Теперь разрешим перенос в TreeView2 из TreeView1

    Accept := (Source = TreeView1) and (TreeView2.GetNodeAt(x, y) <> nil);

И в OnDragDrop копируем выбранную в TreeView1 ветвь во всеми подветвями,
для чего придется сделать рекурсивный обход:

    var
      Node: TTreeNode;
     
      procedure CopyNode(FromNode, ToNode: TTreeNode);
      var
        TempNode: TTreeNode;
        i: integer;
      begin
        TempNode := TreeView2.Items.AddChild(ToNode, '');
        TempNode.Assign(FromNode);
        for i := 0 to FromNode.Count - 1 do
          CopyNode(FromNode.Item[i], TempNode);
      end;
     
    begin
      Node := TreeView2.GetNodeAt(X, Y);
      if Node = nil then
        Exit;
      CopyNode(TreeView1.Selected, Node);
    end;

Рассмотрим теперь перенос ячеек в StringGrid1. Поскольку, как и в случае
с Memo, простое нажатие левой кнопки занято под другие действия,
установим DragMode = dmManual и будем запускать Drag при нажатии левой
кнопки, удерживая клавиши Alt или Ctrl. Запишем в OnMouseDown:

    var
      Acol, ARow: Integer;
    begin
      with StringGrid1 do
        if (ssAlt in Shift) or (ssCtrl in Shift) then
        begin
          MouseToCell(X, Y, Acol, Arow);
          if (Acol >= FixedCols) and (Arow >= FixedRows) then
    // не будем перетаскивать из фиксированных ячеек
          begin
            if ssAlt in Shift then
              Tag := 1
            else
              if ssCtrl in Shift then
                Tag := 2;
    // запомним что нажато - Alt или Ctrl -  в Tag StringGrid1
            BeginDrag(True)
          end
          else
            Tag := 0;
        end;
    end;

Код OnDragOver учитывает также возможность перетаскивания из StringGrid2
(описание ниже)

    var
      Acol, ARow: Integer;
    begin
      with StringGrid1 do
      begin
        MouseToCell(X, Y, Acol, Arow);
        Accept := (Acol >= FixedCols) and (Arow >= FixedRows)
          and (((Source = StringGrid1) and (Tag > 0))
          or (Source = StringGrid2));
      end;

Часть OnDragDrop, относящаяся к внутреннему переносу:

    var
      ACol, ARow, c, r: Integer;
      GR: TGridRect;
    begin
      StringGrid1.MouseToCell(X, Y, ACol, ARow);
      if Source = StringGrid1 then
        with StringGrid1 do
        begin
          Cells[Acol, Arow] := Cells[Col,Row];
    //копируем ячейку-источник в приемник
          if Tag = 1 then
            Cells[Col,Row] := '';
    // очищаем источник, если было нажато Alt
          Tag := 0;
        end;

А вот из StringGrid2 сделаем перенос выбранного диапазона ячеек с
помощью правой кнопки, для этого в OnMouseDown

    if Button = mbRight then StringGrid2.BeginDrag(True);

И теперь часть StringGrid1DragDrop, относящаяся к переносу из
StringGrid2:

    if Source = StringGrid2 then
      begin
        GR := StringGrid2.Selection;
    // Selection - выделенные в StringGrid2 ячейки
        for r := 0 to GR.Bottom - GR.Top do
          for c := 0 to GR.Right - GR.Left do
            if (ACol + c < StringGrid1.ColCount) and
              (ARow + r < StringGrid1.RowCount) then
    // застрахуемся от записи вне StringGrid1
              StringGrid1.Cells[ACol + c, ARow + r] :=
                StringGrid2.Cells[c + GR.Left, r + GR.Top];
      end;

Теперь покажем, как этот диапазон ячеек из StringGrid2 перенести в
Memo2. Для этого в OnDragOver Memo2 пишем:

    Accept := (Source = StringGrid2) or (Source = DBGrid1);

и в OnDragDrop Memo2:

    var
      c, r: integer;
      s: string;
    begin
      Memo2.Clear;
      if Source = StringGrid2 then
        with StringGrid2 do
          for r := Selection.Top to Selection.Bottom do
          begin
            s := '';
            for c := Selection.Left to Selection.Right do
              s := s + Cells[c, r] + #9;
    // разделим ячейки табуляцией
            memo2.lines.add(s);
          end

Кроме того, в Memo2 можно переносить выбранную запись из DBGrid1, у
которого установлено в Options dgRowSelect = True. В сетке отображается
таблица из стандартной поставки Delphi DBDEMOS - Animals.dbf.
Перетаскивание осуществляется аналогично StringGrid2, правой кнопкой
мыши, только по событию OnMouseMove

if ssRight in Shift then

   DBGrid1.BeginDrag(true);

Код в Memo2DragDrop, относящийся к переносу из DBGrid1:

else

   with DBGrid1.DataSource.DataSet do

   begin

     s := \'\';

     for c := 0 to FieldCount - 1 do

       s := s + Fields\[c\].AsString + \' \| \';

     memo2.lines.add(s);

   end;

// в случае dgRowSelect = False для переноса одного поля достаточно
сделать

// memo2.lines.add(DbGrid1.SelectedField.AsString);

Drag из DBGrid1 принимается также на Panel3, условие приема очевидно, а
OnDragDrop выглядит так:

Panel3.Height := 300;  // раскрываем панель

Image1.visible := True;

OleContainer1.Visible := false;

Image1.Picture.Assign(DBGrid1.DataSource.DataSet.FieldByName(\'BMP\'));

// показываем графическое поле текущей записи таблицы

Теперь покажу, как можно передвигать мышью визуальные компоненты в
Run-Time. Для Panel1 установим DragMode = dmAutomatic, в OnDragOver
формы пишем:

var

Ct: TControl;

begin

Ct := ControlAtPos(Point(X + Panel1.Width, Y + Panel1.Height), True,
True);

// для упрощения проверяем перекрытие с другими контролами только
правого нижнего угла

Accept := (Source = Panel1) and ((Ct = nil) or (Ct = Panel1));

и в OnDragDrop формы очень просто

Panel1.Left := X;

Panel1.Top := Y;

Другой метод перетаскивания можно встретить в каждом FAQ по Delphi:

procedure TForm1.Panel2MouseDown(Sender: TObject; Button: TMouseButton;

Shift: TShiftState; X, Y: Integer);

const

SC\_DragMove = $F012;

begin

ReleaseCapture;

Panel2.Perform(WM\_SysCommand, SC\_DragMove, 0);

end;

И в завершение реализация популярной задачи перетаскивания значков
файлов на форму из Проводника. Для этого следует описать обработчик
сообщения WM\_DROPFILES

private

procedure WMDropFiles(var Msg: TWMDropFiles); message WM\_DROPFILES;

В OnCreate формы разрешить прием файлов

DragAcceptFiles(Handle, true);

и в OnDestroy отключить его

DragAcceptFiles(Handle, False);

Процедура обработки приема файлов может выглядеть так:

procedure TForm1.WMDropFiles(var Msg: TWMDropFiles);

const

maxlen = 254;

var

h: THandle;

//i,num:integer;

pchr: array\[0..maxlen\] of char;

fname: string;

begin

h := Msg.Drop;

// дана реализация для одного файла, а

//если предполагается принимать группу файлов, то можно добавить:

//num:=DragQueryFile(h,Dword(-1),nil,0);

//for i:=0 to num-1 do begin

//  DragQueryFile(h,i,pchr,maxlen);

//...обработка каждого

//end;

DragQueryFile(h, 0, pchr, maxlen);

fname := string(pchr);

if lowercase(extractfileext(fname)) = \'.bmp\' then

begin

   Image1.visible := True;

   OleContainer1.Visible := false;

   image1.Picture.LoadFromFile(fname);

   Panel3.Height := 300;

end

else if lowercase(extractfileext(fname)) = \'.doc\' then

begin

   Image1.visible := False;

   OleContainer1.Visible := True;

   OleContainer1.CreateObjectFromFile(fname, false);

   Panel3.Height := 300;

end

else if lowercase(extractfileext(fname)) = \'.htm\' then

   ShellExecute(0, nil, pchr, nil, nil, 0)

else if lowercase(extractfileext(fname)) = \'.txt\' then

   Memo2.Lines.LoadFromFile(fname)

else

   Memo2.Lines.Add(fname);

DragFinish(h);

end;

При перетаскивании на форму файла с расширением Bmp он отображается в
Image1, находящемся на Panel3, Doc загружается в OleContainer, для Htm
запускается Internet Explorer или другой браузер по умолчанию, Txt
отображается в Memo2, а для остальных файлов в Memo2 будет просто
показано имя.

Полагаю, на основе содержащихся в статье приемов будет нетрудно
организовать перетаскивание и для других, не описанных здесь, визуальных
компонентов.

В заключение хочу выразить благодарность Игорю Шевченко и Максиму
Власову за ценные советы при подготовке примеров...

Автор статьи: Борис Новгородов, Новосибирск, 2002

Взято с сайта [www.emanual.ru](https://www.emanual.ru)
