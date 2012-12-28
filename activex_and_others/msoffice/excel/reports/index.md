---
Title: Создание отчетов в Excel
Author: SeaGirl
Date: 01.01.2007
---


Создание отчетов в Excel
========================

::: {.date}
01.01.2007
:::

    XL:=CreateOLEObject('Excel.Application');
    XL.Workbooks.Open('D:\Program Files\Borland\Delphi7\Projects\ppp\reports\Пенсионеры.xls');
    Sheet:=XL.Workbooks[1].workSheets[1];
    Sheet.Name:='';
    sheet.Cells[2,3].Font.Italic:=true;
    sheet.Cells[2,3].Font.Name:='Times New Roman';
    sheet.Cells[2,3].HorizontalAlignment:=1;
    sheet.Cells[2,3].Font.Size:=12;
    sheet.Cells[2,3]:=' ';
 
    sheet.Cells[4,3].Font.Bold:=true;
    sheet.Cells[4,3].Font.Italic:=true;
    sheet.Cells[4,3].Font.Size:=12;
    sheet.Cells[4,3].Font.Name:='Times New Roman';
    sheet.Cells[4,3]:=' '+Self.DBLookupComboboxEh2.Text+'    '+Self.DBLookupComboboxEh3.Text;
 
    sheet.Cells[Q4.RecordCount+9,2]:=''+ inttostr(Q4.RecordCount);
    //В 8 строке шапка таблицы. Чтобы выводить ее на каждой странице отчета пишем так 
    Sheet.PageSetup.PrintTitleRows:='$8:$8';
 
    XL.Visible:=true;
    XL:=UnAssigned;

Взято из <https://forum.sources.ru>

Автор: SeaGirl

------------------------------------------------------------------------

              if open_excel then
                begin
                  for i:=1 to ExcelApplication1.Worksheets.Count do
                    begin
                      ExcelWorksheet2.ConnectTo(ExcelApplication1.Worksheets.item[i] as excelworksheet);
                      if ExcelWorksheet2.Name=datetostr(DateTimePicker1.Date) then
                        begin
                          exsist:=true;
                          it:=i;
                        end;
                    end;
                  if exsist then //уже есть такой лист
                    ExcelWorksheet1.ConnectTo(ExcelApplication1.Worksheets.item[it] as excelworksheet)
                  else
                    begin
                      ExcelApplication1.Worksheets.add(EmptyParam, ExcelApplication1.Worksheets.item[ExcelApplication1.Worksheets.Count] as excelworksheet, EmptyParam, EmptyParam, 1);
                      ExcelWorksheet1.ConnectTo(ExcelApplication1.Activesheet as excelworksheet);
                      ExcelWorksheet1.Name:=datetostr(DateTimePicker1.Date);
                    end;
                  // Координаты левого верхнего угла области,
                  //в которую будем выводить данные
                  Range1:=ExcelWorksheet1.Range['A1', emptyparam];
                  i:=1;
                  j:=1;
                  ind_cell:=1;
                  while j<>1 do
                    begin
                      if Range1.value = null then
                        begin
                          Range2:=ExcelWorksheet1.Range['A'+inttostr(i+1), emptyparam];
                          if Range2.value = null then
                            begin
                               Range_empty:=Range2;
                                  Break;
                            end
                          else
                            begin
                              i:=i+1;
                              Range1:=ExcelWorksheet1.Range['A'+inttostr(i), emptyparam];
                            end
                        end
                      else
                        begin
                          i:=i+1;
                          Range1:=ExcelWorksheet1.Range['A'+inttostr(i), emptyparam];
                        end
                    end;
                  //copy(ExcelWorksheet1.Range['A2', emptyparam], 1, 1);
                  //range_temp:=ExcelWorksheet1.Range['A2', emptyparam];
                  ind_cell:=i; //индекс первого пустого
                  if (ind_cell=2) or (ind_cell=1) then //до этого ничего не введено
                    N_zagot:=1
                  else
                    begin
                      i:=2;
                      Range1:=ExcelWorksheet1.Range['A2', emptyparam];
                      //s:=copy(Range_empty.name, 1, 1);
                      //ShowMessage(s);
                      while i <= ind_cell do
                        begin
                          if copy(range1.value, 1, 9)='Заготовка' then
                            n_zagot:=strtoint(copy(range1.value, 12, length(range1.value)-12));
                          i:=i+1;
                          Range1:=ExcelWorksheet1.Range['A'+inttostr(i), emptyparam];
                        end;
                    end;
                //ExcelWorksheet1.Range['A1', emptyparam].Value:='ttt';
                  for i:=0 to length(intervals)-1 do
                    begin
                    //ExcelWorksheet1.Range['A2', emptyparam].Columns.AutoFit;
                      ExcelWorksheet1.Range['A'+inttostr(ind_cell+1), emptyparam].Value:='Время';
                      ExcelWorksheet1.Range['A'+inttostr(ind_cell+2), emptyparam].Value:='Температура';
                      for j:=0 to length(points[i])-1 do
                        begin
                          if j+2<25 then s:=numb_letters[j+2]
                          else
                            s:=numb_letters[(j+2) div 25]+numb_letters[j+2 mod 25];
                          s1:=datetimetostr(times[i, j]);
                          delete(s1, 1, 11);
                          //temp:=pos(',', ExcelWorksheet1.Range[s+inttostr(ind_cell+1), emptyparam].Value);
                          //delete(s1, temp, 1);
                          //insert('.', s1, temp);
                          with  ExcelWorksheet1.Range[s+inttostr(ind_cell+1), emptyparam] do
                            begin
                              Value:=s1;
                              Orientation:=90;
                            end;
                          with  ExcelWorksheet1.Range[s+inttostr(ind_cell+2), emptyparam] do
                            begin
                              Value:=points[i, j];
                              Orientation:=90;
                            end;
                          ExcelWorksheet1.Columns.AutoFit;
                          //ExcelWorksheet1.Rows('4:4'):=45;
                        end;
                      ExcelWorksheet1.Range['A'+inttostr(ind_cell), emptyparam].Value:='Заготовка №'+inttostr(n_zagot);
                      with ExcelWorksheet1.Range['A'+inttostr(ind_cell), s+inttostr(ind_cell)] do
                        begin
                          MergeCells := False;
                          Merge(emptyparam);
                          HorizontalAlignment := xlCenter;
                          Font.Italic := True;
                          Font.Bold:=true;
                          Font.Name:='Times New Roman';
                          Font.Size:=14;
                        end;
                      with ExcelWorksheet1.Range['A'+inttostr(ind_cell+1), s+inttostr(ind_cell+2)] do
                        begin
                          Borders.LineStyle := xlContinuous;
                          Font.Name:='Times New Roman';
                          Font.Size:=12;
                        end;
                      ExcelApplication1.Charts.Add(emptyparam, ExcelWorksheet1.DefaultInterface, 1, emptyparam, 1);
                      ExcelApplication1.ActiveChart.ChartType:=xlLine;
                      ExcelApplication1.ActiveChart.SetSourceData(ExcelWorksheet1.Range['A'+inttostr(ind_cell+1), s+inttostr(ind_cell+2)], xlRows);
                      ExcelApplication1.ActiveChart.Location(xlLocationAsObject, excelworksheet1.Name);
                      with ExcelWorksheet1.Shapes.Item((ExcelWorksheet1.ChartObjects as ChartObjects).Count) do begin
                        begin
                          Top := ExcelWorksheet1.Range['A1', 'A'+inttostr(ind_cell+2)].Height + 8;
                          Left := 0;
                          Width := ExcelWorksheet1.Range['A'+inttostr(ind_cell+1), s+inttostr(ind_cell+1)].Width;
                          Height :=  ExcelWorksheet1.Range['A'+inttostr(ind_cell+3), 'A'+inttostr(ind_cell+14)].Height;
                        end;
                      with ExcelApplication1.ActiveChart do
                        begin // украшательства диаграммы
                          with (Axes(xlCategory, xlPrimary, 1) as Axis) do
                            begin
                              HasTitle := True;
                              AxisTitle.Characters[EmptyParam, EmptyParam].Text := 'Время';
                            end;
                          with (Axes(xlValue, xlPrimary, 1) as Axis) do
                            begin
                              HasTitle := true;
                              AxisTitle.Characters[EmptyParam, EmptyParam].Text := 'температура';
                            end;
                          with (Axes(xlCategory, xlPrimary, 1) as Axis) do
                            begin
                              HasMajorGridlines := false;
                              HasMinorGridlines := false;
                            end;
                          with (Axes(xlValue, xlPrimary, 1) as Axis) do
                            begin
                              MinimumScale:=500;
                              HasMajorGridlines := true;
                              HasMinorGridlines := False;
                            end;
                          (SeriesCollection(1,1) as Series).Border.ColorIndex:=7;
                          (SeriesCollection(1,1) as Series).Border.Weight:=xlMedium;
                        end;
                    //end;
                      ExcelWorksheet1.Range['B'+inttostr(ind_cell+16), emptyparam].Value:='Время прогрева = '+floattostr(intervals[i])+' c';
                      ExcelWorksheet1.Range['B'+inttostr(ind_cell+16), 'F'+inttostr(ind_cell+16)].MergeCells:=false;
                      ExcelWorksheet1.Range['B'+inttostr(ind_cell+16), 'G'+inttostr(ind_cell+16)].Merge(emptyparam);
                      N_zagot:=N_zagot+1;
                      ind_cell:=ind_cell+17;
                    end;
                  ExcelWorksheet1.PageSetup.CenterHeader:='Контрольный график температур при изготовлении партии деталей '+datetostr(DateTimePicker1.Date)+' №________________';
                  // Делаем Excel видимым
                  ExcelApplication1.Visible[1] := true;
                end; //open_excel=true

Это такая сборная салянка из того, что я нашла в инете, вычитала из книг
и узнала с помощью макросов excel. Но должна сказать - не все макросы
работают при переводе их в Object Pascal.

Например:

Код макроса на VB:

Изменение высоты конкретной строки

    Rows("4:4").RowHeight = 46.5

И так это выглядит на OP:

    ExcelWorksheet1.Range['A'+inttostr(ind_cell+1),emptyparam].Select;
    Range1:=ExcelRange( ExcelApplication1.Selection[0]);
    Range1.RowHeight:=60;

И еще изменение Font колонтитулов

На VB:

    With ActiveSheet.PageSetup
        .CenterHeader = "&""Times New Roman,полужирный""&16Колонтитул"
    End With


А на OP так не получается, а как именно делать, я еще не додумалась.

Попробуй так:

    XLApp.WorkBooks[1].WorkSheets[i].Rows[k].RowHeight := 25;

Взято из <https://forum.sources.ru>
