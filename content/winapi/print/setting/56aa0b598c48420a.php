<h1>Как получить информацию о заданиях на принтере?</h1>
<div class="date">01.01.2007</div>


<p>В Windows существуют встроенные средства для мониторинга заданий на принтере. Однако, давайте разберёмся, как отслеживать задания на принтере программно. Для существует API функция "EnumJobs", которая позволяет получить давольно много информации о текущем состоянии принтера (Имя задания, Состояние, дату, время и т.д.).</p>

<p>Ниже представлена функция, которая использует EnumJobs и возвращает массив структуры, в котором представлена вся необходимая информация:</p>

<pre>
uses WinSpool;
 
type
  JOB_INFO_1_ARRAY = array of JOB_INFO_1;
 
  function GetSpoolerJobs(sPrinterName: string): JOB_INFO_1_ARRAY;
 
var
  i: Integer;
  hPrinter: THandle;
  bResult: Boolean;
  cbBuf: DWORD;
  pcbNeeded: DWORD;
  pcReturned: DWORD;
  aJobs: array[0..99] of JOB_INFO_1;
begin
  cbBuf := 1000;
 
  bResult := OpenPrinter(PChar(sPrinterName), hPrinter, nil);
  if not bResult then
  begin
    ShowMessage('Error opening the printer');
    exit;
  end;
 
  bResult := EnumJobs(hPrinter, 0, Length(aJobs), 1, @aJobs, cbBuf, pcbNeeded,
    pcReturned);
  if not bResult then
  begin
    ShowMessage('Error Getting Jobs information');
    exit;
  end;
 
  ClosePrinter(hPrinter);
 
  for i := 0 to pcReturned - 1 do
  begin
    if aJobs[i].pDocument &lt;&gt; nil then
    begin
      SetLength(Result, Length(Result) + 1);
      Result[Length(Result) - 1] := aJobs[i];
    end;
  end;
end;
</pre>


<p>Пример использования:</p>

<p>Создайте новый проект со StringGrid и Timer.</p>
<p>В StringGrid установите свойства "ColCount" и "RowCount" в 20.</p>
<p>У таймера (Timer) установите свойство "Interval" в 500.</p>
<p>В обработчик события "OnTime" таймера добавьте следующий код:</p>

<pre>
procedure TForm1.Timer1Timer(Sender: TObject);
var
  i, ii: Integer;
  aJobs: JOB_INFO_1_ARRAY;
begin
  for i := 0 to StringGrid1.ColCount - 1 do
    for ii := 0 to StringGrid1.RowCount - 1 do
      StringGrid1.Cells[i, ii] := '';
 
  aJobs := GetSpoolerJobs('HP LaserJet 6L PCL');
 
  for i := 0 to Length(aJobs) - 1 do
  begin
    StringGrid1.Cells[i, 0] := aJobs[i].pPrinterName;
    StringGrid1.Cells[i, 1] := aJobs[i].pMachineName;
    StringGrid1.Cells[i, 2] := aJobs[i].pUserName;
    StringGrid1.Cells[i, 3] := aJobs[i].pDocument;
    StringGrid1.Cells[i, 4] := aJobs[i].pDatatype;
    StringGrid1.Cells[i, 5] := aJobs[i].pStatus;
    StringGrid1.Cells[i, 6] := IntToStr(aJobs[i].Status);
 
    case aJobs[i].Status of
      JOB_STATUS_PAUSED: StringGrid1.Cells[i, 6] := 'JOB_STATUS_PAUSED';
      JOB_STATUS_ERROR: StringGrid1.Cells[i, 6] := 'JOB_STATUS_ERROR';
      JOB_STATUS_DELETING: StringGrid1.Cells[i, 6] := 'JOB_STATUS_DELETING';
      JOB_STATUS_SPOOLING: StringGrid1.Cells[i, 6] := 'JOB_STATUS_SPOOLING';
      JOB_STATUS_PRINTING: StringGrid1.Cells[i, 6] := 'JOB_STATUS_PRINTING';
      JOB_STATUS_OFFLINE: StringGrid1.Cells[i, 6] := 'JOB_STATUS_OFFLINE';
      JOB_STATUS_PAPEROUT: StringGrid1.Cells[i, 6] := 'JOB_STATUS_PAPEROUT';
      JOB_STATUS_PRINTED: StringGrid1.Cells[i, 6] := 'JOB_STATUS_PRINTED';
      JOB_STATUS_DELETED: StringGrid1.Cells[i, 6] := 'JOB_STATUS_DELETED';
      JOB_STATUS_BLOCKED_DEVQ: StringGrid1.Cells[i, 6] :=
        'JOB_STATUS_BLOCKED_DEVQ';
      JOB_STATUS_USER_INTERVENTION: StringGrid1.Cells[i, 6] :=
        'JOB_STATUS_USER_INTERVENTION';
      JOB_STATUS_RESTART: StringGrid1.Cells[i, 6] := 'JOB_STATUS_RESTART';
      JOB_POSITION_UNSPECIFIED: StringGrid1.Cells[i, 6] :=
        'JOB_POSITION_UNSPECIFIED';
 
    else
      StringGrid1.Cells[i, 6] := 'Unknown status...';
    end;
  end;
 
  StringGrid1.Refresh;
end;
</pre>

<p>Запустите проект и попробуйте что-нибудь отправить на печать из MSWord или другого приложения и посмотрите в stringgrid.</p>
<p>Некоторые замечания и дополнения:</p>

<p>Структура JOB_INFO_1 объявлена в юните WinSpool следующим образом:</p>
<pre>
JOB_INFO_1 = record
  JobId: DWORD;
  pPrinterName: PAnsiChar;
  pMachineName: PAnsiChar;
  pUserName: PAnsiChar;
  pDocument: PAnsiChar;
  pDatatype: PAnsiChar;
  pStatus: PAnsiChar;
  Status: DWORD;
  Priority: DWORD;
  Position: DWORD;
  TotalPages: DWORD;
  PagesPrinted: DWORD;
  Submitted: TSystemTime;
end;
</pre>



<p>И массив так же можно объявить следующим образом:</p>


<p>aJobs: array[0..99] of JOB_INFO_1;</p><p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

