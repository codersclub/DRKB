---
Title: Сортировка TDBGrid по клику на колонке?
Author: Nomadic
Date: 01.01.2007
---


Сортировка TDBGrid по клику на колонке?
=======================================

Вариант 1.

На форме расположены TQuery, TDatasource и TDbGrid связанные вместе.

QuerySQL, это глобальная строка, которая содержит SQL-выражение.

    begin 
      QuerySQL := 'SELECT * FROM Customer.DB'; 
      Query1.SQL.Add(QuerySQL); 
      Query1.Open; 
    end; 

В DBGrid в событии OnTitleClick, достаточно добавить ORDER-BY к
sql-строке и обновить запрос.

    procedure TForm1.DBGrid1TitleClick(Column: TColumn); 
    begin 
      witzh Query1 do 
      begin 
        DisableControls; 
        Close; 
        SQL.Clear; 
        SQL.Add(QuerySQL); 
        SQL.Add('ORDER BY ' + Column.FieldName); 
        Open; 
        // Восстанавливаем настройки заголовка, иначе всё станет синим
        DBGrid1.Columns.RestoreDefaults; 
        Column.Title.Font.Color := clBlue; 
        EnableControls; 
      end; 
    end; 

Source: <https://forum.sources.ru>

------------------------------------------------------------------------

Вариант 2.

Кyсочек кода, чтобы повесить на clickable столбец RxGrid, показывающий
RxQuery с опpеделенным макpосом %Order. Работать не бyдет (без модyлей),
но в качестве идеи может быть полезен.

    unit vgRXutil;
     
    interface
     
    uses
      SysUtils, Classes, DB, DBTables, rxLookup, RxQuery;
     
    { TrxDBLookup }
    procedure RefreshRXLookup(Lookup: TrxLookupControl);
    procedure RefreshRXLookupLookupSource(Lookup: TrxLookupControl);
     
    function RxLookupValueInteger(Lookup: TrxLookupControl): Integer;
     
    { TRxQuery }
     
    { Applicatable to SQL's without SELECT * syntax }
     
    { Inserts FieldName into first position in '%Order' macro and refreshes query }
    procedure HandleOrderMacro(Query: TRxQuery; Field: TField);
     
    { Sets '%Order' macro, if defined, and refreshes query }
    procedure InsertOrderBy(Query: TRxQuery; NewOrder: string);
     
    { Converts list of order fields if defined and refreshes query }
    procedure UpdateOrderFields(Query: TQuery; OrderFields: TStrings);
     
    implementation
    uses
      vgUtils, vgDBUtl, vgBDEUtl;
     
    { TrxDBLookup refresh }
     
    type
      TRXLookupControlHack = class(TrxLookupControl)
        property DataSource;
        property LookupSource;
        property Value;
        property EmptyValue;
      end;
     
    procedure RefreshRXLookup(Lookup: TrxLookupControl);
    var
      SaveField: string;
    begin
      with TRXLookupControlHack(Lookup) do
      begin
        SaveField := DataField;
        DataField := '';
        DataField := SaveField;
      end;
    end;
     
    procedure RefreshRXLookupLookupSource(Lookup: TrxLookupControl);
    var
      SaveField: string;
    begin
      with TRXLookupControlHack(Lookup) do
      begin
        SaveField := LookupDisplay;
        LookupDisplay := '';
        LookupDisplay := SaveField;
      end;
    end;
     
    function RxLookupValueInteger(Lookup: TrxLookupControl): Integer;
    begin
      with TRXLookupControlHack(Lookup) do
      try
        if Value <> EmptyValue then
          Result := StrToInt(Value)
        else
          Result := 0;
      except
        Result := 0;
      end;
    end;
     
    procedure InsertOrderBy(Query: TRxQuery; NewOrder: string);
    var
      Param: TParam;
      OldActive: Boolean;
      OldOrder: string;
      Bmk: TPKBookMark;
    begin
      Param := FindParam(Query.Macros, 'Order');
      if not Assigned(Param) then
        Exit;
     
      OldOrder := Param.AsString;
     
      if OldOrder <> NewOrder then
      begin
        OldActive := Query.Active;
        if OldActive then
          Bmk := GetPKBookmark(Query, '');
        try
          Query.Close;
          Param.AsString := NewOrder;
          try
            Query.Prepare;
          except
            Param.AsString := OldOrder;
          end;
          Query.Active := OldActive;
          if OldActive then
            SetToPKBookMark(Query, Bmk);
        finally
          if OldActive then
            FreePKBookmark(Bmk);
        end;
      end;
    end;
     
    procedure UpdateOrderFields(Query: TQuery; OrderFields: TStrings);
    var
      NewOrderFields: TStrings;
     
      procedure AddOrderField(S: string);
      begin
        if NewOrderFields.IndexOf(S) < 0 then
          NewOrderFields.Add(S);
      end;
     
    var
      I, J: Integer;
      Field: TField;
      FieldDef: TFieldDef;
      S: string;
    begin
      NewOrderFields := TStringList.Create;
      with Query do
      try
        for I := 0 to OrderFields.Count - 1 do
        begin
          S := OrderFields[I];
          Field := FindField(S);
          if Assigned(Field) and (Field.FieldNo > 0) then
            AddOrderField(IntToStr(Field.FieldNo))
          else
          try
            J := StrToInt(S);
            if J < FieldDefs.Count then
              AddOrderField(IntToStr(J));
          except
          end;
        end;
        OrderFields.Assign(NewOrderFields);
      finally
        NewOrderFields.Free;
      end;
    end;
     
    procedure HandleOrderMacro(Query: TRxQuery; Field: TField);
    var
      Param: TParam;
      Tmp, OldOrder, NewOrder: string;
      I: Integer;
      C: Char;
      TmpField: TField;
      OrderFields: TStrings;
    begin
      Param := FindParam(Query.Macros, 'Order');
      if not Assigned(Param) or Field.Calculated or Field.Lookup then
        Exit;
      OldOrder := Param.AsString;
      I := 0;
      Tmp := '';
      OrderFields := TStringList.Create;
      try
        OrderFields.Ad(Field.FieldName);
        while I < Length(OldOrder) do
        begin
          Inc(I);
          C := OldOrder[I];
          if C in FieldNameChars then
            Tmp := Tmp + C;
     
          if (not (C in FieldNameChars) or (I = Length(OldOrder))) and (Tmp <> '')
            then
          begin
            TmpField := Field.DataSet.FindField(Tmp);
            if OrderFields.IndexOf(Tmp) < 0 then
              OrderFields.Add(Tmp);
            Tmp := '';
          end;
        end;
     
        UpdateOrderFields(Query, OrderFields);
        NewOrder := OrderFields[0];
        for I := 1 to OrderFields.Count - 1 do
          NewOrder := NewOrder + ', ' + OrderFields[1];
      finally
        OrderFields.Free;
      end;
      InsertOrderBy(Query, NewOrder);
    end;
     
    end.

Author: Nomadic

Source: <https://delphiworld.narod.ru>

------------------------------------------------------------------------

Вариант 3.

Многие профессиональные приложения отображают данные в полях табличной
сетки и позволяют Вам сортировать любую колонку, просто щелкая по ее
заголовку. То, что здесь изложено - не наилучший путь для решения
задачи, данная технология ничто иное, как простая имитация такого
поведения компонента.

Главное препятствие в решении задачи - сам DBGrid. Проблема в отсутствии
событий OnClick или OnMouseDown, позволяющие реагировать на элементарные
манипуляции с заголовком. Правда, существует событие OnDoubleClick, но
для данной цели оно не слишком изящно. Все что нам нужно - сделать
заголовок, реагирующий на однократный щелчок мышью. Обратимся к
компоненту THeaderControl.

THeaderControl - компонент, введенный в палитру еще в Delphi 2.0 и
обеспечивающий необходимые нам функции. Главное достоинство - реакция
компонента при щелчке на отдельных панелях, панели также обеспечивают
визульное отображение подобно кнопке (могут вдавливаться и отжиматься).
Нам необходимо "прикрутить" THeaderControl к DBGrid. Вот как это
сделать:

Во-первых, создайте новое приложение. Положите THeaderControl на форму.
Он автоматически выровняется по верхнему краю формы. Затем поместите на
форму DBGrid и присвойте свойству Align значение alClient. Затем
добавьте компоненты TTable и TDataSource. В компоненте TTable присвойте
свойству DatabaseName значение DBDEMOS, а свойству TableName значение
EVENTS.DB. В TDataSource укажите в свойстве DataSet на компонент Table1,
а в TDBGrid в свойстве DataSource на DataSource1. Если свойство Active
компонента TTable было неактивно, включите его (значение True). Теперь
немного поколдуем!

Сделаем так, чтобы компонент THeaderControl выглядел похожим на
заголовок компонента DBGrid. Произведем необходимые манипулиции в момент
создания формы. Дважды щелкните на событии OnCreate формы и введите
следующий код:

    procedure TForm1.FormCreate(Sender: TObject);
    var
      TheCap: string;
      TheWidth, a: Integer;
    begin
      DBGrid1.Options := DBGrid1.Options - [dgTitles];
      HeaderControl1.Sections.Add;
      HeaderControl1.Sections.Items[0].Width := 12;
      Table1.Exclusive := True;
      Table1.Active := True;
      for a := 1 to DBGrid1.Columns.Count do
      begin
        with DBGrid1.Columns.Items[a - 1] do
        begin
          TheCap := Title.Caption;
          TheWidth := Width;
        end;
        with HeaderControl1.Sections do
        begin
          Add;
          Items[a].Text := TheCap;
          Items[a].Width := TheWidth + 1;
          Items[a].MinWidth := TheWidth + 1;
          Items[a].MaxWidth := TheWidth + 1;
        end;
        try
          Table1.AddIndex(TheCap, TheCap, []);
        except
          HeaderControl1.Sections.Items[a].AllowClick := False;
        end;
      end;
      Table1.Active := False;
      Table1.Exclusive := False;
      Table1.Active := True;
    end;

После того как THeaderControl заменил стандартный заголовок DBGrid, в
первую очередь мы сбрасываем (устанавливаем в False) флаг dgTitles в
свойстве Options компонента DBGrid. Затем мы добавляем колонку в
HeaderControl и устанавливаем ее ширину, равную 12. Это будет пустой
колонкой, которая имеет ту же ширину, что и левая колонка статуса в
DBGrid.

Затем нужно убедиться что таблица открыта для эксклюзивного доступа
(никакие другие пользователи использовать ее не смогут). Причину я
объясню немного позже.

Теперь добавляем секции в HeaderControl. Для каждой добавленной колонки
мы создаем в заголовке тот же текст, что и в соответствующей колонке
DBGrid. В цикле мы проходим по всем колонкам DBGrid и повторяем текст
заголовка колонки и его высоту. Мы также устанавливаем для HeaderControl
значения свойств MinWidth и MaxWidth, равными ширине соответствующей
колонки в DBGrid. Это предохранит колонки от изменения их ширины. Для
изменяющих размер колонок нужно дополнительное кодирование, и я решил не
лишать Вас этого удовольствия.

Теперь самое интересное. Мы собираемся создать индекс для каждой колонки
в DBGrid. Имя индекса будет таким же, как и название колонки. Данный код
мы должны заключить в конструкцию try..finally, поскольку существуют
некоторые поля, которые не могут быть проиндексированы (например, Blob-
и Memo-поля). При попытке индексации этих полей генерится исключительная
ситуация. Мы перехватываем это исключение и недопускаем возможности
щелчка на данной колонке. Это означает, что колонки, содержащие
неиндексированные поля, не будут реагировать на щелчок мышью. Создание
этих индексов служит объяснением тому, почему таблица должна быть
открыта в режиме эксклюзивного доступа. И в заключение мы закрываем
таблицу, сбрасываем флаг эксклюзивности и снова делаем таблицу активной.

Последний шаг. При щелчке на HeaderControl нам необходимо включить
правильный индекс таблицы. Создадим обработчик события OnSectionClick
компонента HeaderControl как показано ниже:

    procedure TForm1.HeaderControl1SectionClick(
    HeaderControl: THeaderControl; Section: THeaderSection);
    begin
      Table1.IndexName := Section.Text;
    end;

Это все! После щелчка на заголовке колонки значение свойства таблицы
IndexName становится равным заголовку компонента HeaderControl.

Просто и красиво, да? Тем не менее есть масса мест, требующих улучшения.
К примеру, вторичный щелчок должен возобновлять порядок сортировки. Или
возможность изменения размера самих колонок. Попробуйте сами, это не
сложно!

**Улучшения**

Здесь приведен улучшенный код по сравнению с предыдущей версией
"Совета", он заключается в использовании в качестве имени индекса имя
поля вместо заголовка.

Это улучшает гибкость. Изменения указаны наклонным курсивом.

    procedure TfrmDoc.FormCreate(Sender: TObject);
    var
      TheCap: string;
      TheFn: string;
      TheWidth: Integer;
      a: Integer;
    begin
      Dbgrid1.Options := DBGrid1.Options - [DGTitles];
      Headercontrol1.sections.Add;
      Headercontrol1.Sections.Items[0].Width := 12;
      for a := 1 to DBGRID1.Columns.Count do
      begin
        with DBGrid1.Columns.Items[a - 1] do
        begin
          TheFn := FieldName;
          TheCap := Title.Caption;
          TheWidth := Width;
        end;
        with Headercontrol1.Sections do
        begin
          Add;
          Items[a].Text := TheCap;
          Items[a].Width := TheWidth + 1;
          Items[a].MinWidth := TheWidth + 1;
          Items[a].MaxWidth := TheWidth + 1;
        end; 
        try
          { Используем индексы с тем же именем, что и имя поля }
          (DataSource1.Dataset as TTable).IndexName := TheFn;
            { Пробуем задать имя индекса }
        except
          HeaderControl1.Sections.Items[a].AllowClick := False; { Индекс недоступен }
        end; 
      end; 
    end; 

Используйте свойство FieldName компонента DBGrid для задания индекса с
тем же именем, что и имя поля.

    procedure TfrmDoc.HeaderControl1SectionClick(HeaderControl:
    THeaderControl; Section: THeaderSection);
    begin
      (DataSource1.Dataset as TTable).IndexName :=
      DBGrid1.Columns.Items[ Section.Index - 1 ].FieldName;
    end;

Source: <https://delphiworld.narod.ru>
