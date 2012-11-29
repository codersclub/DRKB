Цвета в TDBGrid
===============

::: {.date}
01.01.2007
:::

    // Function to color a DBGrid (declared as private)
     
    procedure TForm1.ColorGrid(dbgIn: TDBGrid; qryIn: TQuery; const Rect: TRect;
      DataCol: Integer; Column: TColumn;
      State: TGridDrawState);
    var 
      iValue: LongInt;
    begin
      // color only the first field
      if (DataCol = 0) then
      begin
        // Check the field value and assign a color
        iValue := qryIn.FieldByName('HINWEIS_COLOR').AsInteger;
        case iValue of
          1: dbgIn.Canvas.Brush.Color := clGreen;
          2: dbgIn.Canvas.Brush.Color := clLime;
          3: dbgIn.Canvas.Brush.Color := clYellow;
          4: dbgIn.Canvas.Brush.Color := clRed;
        end;
        // Draw the field
        dbgIn.DefaultDrawColumnCell(Rect, DataCol, Column, State);
      end;
    end;
     
    procedure TForm1.DBGrid1DrawColumnCell(Sender: TObject;
      const Rect: TRect; DataCol: Integer; Column: TColumn; State: TGridDrawState);
    begin
      ColorGrid(DBGrid1, Query1, Rect, DataCol, Column, State);
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>

 

------------------------------------------------------------------------

С DBGrids это делается намного проще. Здесь мы будем использовать
событие \"OnDrawColumnCell\". Следующий пример разукрашивает ячейки
колонки \"Status\" когда значение НЕ равно \"a\". Если Вы хотите
закрасить целую линию, то достаточно удалить условие \"If\...\"
(смотрите ниже)

    procedure TForm1.DBGrid1DrawColumnCell(Sender: TObject; const Rect: TRect;
    DataCol: Integer; Column: TColumn; State: TGridDrawState);
    const
      clPaleGreen = TColor($CCFFCC);
      clPaleRed = TColor($CCCCFF);
    begin
      if Column.FieldName = 'Status' then //Удалите эту линию, если хотете закрасить целую линию
        if Column.Field.Dataset.FieldByName('Status').AsString <> 'a' then
          if (gdFocused in State) then //имеет ли ячейка фокус?
            DBGrid1.Сanvas.Brush.Color := clBlack //имеет фокус
          else
            DBGrid1.Сanvas.Brush.Color := clPaleGreen; //не имеет фокуса
     
      //Теперь давайте закрасим ячейку используя стандартный метод:
      DBGrid1.DefaultDrawColumnCell(Rect, DataCol, Column, State)
    end;

Вот и всё. Не правда ли красиво?

Фрагмент кода моей программы - в зависимости от значения в поле
taPlatAnswerType рисует строку белым цветом на красном фоне:

    procedure TfmMain.dgPlatDrawColumnCell(Sender: TObject; const Rect:
    TRect; DataCol: Integer; Column: TColumn; State: TGridDrawState);
    begin
      with dgPlat.Canvas do
      begin
        // Условие какую строку надо рисовать по другому
        if (taPlatAnswerType.AsString = 'b') and not (gdFocused in State) then
        begin
          Brush.Color := clRed;
          Font.Color := clWhite;
          FillRect(Rect);
          TextOut(Rect.Left, Rect.Top, Column.Field.Text);
        end
        else
          dgPlat.DefaultDrawColumnCell(Rect, DataCol, Column, State);
      end;
    end;

Взято с <https://delphiworld.narod.ru>

------------------------------------------------------------------------

Не знаю, помогу ли я Вам, но я расскажу как можно изменить цвет
отдельных ячеек GBGrid без необходимости создания нового компонента. Я
только что протестировал этот код\....

Я создал форму, поместил на ней компонент TTable и указал ему на таблицу
EMPLOYEE.DB в базе данных DBDEMOS. Затем я разместил на форме Datasource
и DBGrid, \"соединил\" их и получил живые данные.

Для демонстрации данной технологии я выбрал поле \"номер служащего\" в
таблице EMPLOYEE.DB и \"покрасил\" ячейки с нечетными числами. То есть,
если число нечетное, красим ячейку в зеленый цвет.

Единственный код расположился в обработчике события OnDrawColumnCell
компонента DBGrid и выглядел он так:

    procedure TForm1.DBGrid1DrawColumnCell(Sender: TObject; const Rect:
      TRect; DataCol: Integer; Column: TColumn; State: TGridDrawState);
    var
      holdColor: TColor;
    begin
      holdColor := DBGrid1.Canvas.Brush.Color; {сохраняем оригинальный цвет}
      {"раскрашиваем" ячейки только для поля EmpNo}
      if Column.FieldName = 'EmpNo' then
        if (Column.Field.AsInteger mod 2 <> 0) then
        begin
          DBGrid1.Canvas.Brush.Color := clGreen;
          DBGrid1.DefaultDrawColumnCell(Rect, DataCol, Column, State);
          DBGrid1.Canvas.Brush.Color := holdColor;
        end;
    end;

В данном случае мы использовали метод DefaultDrawColumnCell компонента
TCustomDBGrid, являющегося родителем для TDBGrid. Он раскрасил зеленым
цветом нечетные ячейки поля EmpNo.

Взято с <https://delphiworld.narod.ru>

------------------------------------------------------------------------

Есть ли какой-либо способ придать ячейке DBGrid другой цвет? Мне
хотелось бы выделить отдельные ячейки строки по определенному признаку.
Типа флага, который, если если счет просрочен свыше 90 дней, делает
строчку красной. Буду благодарен за любую помощь.

Обработайте событие OnDrawDataCell. Вот пример, который использует
демонстрационную таблицу COUNTRY и рисует текст красным цветом во всех
строках, содержащих страны с населением свыше 10 миллионов человек:

    begin
      if Table1.FieldByName('Population').AsFloat < 10000000 then
        DBGrid1.Canvas.Font.Color := clRed;
      dbGrid1.DefaultDrawDataCell(Rect,Field,State);
    end;

Взято с <https://delphiworld.narod.ru>
