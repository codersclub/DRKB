<h1>Примеры работы с MS Excel</h1>
<div class="date">01.01.2007</div>


<p>в секции uses стоит так ExcelXP,{Excel2000, Excel97} крайней мере у меня, т.к. некоторые параметры при работе с разными версиями отличаются, например при открытии файла в версии XP больше параметров, чем в версии `97.</p>
<p>На форме лежит компонента Ex1 типа TExcelApplication со страницы Servers, свойства AutoConnect и AutoQuit :=False, свойство ConnectKind:=ckRunningOrNew,</p>
<pre>
uses ...
ExcelXP, OleServer, ComObj, ...
 
{
Ex1 - TExcelApplication со страницы Servers
dm - TDataModule
tArrivalDet, tPreparats, tArrival - TpFibDataBase
считаю, что такие функции, как DelProb или FindPreparat не требуется сюда выкладывать, т.к. у всех своя специфика, тем
более, что они никакого отношения не имеют к импорт из Excel
}
procedure TfmImpFromExcel.ImportArrivalFromExcel(FileName: String);
Var
 WorkBk : _WorkBook; //  определяем WorkBook
 WorkSheet : _WorkSheet; //  определяем WorkSheet
 Range:OleVariant;
 iUnitID,iUnit, iAmount, iTerm,iPrepID, iSeries, iStop, iProd, iPrice, RowsToCopy, iLastRow, iWBIndex, x, iBook, iNameRow : integer;
 sInvoiceNum, sUnitCol, sAmountCol, sTermCol, sProdCol, sPriceCol, sNameCol, sSeriesCol, sFileName : String;
 bNaydeno7, bNaydeno6, bNaydeno5, bNaydeno4, bNaydeno2, bNaydeno1, bNaydeno, bNaydeno3 : boolean;
 vPrep:variant;
 НайденоВБазе, НеНайденоВБазе:integer;
 Препарат, Производитель, Серия, Единица: String;
 ЦенабНДС,НДС, ЦенаСНДС : real;
 ArrivalID : integer;
begin
  sFileName := '';
  screen.Cursor := crHourGlass;
  try
    sInvoiceNum := AnsiUpperCase(ExtractFileName(FileName));
    sInvoiceNum := Copy(sInvoiceNum, 1, pos('.XLS',sInvoiceNum)-1);
    fmNewArrival.edInvoice_num.Text := sInvoiceNum;
    dm.tPreparats.DisableControls;
    dm.tPreparats.AutoCommit := false;
 
    if not dm.tArrivalDet.active then
      dm.tArrivalDet.Open;
 
    dm.tArrivalDet.DisableControls;
    dm.tArrivalDet.AutoCommit := False;
 
    dm.tArrivalDet.BeforeInsert := nil;
    dm.tArrivalDet.AfterPost    := nil;
 
    НеНайденоВБазе := 0;
    НайденоВБазе := 0;
    try//попытка открытия файла
      Ex1.Connect;
      Ex1.Workbooks.Open(FileName,EmptyParam,EmptyParam,EmptyParam,EmptyParam,
          EmptyParam,EmptyParam,EmptyParam,EmptyParam,EmptyParam, EmptyParam,EmptyParam,
          EmptyParam,EmptyParam,EmptyParam, LOCALE_USER_DEFAULT);
      Ex1.Application.EnableEvents := false;
     except;//в случае ошибки все отменяем и обнуляем
       screen.Cursor:=crDefault;
       RowsToCopy := 0;
       exit;
     end;//try-except Ex1.Connect
 
     sFileName := ExtractFileName(FileName);
     For iWBIndex := 1 to ex1.Workbooks.Count do
       if ex1.Workbooks.Item[iWBIndex].Name = sFileName then break;
     WorkBk := ex1.WorkBooks.Item[iWBIndex];   // Выбираем WorkBook
 
   // Определяем WorkSheet
   if WorkBk.Worksheets.Count&gt;1 then
   begin//если кол-во листов больше 1
     For x:=0 to memoSheets.Lines.Count-1 do
     begin
      For iBook:=1 to WorkBk.Worksheets.Count do
      begin
        WorkSheet:=WorkBk.WorkSheets.Get_Item(iBook) as _WorkSheet;
        if WorkSheet.Name = memoSheets.Lines[x] then
        begin
          bNaydeno3:=True;//нашли лист
          WorkSheet.Activate(LOCALE_USER_DEFAULT);//активираем лист
        end;//if WorkSheet.Name = memoSheets.Lines[x] then begin
        if bNaydeno3 then break;
      end;//For iBook:=1 to WorkBk.Worksheets.Count do begin
      if bNaydeno3 then break;
     end;//For x:=0 to memoSheets.Lines.Count-1 do begin
     //если не находим лист из списка ключевых слов, выдаем сообщение
     if not bNaydeno3 then
     begin
         beep;
         ShowMessage('&lt;Не найден лист с данными&gt;'+#13+#13+
         '1.Откройте прайс, посмотрите название листа с препаратами, добавьте в'+#13+
         'ключевые слова название листа с препаратами и повторите импорт'+#13+
         '___________________________________________________________________________________'+#13+
         '2.Откройте прайс, выберите лист с препаратами, затем выберите меню "Файл-&gt;Сохранить и закройте Excel"');
 
         exit;
     end;//if bNaydeno3=false then begin
   end else//if
     WorkSheet:=WorkBk.WorkSheets.Get_Item(1) as _WorkSheet;;
 
   StatusBar1.Panels[0].Text:='Поиск последней строки...';
   application.ProcessMessages;
   if Find('99999',iNameRow, sNameCol, WorkSheet) then
     begin
       iLastRow:=iNameRow-1;//в столбце с наименованием ищем "99999"-конец импорта
     end
   else
     begin     //и запоминаем в iRows
      try//если не находим 99999 то ищем последнюю заполненную ячейку
        WorkSheet.Cells.SpecialCells(xlCellTypeLastCell,EmptyParam).Activate;
        // Получаем значение последней строки
        iLastRow:=(ex1.ActiveCell.Row)-1;
       except
         try
           WorkSheet.Cells.SpecialCells(xlCellTypeLastCell,EmptyParam).Select;
           // Получаем значение последней строки
           iLastRow:=(ex1.ActiveCell.Row);
         except
           iLastRow:=0;
         end;//try-except
       end;//try-except
     end;//else
 
   if iLastRow=0 then
   begin
     memoErrors.Lines.Add(TimeToStr(Time)+' Не найден признак окончания данных, импортируем 6000 строк');
     iLastRow:=6000;
   end;//if iRows=0 then begin
 
   //показываем кол-во строк для копирования
   memoErrors.Lines.Add(TimeToStr(Time)+' Записей для импорта '+IntToStr(RowsToCopy));
 
//ищем наименование препаратов
   For x:=0 to memoName.Lines.Count-1 do
   begin
     bNaydeno:=False;
     if Find(memoName.Lines[x],iNameRow,sNameCol,WorkSheet) then begin
      bNaydeno:=True;
      //количество строк для копирования
      RowsToCopy := iLastRow - iNameRow;
      break;
     end;//if Find(memoNames.Lines[r],iNameRow,sNameCol) then begin
   end;//For r:=0 to memoNames.Lines.Count-1 do begin
 
   if not bNaydeno then
   begin
     beep;
     ShowMessage('&lt;Не найден столбец с наименованиями&gt;'+#13+#13+
         '1.Откройте прайс, посмотрите название столбца с наименованиями,'+#13+
         'добавьте в ключевые слова название этого столбца и повторите импорт'+#13+
         '-----------------------------------------------------------------------------'+#13+
         '2.Откройте прайс, выберите лист с препаратами, затем выберите меню "Файл-&gt;Сохранить"');
     memoErrors.Lines.Add(TimeToStr(Time)+' Не найден столбец с производителем препаратов.');
     memoErrors.Lines.Add(TimeToStr(Time)+' Импорт завершен неудачно');
     memoErrors.Lines.Add('___________________________________________');
     exit;
   end;//if bNaydeno2=False then begin
 
//ищем серию препаратов
   For x:=0 to memoSeries.Lines.Count-1 do
   begin
     bNaydeno4:=False;
     if Find(memoSeries.Lines[x],iSeries,sSeriesCol,WorkSheet) then
     begin
      bNaydeno4:=True;
      break;
     end;
   end;
 
   if not bNaydeno4 then
   begin
     beep;
     ShowMessage('&lt;Не найден столбец с сериями препаратов&gt;'+#13+#13+
         '1.Откройте прайс, посмотрите название столбца с сериями препаратов, добавьте в'+#13+
         'ключевые слова название этого столбца и повторите импорт.'+#13+
         '___________________________________________________________________________________'+#13+
         '2.Откройте прайс, выберите лист с препаратами, затем выберите меню "Файл-&gt;Сохранить"');
     memoErrors.Lines.Add(TimeToStr(Time)+' Не найден столбец с сериями препаратов.');
     memoErrors.Lines.Add(TimeToStr(Time)+' Импорт завершен неудачно');
     memoErrors.Lines.Add('___________________________________________');
     exit;
   end;
 
//ищем Ед. изм препаратов
   For x:=0 to memoUnits.Lines.Count-1 do
   begin
     bNaydeno7:=False;
     if Find(memoUnits.Lines[x],iUnit,sUnitCol,WorkSheet) then
     begin
      bNaydeno7:=True;
      break;
     end;
   end;
 
   if not bNaydeno7 then
   begin
     beep;
     ShowMessage('&lt;Не найден столбец с единицами измерений&gt;'+#13+#13+
         '1.Откройте прайс, посмотрите название столбца с ед.изм., добавьте в'+#13+
         'ключевые слова название этого столбца и повторите импорт.'+#13+
         '___________________________________________________________________________________'+#13+
         '2.Откройте прайс, выберите лист с препаратами, затем выберите меню "Файл-&gt;Сохранить"');
     memoErrors.Lines.Add(TimeToStr(Time)+' Не найден столбец с сериями препаратов.');
     memoErrors.Lines.Add(TimeToStr(Time)+' Импорт завершен неудачно');
     memoErrors.Lines.Add('___________________________________________');
     exit;
   end;
 
//ищем цену препаратов
   For x:=0 to memoPrice.lines.Count-1 do
   begin
     bNaydeno1:=False;
     if Find(memoPrice.lines[x],iPrice,sPriceCol,WorkSheet) then begin
      bNaydeno1:=True;
      break;
     end;//if Find(memoPrices.lines[r],iPriceRow,sPriceCol) then begin
   end;//For r:=0 to memoPrices.lines.Count-1 do begin
   if not bNaydeno1 then
   begin
     beep;
     ShowMessage('&lt;Не найден столбец с ценами препаратов&gt;'+#13+#13+
         '1.Откройте прайс, посмотрите название столбца с ценами препаратов, добавьте в'+#13+
         'ключевые слова название этого столбца и повторите импорт.'+#13+
         '___________________________________________________________________________________'+#13+
         '2.Откройте прайс, выберите лист с препаратами, затем выберите меню "Файл-&gt;Сохранить"');
     memoErrors.Lines.Add(TimeToStr(Time)+' Не найден столбец с ценами препаратов.');
     memoErrors.Lines.Add(TimeToStr(Time)+' Импорт завершен неудачно');
     memoErrors.Lines.Add('___________________________________________');
     exit;
   end;//if bNaydeno1=false then begin
 
//ищем количество
   For x:=0 to memoAmount.lines.Count-1 do
   begin
     bNaydeno6:=False;
     if Find(memoAmount.lines[x],iAmount,sAmountCol,WorkSheet) then begin
      bNaydeno6:=True;
      break;
     end;//if Find(memoPrices.lines[r],iPriceRow,sPriceCol) then begin
   end;//For r:=0 to memoPrices.lines.Count-1 do begin
   if not bNaydeno6 then
   begin
     beep;
     ShowMessage('&lt;Не найден столбец "количество"&gt;'+#13+#13+
         '1.Откройте прайс, посмотрите название столбца с количеством, добавьте в'+#13+
         'ключевые слова название этого столбца и повторите импорт.'+#13+
         '___________________________________________________________________________________'+#13+
         '2.Откройте прайс, выберите лист с препаратами, затем выберите меню "Файл-&gt;Сохранить"');
     memoErrors.Lines.Add(TimeToStr(Time)+' Не найден столбец "количество".');
     memoErrors.Lines.Add(TimeToStr(Time)+' Импорт завершен неудачно');
     memoErrors.Lines.Add('___________________________________________');
     exit;
   end;//if bNaydeno1=false then begin
 
 
//ищем производителя препаратов
   For x:=0 to memoProducer.Lines.Count-1 do
   begin
     bNaydeno2:=False;
     if Find(memoProducer.Lines[x],iProd,sProdCol,WorkSheet) then begin
      bNaydeno2:=True;
      break;
     end;//if Find(memoProd.Lines[r],iProdRow,sProdCol) then begin
   end;//For r:=0 to memoProd.Lines.Count-1 do begin
   if not bNaydeno2 then
   begin
     beep;
     ShowMessage('&lt;Не найден столбец с наименованиями производителей&gt;'+#13+#13+
         '1.Откройте прайс, посмотрите название столбца с наименованиями производителей,'+#13+
         'добавьте в ключевые слова название этого столбца и повторите импорт'+#13+
         '-----------------------------------------------------------------------------'+#13+
         '2.Откройте прайс, выберите лист с препаратами, затем выберите меню "Файл-&gt;Сохранить"');
     memoErrors.Lines.Add(TimeToStr(Time)+' Не найден столбец с производителем препаратов.');
     memoErrors.Lines.Add(TimeToStr(Time)+' Импорт завершен неудачно');
     memoErrors.Lines.Add('___________________________________________');
     exit;
   end;//if bNaydeno2=False then begin
 
 
//ищем срок годности препаратов
   For x:=0 to memoTerm.Lines.Count-1 do
   begin
     bNaydeno5:=False;
     if Find(memoTerm.Lines[x],iTerm,sTermCol,WorkSheet) then begin
      bNaydeno5:=True;
      break;
     end;//if Find(memoProd.Lines[r],iProdRow,sProdCol) then begin
   end;//For r:=0 to memoProd.Lines.Count-1 do begin
   if not bNaydeno5 then
   begin
     beep;
     ShowMessage('&lt;Не найден столбец со сроком годности препаратов&gt;'+#13+#13+
         '1.Откройте прайс, посмотрите название столбца со сроком годности,'+#13+
         'добавьте в ключевые слова название этого столбца и повторите импорт'+#13+
         '-----------------------------------------------------------------------------'+#13+
         '2.Откройте прайс, выберите лист с препаратами, затем выберите меню "Файл-&gt;Сохранить"');
     memoErrors.Lines.Add(TimeToStr(Time)+' Не найден столбец со сроком годности препаратов.');
     memoErrors.Lines.Add(TimeToStr(Time)+' Импорт завершен неудачно');
     memoErrors.Lines.Add('___________________________________________');
     exit;
   end;//if bNaydeno2=False then begin
 
 
   pb1.Max:=RowsToCopy;
   StatusBar1.Panels[0].Text:='Импорт начат...';
   application.ProcessMessages;
   iStop := 0;
//начинаем импорт со строки iNameRow
 
//начинаем импорт со строки iNameRow
    Inc(iNameRow);
    For x:=0 to RowsToCopy do
    with dm do
    begin
      Препарат      := Trim(VarToStr(WorkSheet.Cells.Item[iNameRow,sNameCol].Value));
      if (POS('ОТПУЩЕНО',AnsiUpperCase(Препарат)) &lt;&gt; 0) or
         (POS('ВСЕГО',AnsiUpperCase(Препарат)) &lt;&gt; 0) or
         (POS('ОПЛАТА',AnsiUpperCase(Препарат)) &lt;&gt; 0) or
         (Препарат = '')
      then continue;
 
      Серия         := Trim(VarToStr(WorkSheet.Cells.Item[iNameRow,sSeriesCol].Value));
      Производитель := Trim(VarToStr(WorkSheet.Cells.Item[iNameRow,sProdCol].Value));
      Единица       := Trim(VarToStr(WorkSheet.Cells.Item[iNameRow,sUnitCol].Value));
      if Единица = '' then Единица := 'шт';
 
 
      if cbWithVAT.Checked then begin
        ЦенабНДС := StrToFloatDef(DelProb(VarToStr(WorkSheet.Cells.Item[iNameRow,sPriceCol].Value)),0);
        НДС      := (ЦенабНДС * 1.2)-ЦенабНДС;
        ЦенаСНДС := ЦенабНДС + НДС;
      end else begin//без НДС
        ЦенабНДС := StrToFloatDef(DelProb(VarToStr(WorkSheet.Cells.Item[iNameRow,sPriceCol].Value)),0);
        НДС      := 0.00;
        ЦенаСНДС := ЦенабНДС;
      end;
 
      if (Препарат = '') or (Препарат = ' ')
      then
       Inc(iStop)//если пустая строка, то увеличиваем на 1
      else
       iStop := 0;//если следующая не пустая то обнуляем и продолжаем импорт
      //если начались пустые строки то прекращаем импорт
      if iStop &gt; 4 then break;
 
      //наименование препарата сначала нужно найти в справочнике препаратов
      iPrepID := -1;
 
      ArrivalID := tArrivalID.Value;
 
      if (tArrival.state = dsEdit) or (tArrival.state = dsInsert) then begin
        tArrival.post;
        tArrival.locate('ID', ArrivalID, []);
        tArrival.edit;
      end;
 
      if FindPreparat(Препарат, Производитель, iPrepID)
      then
        begin//если нашли, то у нас есть его ID, т.е. iPrepID
          //добавляем в приход
          Inc(НайденоВБазе);
 
          tArrivalDet.Append;
          tArrivalDetARRIVAL_ID.Value     := ArrivalID;
          tArrivalDetPREPARAT_ID.Value    := iPrepID;
          tArrivalDetPRICE_WO_NDS.AsFloat := ЦенаБНДС;
          tArrivalDetPRICE_W_VAT.AsFloat  := ЦенаСНДС;
          tArrivalDetVAT.AsFloat          := НДС;
          tArrivalDetPRICE_RETAIL.AsFloat := RoundPrice(RoundTo(ЦенаСНДС * fmNewArrival.ceCoeff.Value,-2));
          tArrivalDetAMOUNT.Value         := StrToFloatDef(DelProb(VarToStr(WorkSheet.Cells.Item[iNameRow,sAmountCol].Value)),0);
          tArrivalDetSERIES.AsString      := Серия;
          tArrivalDetUNIT_ID.Value      := FindUnit(Единица);
 
          tArrivalDet.Post;
        end
      else
        begin//добавляем в справочник препаратов новый препарат
          Inc(НеНайденоВБазе);
          tPreparats.Append;
              iPrepID := tPreparatsID.Value;
              tPreparatsNAME.Value            := Препарат;
              tPreparatsPRODUCER.Value        := Производитель;
              tPreparatsSERIES.Value          := Серия;
              tPreparatsPRICE_RETAIL.AsFloat  := RoundPrice(RoundTo(ЦенаСНДС * fmNewArrival.ceCoeff.Value,-2));
              tPreparatsPRICE_WO_VAT.AsFloat  := ЦенаСНДС;
              tPreparatsTERM.Value            := Trim(VarToStr(WorkSheet.Cells.Item[iNameRow,sTermCol].Value));
              tPreparatsUNIT_ID.Value      := FindUnit(Единица);
 
              tPreparats.Post;
 
          //а теперь добавляем его в приход
          tArrivalDet.Append;
          tArrivalDetARRIVAL_ID.Value     := tArrivalID.Value;
          tArrivalDetPREPARAT_ID.Value    := iPrepID;
          tArrivalDetUNIT_ID.Value        := FindUnit(Единица);
          tArrivalDetPRICE_WO_NDS.AsFloat := ЦенаБНДС;
          tArrivalDetPRICE_W_VAT.AsFloat  := ЦенаСНДС;
          tArrivalDetVAT.AsFloat          := НДС;
          tArrivalDetPRICE_RETAIL.AsFloat := RoundPrice(RoundTo(ЦенаСНДС * fmNewArrival.ceCoeff.Value,-2));
          tArrivalDetAMOUNT.Value         := StrToFloatDef(DelProb(VarToStr(WorkSheet.Cells.Item[iNameRow,sAmountCol].Value)),0);
          tArrivalDetUNIT_ID.Value      := FindUnit(Единица);
          tArrivalDetSERIES.AsString      := Серия;
          tArrivalDet.Post;
        end;
 
        Inc(iNameRow);
        pb1.Position := x;
        application.ProcessMessages;
        if bAbort then  Break;
 
    end;//For e:=0 to RowsToCopy do begin
 
 
  finally
    memoErrors.Lines.Add('Завершение импорта...');
    dm.tPreparats.EnableControls;
    dm.tArrivalDet.EnableControls;
 
    dm.tArrivalDet.BeforeInsert := dm.tArrivalDetBeforeInsert;
    dm.tArrivalDet.AfterPost    := dm.tArrivalDetAfterPost;
 
 
    if dm.tArrivalDet.UpdateTransaction.InTransaction then dm.tArrivalDet.UpdateTransaction.Commit;
    if DM.tPreparats.UpdateTransaction.InTransaction then DM.tPreparats.UpdateTransaction.Commit;
 
    dm.tArrivalDet.AutoCommit := true;
    DM.tPreparats.AutoCommit := true;
 
    memoErrors.Lines.Add('Найдено в справочнике препаратов: '+IntToStr(НайденоВБазе));
    memoErrors.Lines.Add('Добавлено новых в справочник препаратов: '+IntToStr(НеНайденоВБазе));
    memoErrors.Lines.Add('Импорт завершен');
    StatusBar1.Panels[0].Text := 'Импорт завершен';
    Screen.Cursor := crDefault;
  end;
end;
</pre>

<pre>
Function TfmImpExcel.Find(sText:String;Var iRow:Integer;Var sCol:String;WorkSheetF:_WorkSheet):Bool;
Var
UsedRange, Range: OLEVariant;
t,y:Integer;//вспомогат для импорта
FirstAddress: string;
begin //поиск начали
Result:=False;
UsedRange := WorkSheetF.Range['A1','Z5000'];//диапазон поиска, напрмер от 'F25' до 'G30'
Range := UsedRange.Find(What:=sText, LookIn := xlValues, LookAt := xlWhole,SearchDirection := xlNext);
if not VarIsClear(Range) then begin
  try
    FirstAddress := Range.Address;
    //вычисляем номер строки из полученного адреса(абсолютные координаты)
    //он начинается после второго значка доллара
    //формат найденной строки,что-то типа $A$2 (абсолютные координаты)
    t:=PosEx('$',FirstAddress,2);
    iRow:=StrToInt(Copy(FirstAddress,t+1,length(FirstAddress)-t));
    //вычисляем номер столбца из полученного адреса(абсолютные координаты)
    //буква начинается со второго символа
    y:=PosEx('$',FirstAddress,2);
    sCol:=Copy(FirstAddress,2,y-2);
    Result:=true;
    VarClear(Range);
    VarClear(UsedRange);
  except
    Result:=False;
  end;//try-except
end;//if
end;
</pre>

<p>Еще несколько примеров, используя Ole</p>
<p>Excel:Variant - глобальная переменная</p>
<pre>
...
begin
//вначале проверяем, не открыт ли Excel  и закрываем
if not VarIsEmpty(Excel) then begin
 Excel.Quit;
 Excel := Unassigned;
end;//if
 
   Try//открываем Excel и создаем раб.книгу
     Excel:=CreateOleObject('Excel.Application');
     /кол-во листов в новой книге
     Excel.SheetsInNewWorkbook:=1;//
     //добавляем раб.книгу
     Excel.WorkBooks.Add;
     //в переменную "загоняем" текущий лист
     Sheets:=Excel.Workbooks[1].Sheets[1];
   Except
     SysUtils.beep;
     ShowMessage('Не могу открыть Excel!');
     Exit;
   end;//try-except
 
   //рисуем border
//сначала определяем диапазон
   Range:=Sheets.Range['B1'];
   Range.Borders[4].LineStyle := 1;//Range.Borders[4] - можно ставить от 1 до 8 - точно не мпомню
 
     //рисуем border вокруг ячейки (обрамление)
     Range.Borders[1].LineStyle := 1;
     Range.Borders[2].LineStyle := 1;
     Range.Borders[3].LineStyle := 1;
     Range.Borders[4].LineStyle := 1;
 
   //присваиваем значение яцейке
   Sheets.Cells[2,2]:=Edit1.Text;// формат Sheets.Cells[№ строки,№ колонки]
   //так выполняем выравнивание в диапазоне
   //присваиваем диапазону координаты ячейки
   Range:=Sheets.Cells[2,2];//можно переменные Range:=Sheets.Cells[iRow,iCol];
   Range.HorizontalAlignment := xlCenter;
   Range.VerticalAlignment := xlCenter;
   //форматируем шрифт
   Sheets.Cells[iRow,3]:='ЗАЯВКА';
   Range:=Sheets.Cells[iRow,3];
   Range.Font.Bold:=True;
 
//с присваиванием значения ячейке могут быть проблемы, т.к. Excel думает, что он очень умный
//и вместо числа может переформатировать в дату вида 12дек2004, что бы такого не случилось, 
//можно заранее отформатировать ячейку в нужный формат (дата, число, валюта, текстовый)
//все форматы можно узнать в Excel`е, с пом. макросов, просмотрев затем код, созданный самим
//Excel`ем
//#,##0.000$ - денежный
//[$-FC19]dd mmmm yyyy г/;@ - дата
//h:mm;@ - время
//0.00% - проценты
//# ??/?? - простые дроби 21/25
//[&lt;=9999999]###-####;(###) ###-#### - номер телефона
//@ - текстовый формат, если указывать такой формат и присваивать
//числовое значение, а затем складывать, то ничего не выйдет
 
//передаваемая строки из Delphi может отличаться, нужно эксперементировать
tZay - TTable
dbGridZay - DBGrid
vRow - integer
   while not tZay.Eof do begin
     For iColCount:=0 to dbGridZay.Columns.Count-1 do begin
       Range:=Sheets.Cells[vRow,iColCount+1];
       Case tZay.FieldByName(dbGridZay.Columns[iColCount].FieldName).DataType of
         ftFloat   : begin
                       Range.NumberFormat := '0,000';
                       Sheets.Cells[vRow,iColCount+1]:=
                       tZay.FieldByName(dbGridZay.Columns[iColCount].FieldName).AsFloat
                     end;
         ftString  : begin
                       Range.NumberFormat := '@';
                       Sheets.Cells[vRow,iColCount+1]:=
                       tZay.FieldByName(dbGridZay.Columns[iColCount].FieldName).AsString;
                     end;
         ftInteger : begin
                       Range.NumberFormat := '0';
                       Sheets.Cells[vRow,iColCount+1]:=
                       tZay.FieldByName(dbGridZay.Columns[iColCount].FieldName).AsInteger;
                     end;
         ftAutoinc : begin
                       Range.NumberFormat := '0';
                       Sheets.Cells[vRow,iColCount+1]:=
                       tZay.FieldByName(dbGridZay.Columns[iColCount].FieldName).AsInteger;
                     end;
 
         ftDate    : begin
                       Range.NumberFormat := '@';
                       dDate:=tZay.FieldByName(dbGridZay.Columns[iColCount].FieldName).AsDateTime;
                       Sheets.Cells[vRow,iColCount+1]:=FormatDateTime('dd.mm.yyyy',dDate);
                     end
       else
         Range.NumberFormat := '@';
         Sheets.Cells[vRow,iColCount+1]:=
         tZay.FieldByName(dbGridZay.Columns[iColCount].FieldName).AsString;
       end;//case-else
</pre>

<p>удаляем лишние столбцы (по умолчанию со сдвигом влево)</p>
<pre>
dbGridZay - DBGrid
   For iColCount:= dbGridZay.Columns.Count-1 downto 0 do begin
     if dbGridZay.Columns[iColCount].Visible=False then begin
       UsedRange := Sheets.Range['A1','Z100'];//диапазон поиска заголовка
       Range := UsedRange.Find(What:=dbGridZay.Columns[iColCount].title.Caption, LookIn := xlValues, LookAt := xlWhole,SearchDirection := xlNext);
       if not VarIsEmpty(Range) then begin
         try
           FirstAddress := Range.Address;
           s:=StringReplace(FirstAddress,'$','',[rfReplaceAll]);
           [b]Range:=Sheets.Range[s+':'+Copy(s,1,1)+IntToStr(vRow)];[/b]
           [b]Range.Delete;[/b]
         except
 
         end;//try
       end;//if not VarIsEmpty(Range)then begin
     end;//if dbGridZay.Columns[iColCount].Visible=False then begin
   end;//for delete
 
 
//Объединение ячеек
Sheet.Range[...].Merge(Across)
</pre>

<p>Относительно LOCALE_USER_DEFAULT</p>
<p>Теоретически, в MSDN написано: "Indicates that the parameter is a locale ID (LCID)". Одни (Чарльз Калверт) предлагают в качестве его использовать 0, как идентификатор языка по умолчанию, другие - результат функции GetUserDefaultLCID. В некоторых случаях, чаще в связке Windows 2000 + Excel 2000, оба решения не проходят. Причем, выдается сообщение о попытке "использовать библиотеку старого формата..." Поэтому, рекомендуем в качестве lcid использовать значение константы LOCALE_USER_DEFAULT.</p>
<p>Относительно открытия существующих рабочих книг</p>
<p>Вот как описан метод Open в импортированной библиотеке типов: </p>
<p>function Open(const Filename: WideString; UpdateLinks: OleVariant; ReadOnly: OleVariant; </p>
<p>Format: OleVariant; Password: OleVariant; WriteResPassword: OleVariant; </p>
<p>IgnoreReadOnlyRecommended: OleVariant; Origin: OleVariant;</p>
<p>Delimiter: OleVariant; Editable: OleVariant; Notify: OleVariant;</p>
<p>Converter: OleVariant; AddToMru: OleVariant; lcid: Integer): Workbook; safecall;</p>
<p>Что вам из всего этого может понадобиться:</p>
<p>· FileName</p>
<p>Имя открываемого файла, желательно с полным путем, иначе Excel будет искать этот файл в каталоге по умолчанию; </p>
<p>· AddToMru</p>
<p>True - если необходимо запомнить файл в списке последних открытых файлов; </p>
<p>· IgnoreReadOnlyRecommended</p>
<p>Если файл рекомендован только для чтения, то при открытии Excel выдает соответствующее предупреждение. Чтобы его игнорировать, передайте в качестве данного параметра True. </p>
<p>Используя позднее связывание</p>
<p>При позднем связывании не нужно указывать все дополнительные параметры или LCID, можно просто написать вот так: </p>
<p>var </p>
<p>Workbook: OLEVariant; </p>
<p>... </p>
<p>Workbook := Excel.WorkBooks.Open('C:\Test.xls'); </p>
<p class="note">Примечание:</p>
<p>Если вы хотите получше узнать метод Open, например, как с его помощью открывать файлы текстовых форматов с разделителями, воспользуйтесь "пишущим" плеером VBA. Запишите макросы, а затем поправьте их по необходимости. </p>
<p>Создание новой книги</p>
<p>Используя раннее связывание</p>
<p>var </p>
<p>IWorkbook: Excel8_TLB._Workbook; </p>
<p>... </p>
<p>IWorkbook := IExcel.Workbooks.Add(EmptyParam, xlLCID); </p>
<p>Передача в качестве первого параметра EmptyParam означает, что будет создана новая книга с количеством пустых листов, выставленным по умолчанию. Если в первом параметре вы передадите имя файла (с полным путем, иначе поиск осуществляется в каталоге по умолчанию), этот файл будет использован как шаблон для новой книги. Вы можете также передать одну из следующих констант: xlWBATChart, xlWBATExcel4IntlMacroSheet, xlWBATExcel4MacroSheet, или xlWBATWorksheet. В результате будет создана новая книга с единственным листом указанного типа. </p>
<p>Внимание - важно!</p>
<p>Excel не может держать открытыми несколько книг с одинаковыми названиями, даже если они лежат в разных каталогах, поэтому при создании файла по шаблону добавляет к имени файла новой книги номер (шаблон "test.xls" - новый файл "test1.xls"). </p>
<p>Закрытие книги</p>
<p>Используя раннее связывание</p>
<p>var </p>
<p>SaveChanges: boolean; </p>
<p>... </p>
<p>SaveChanges := True;</p>
<p>IWorkbook.Close(SaveChanges, EmptyParam, EmptyParam, xlLCID); </p>
<p>Если в качестве параметра SaveChanges вы передадите EmptyParam, Excel задаст вопрос, сохранять ли рабочую книгу. Второй параметр позволяет вам определить имя файла, а третий указывает, нужно ли отправлять книгу следующему получателю. </p>
<p>Используя позднее связывание</p>
<p>При позднем связывании нет необходимости указывать дополнительные параметры, поэтому вы можете просто написать:</p>
<p>Workbook.Close(SaveChanges := True);</p>
<p>или</p>
<p>Workbook.Close;</p>
<p>Как передать абсолютный адрес ячейки? </p>
<p>Нужно использовать символ $ - Лист1!$A$1:$D$3'</p>
<p>Так можно добавить новый модуль:</p>
<p>var </p>
<p>IModule: VBIDE8_TLB.VBComponent; //с эти нужно поэксперементировать</p>
<p>... </p>
<p>IModule := IWorkbook.VBProject.VBComponents.Add( TOLEEnum(VBIDE8_TLB.vbext_ct_StdModule) );</p>
<p>IModule.Name :='MyModule1'; </p>
<p>,поместить в него новую процедуру VBA:</p>
<p>IModule.CodeModule.AddFromString('PUBLIC SUB MySub1()'#13'Msgbox "Hello, World!"'#13'End sub'#13); </p>
<p>и запустить эту процедуру</p>
<p>OLEVariant(Excel).Run('MyModule1.MySub1'); </p>
<p>Различные способы обращения к ячейкам</p>
<pre>
Var
Value:Variant;
...
try 
//различные способы
Value := ISheet.Cells.Item[2, 1].Value;
Value := ISheet.Range['A2', EmptyParam].Value;
Value := ISheet.Range['TestCell', EmptyParam].Value;
Value := IWorkbook.Names.Item('TestCell', EmptyParam, EmptyParam).RefersToRange.Value;
finally 
ISheet := nil; 
end;
</pre>

<p>Копирование данных в буфер обмена</p>
<pre>
var 
ISheetSrc, ISheetDst: Worksheet;//в разных версиях
IRangeSrc, IRangeDst: Range; //могут объявляться по разному
...
IRangeSrc.Copy(IRangeDst);
</pre>

<p>Метод Copy интерфейса Range принимает в качестве параметра любой другой Range, совпадение размеров источника и получателя необязательно. </p>
<p>При копировании области убедитесь, что не редактируете ячейку, иначе возникнет исключение "Call was rejected by callee".</p>
<p>Использование метода Copy без указания параметра destination скопирует ячейки в буфер обмена. </p>
<p class="author">Автор: Akella</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
