---
Title: Drag & Drop для TListBox
Author: Александр Малыгин
Date: 01.01.2007
---


Drag & Drop для TListBox
========================

::: {.date}
01.01.2007
:::

Drag and Drop для TListBox на примере двойного списка

Автор: Александр Малыгин

Специально для Королевства Delphi

Типичная задача перетаскивания мышью объектов из одного контрола в
другой просто решается обработкой событий OnDragOver и OnDragDrop, при
установленных свойствах DragMode := dmAutomatic и DragKind := dkDrag у
всех участвующих компонентов.

Первый обработчик предназначен для принятия решения - допускается ли
сбросить объект в контрол, над которым находится мышь (параметр Sender),
и выставить соответствующий курсор. Для этого передается параметр
Source:TObject, представляющий собой тот компонент, с которого начали
перетаскивание (источник), координаты курсора X,Y:integer, состояние
процесса перетаскивания State:TDragState, и результат, который надо
вернуть var Accept:boolean.

Второй обработчик вызывается, когда пользователь отпускает кнопку мыши,
и контрол Sender:TObject должен отработать прием переданной ему
\"посылки\" Source:TObject, по координатам X,Y : integer.

Предлагаемый пример DualListFrame реализует операции drag\'n\'drop над
двумя списками TListBox, организованными в один фрейм с органами
управления. Прототипом послужил стандартный шаблон-форма \"Dual list
box\" из репозитория Delphi и аналогичный компонент-диалог из библиотеки
RxLib. Первый не снабжен функциями drag\'n\'drop, а второй хоть и умеет
это, но все равно является отдельным диалогом, что не всегда удобно.

Данный пример благодаря технологии фреймов позволяет встроить двойной
список \"со всеми причиндалами\" в любую форму проекта. Чтобы им
воспользоваться, достаточно подключить модуль DualListFrame.pas к
проекту. Для удобства при многократном использовании (в разных проектах)
можно добавить его в репозиторий, скопировав предварительно в общую для
шаблонов директорию (например, \"Delphi5\\ObjRepos\"). В архиве вместе с
кодом и ресурсом фрейма имеется пиктограмма для репозитория и вырезка из
файла \"Delphi5\\Bin\\delphi32.dro\".

Ниже приведены фрагменты исходного текста, ключевые для реализации
технологии \"тащи и бросай\".

    procedure TfrDualList.ListDragOver(Sender, Source: TObject; X,
      Y: Integer; State: TDragState; var Accept: Boolean);
    var
      DragIndex: integer;
    begin
      // из другого листбокса принимаем всегда
      if Source <> Sender then
        Accept := true
          // а если это мы сами - надо проверить возможность изменения порядка
        // в списке и позицию сбрасывания
      else
        with (Sender as TListBox) do
        begin
          Accept := False;
          if not Sorted and ((SelCount = 1) or (not MultiSelect)) then
          begin
            DragIndex := ItemAtPos(Point(X, Y), True);
            if (DragIndex >= 0) and (DragIndex <> ItemIndex) then
              Accept := True; // попали внутрь видимого списка
          end;
        end;
      // установка изображения курсора
      if State = dsDragLeave then
        (Source as TListBox).DragCursor := crDrag;
      if (State = dsDragEnter) and ((Source as TListBox).SelCount > 1) then
        (Source as TListBox).DragCursor := crMultiDrag;
    end;
     
    procedure TfrDualList.ListDragDrop(Sender, Source: TObject; X, Y: Integer);
    begin
      if Source <> Sender then // перемещаем элементы из другого листбокса
        MoveItems(TListBox(Source), TListBox(Sender))
      else
        BoxMoveSel(TListBox(Sender), // перемещаем элемент внутри списка
          TListBox(Sender).ItemAtPos(Point(X, Y), True));
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

Изменение позиций элементов ListBox с помощью Drag and Drop

    procedure TForm1.ListBox1DragDrop(Sender, Source: TObject; X, Y: Integer);
    begin
      with (Sender as TListBox) do
        Items.Move(ItemIndex,ItemAtPos(Point(x,y),True));
    end;
     
    procedure TForm1.ListBox1DragOver(Sender, Source: TObject; X, Y: Integer;
    State: TDragState; var Accept: Boolean);
    begin
      Accept := (Sender=Source);
    end;

Не забудьте в ListBox присвоить свойству DragMode значение dmAutomatic.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

Изменение позиций элементов ListBox с помощью Drag and Drop

Автор: Nick Hodges (Monterey, CA)

Я хотел бы изменить порядок следования элементов в неотсортированном
списке ListBox методом drag&drop, т.е. просто перетаскивая их мышью на
нужное место. Будет еще лучше, если при удержании кнопки мыши
перетаскиваемый элемент визуально перемещал бы вверх или вниз сам список
(для определения своего нового месторасположения) до тех пор, пока
клавиша мыши не будет отпущена (как я понял, автоматическое
скроллирование - В.О.).

Попробуйте для начала это:

    unit Draglb;
     
    interface
     
    uses
      SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
      Forms, Dialogs, StdCtrls;
     
    type
      TDragListBox = class(TListBox)
      private
        { Private declarations }
      protected
        { Protected declarations }
      public
        { Public declarations }
        procedure DragOver(Sender, Source: TObject; X, Y: Integer; State:
          TDragState; var Accept: Boolean);
        procedure DragDrop(Sender, Source: TObject; X, Y: Integer);
        constructor Create(AOwner: TComponent); override;
        { Published declarations }
      end;
     
    procedure Register;
     
    implementation
     
    procedure Register;
    begin
      RegisterComponents('Custom', [TDragListBox]);
    end;
     
    constructor TDragListBox.Create(AOwner: TComponent);
    begin
      inherited Create(AOwner);
      DragMode := dmAutomatic;
      OnDragDrop := DragDrop;
      OnDragOver := DragOver;
    end;
     
    procedure TDragListBox.DragOver(Sender, Source: TObject; X, Y: Integer;
      State: TDragState; var Accept: Boolean);
    begin
      Accept := Source = Self;
    end;
     
    procedure TDragListBox.DragDrop(Sender, Source: TObject; X, Y: Integer);
    var
      Value: Integer;
    begin
      if Sender = Self then
      begin
        Value := Self.ItemAtPos(Point(x, y), True);
     
        if Value = -1 then
        begin
          Self.Items.Add(Self.Items[Self.ItemIndex]);
          Self.Items.Delete(Self.ItemIndex);
        end
        else
        begin
          Self.Items.Insert(Value {+ 1}, Self.Items[Self.ItemIndex]);
          Self.Items.Delete(Self.ItemIndex);
        end;
      end;
    end;
     
    end.

Чтобы заставить элемент перемещаться в позицию каждого элемента, вам
необходимо сопоставлять область текущего элемента с текущим положения
курсора мыши. Для организации автоматического скроллирования также
необходимо вычислять текущие координаты курсора.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

Изменение позиций элементов ListBox с помощью Drag and Drop

Если вы хотите принимать перетаскиваемый объект, только если он
представляет собой собственный элемент, то в обработчике OnDragOver
вставьте строчку \"Accept := Source=Sender;\". Ниже приведен код,
позволяющий сортировать элементы с помощью перетаскивания их мышкой
внутри списка компонента. Вам также понадобится таймер для обеспечения
функции автопрокручивания. Это означает, что при перетаскивании элемента
в верхнюю часть списка, он при необходимости прокручивается вниз, дабы
стали видны невидимые в верхней части списка элементы. Если вам не нужно
такое поведение компонента, исключите из кода все строчки, имеющие
отношение к таймеру, включая вторую строчку в обработчике события
OnDragOver.

    ...
    private
      { Private declarations }
      GoingUp: Boolean;
     
    procedure TForm1.ListBox1DragOver(Sender, Source: TObject;
      X, Y: Integer; State: TDragState; var Accept: Boolean);
    begin
      Accept := (Sender = Source) and
        (TListBox(Sender).ItemAtPos(Point(X, Y), False) >= 0);
      {устанавливаем таймер для автопрокрутки}
      if Accept then
        with Sender as TListBox do
          if Y > Height - ItemHeight then
          begin
            GoingUp := False;
            Timer1.Enabled := True;
          end
          else if Y > ItemHeight then
          begin
            GoingUp := True;
            Timer1.Enabled := True;
          end
          else
            Timer1.Enabled := False;
    end;
     
    procedure TForm1.ListBox1DragDrop(Sender, Source: TObject;
      X, Y: Integer);
    var
      NuPos: Integer;
    begin
      with Sender as TListBox do
      begin
        NuPos := ItemAtPos(Point(X, Y), False);
        if NuPos >= Items.Count then
          Dec(NuPos);
        Label1.Caption := Format('Перемещено из %d в %d',
          [ItemIndex, NuPos]);
        Items.Move(ItemIndex, NuPos);
        {выделяем перемещенный элемент}
        ItemIndex := NuPos;
      end;
    end;
     
    procedure TForm1.Timer1Timer(Sender: TObject);
    begin
      with ListBox1 do
        if GoingUp then
          if TopIndex > 0 then
            TopIndex := TopIndex - 1
          else
            Timer1.Enabled := False
        else if TopIndex < Items.Count - 1 then
          TopIndex := TopIndex + 1
        else
          Timer1.Enabled := False;
    end;
     
    procedure TForm1.ListBox1EndDrag(Sender, Target: TObject;
      X, Y: Integer);
    begin
      Timer1.Enabled := False;
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

Изменение позиций элементов ListBox с помощью Drag and Drop

Автор: Peter Donnelly

Вот еще одна вариация сабжа.

    procedure TPickParty.PickListBMouseDown(Sender: TObject;
      Button: TMouseButton; Shift: TShiftState; X, Y: Integer);
    begin
      if Button = mbLeft then
        with Sender as TListBox do
        begin
          DraggedPM := ItemAtPos(Point(X, Y), True);
          if DraggedPM > l;
          = 0 then
            BeginDrag(False);
        end;
    end;
     
    procedure TPickParty.PickListBDragOver(Sender, Source: TObject; X,
      Y: Integer; State: TDragState; var Accept: Boolean);
    begin
      if Source = PickListB then
        Accept := True;
    end;
     
    procedure TPickParty.PickListBDragDrop(Sender, Source: TObject; X, Y: Integer);
    var
      NewIndex: integer;
    begin
      NewIndex := PickListB.ItemAtPos(Point(X, Y), False);
      if NewIndex > PickListB.Items.Count - 1 then
        NewIndex := PickListB.Items.Count - 1;
      PickListB.Items.Move(DraggedPM, NewIndex);
      PickListB.ItemIndex := NewIndex;
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

Drag and Drop между двумя компонентами ListBox

Вот пересмотренный OnDragDrop, использующий source (источник) и sender
(передатчик) вместо DstList и SrcList. Теперь, если вы установили
SrcList и DstList для использования тех же методов OnDragOver и
OnDragDrop и создали обработчик события OnDragDrop, то для операции Drag
and Drop вы можете использовать оба решения.

    procedure TDualListDlg.DstListDragDrop(Sender, Source: TObject; X,
      Y: Integer);
    var
      droppedOnIndex: integer;
      anItem: integer;
      numberOfItems: integer;
    begin
      if (Sender is TListbox) and (Source is TListBox) then
      begin
        droppedOnIndex := TListBox(Sender).ItemAtPos(Point(X, Y), false);
        numberOfItems := TListBox(Source).SelCount;
        anItem := 0;
        while numberOfItems > 0 do
        begin
          if TListBox(Source).Selected[anItem] = true then
          begin
            TListBox(Sender).Items.Insert(droppedOnIndex,
              TListBox(Source).Items[anItem]);
            TListBox(Source).Items.Delete(anItem);
            TListBox(Source).Update;
            TListBox(Sender).Update;
            numberOfItems := numberOfItems - 1;
          end
          else
            anItem := anItem + 1;
        end;
      end;
    end;

Для того, чтобы предотвратить операцию Drag and Drop с одним и тем же
компонентом, используйте следующий код в обработчике события OnDragOver:

    if (Sender is TListBox) and (Source is TListBox) then
    begin
      if TListBox(Sender).Name = TListBox(Source).Name then
        Accept := False
      else
        Accept := true;
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

Drag and Drop - как использовать ItemAtPos для получения элемента
DirListBox

Просто сохраните результат функции ItematPos в переменной формы, и затем
используйте эту переменную в обработчике ListBoxDragDrop. Пример:

    FDragItem := ItematPos(X, Y, True);
    if FDragItem >= 0 then
      BeginDrag(false);
    ...
     
    procedure TForm1.ListBoxDragDrop(Sender, Source: TObject; X, Y: Integer);
    begin
      if Source is TDirectoryListBox then
        ListBox.Items.Add(TDirectoryListBox(Source).GetItemPath(FDragItem));
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
