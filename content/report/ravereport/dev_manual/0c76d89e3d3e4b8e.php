<h1>Настройка подключений данных</h1>
<div class="date">01.01.2007</div>


<p>Использование событий для настройки ваших подключений данных</p>
<p>Вы можете управлять, как данные будут поступать в ваш отчет через события компонент подключения данных. Для данных, поступающих не из баз, используйте компонент TrvCustomConnection, Вы можете предоставить доступ к вашим данным через его события. Для подключения данных из баз, используйте компоненты, такие как TRvDataSetConnection, достаточно будет переписать событие OnValidateRow. События подключений данных следующие:</p>
<p>Событие &nbsp; &nbsp; &nbsp; &nbsp;Описание &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>OnEOF &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Вызывается, когда Rave желает определить, достигнут ли конец данных. При отсутствии данных требуется вернуть значение TRUE, если больше нет строк или если вызов события OnNext был сделан за пределы последней строки. &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>OnFirst &nbsp; &nbsp; &nbsp; &nbsp;Вызывается, когда Rave желает, что бы курсор был перемещен на первую строку данных. С развитой системой буферизации Rave, это событие обычно возникает только раз в начале сессии данных. &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>OnGetCols &nbsp; &nbsp; &nbsp; &nbsp;Вызывается, когда Rave желает получить мета данные. Это включает в себя имена полей, типы, размеры символов, полные имена и описание. Подробности смотри ниже. &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>OnGetRow &nbsp; &nbsp; &nbsp; &nbsp;Вызывается, когда Rave желает получить данные для текущей строки. Подробности смотри ниже. &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>OnGetSorts &nbsp; &nbsp; &nbsp; &nbsp;Вызывается, когда Rave желает получить доступные методы сортировки. &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>OnNext &nbsp; &nbsp; &nbsp; &nbsp;Вызывается, когда Rave желает переместить курсор на следующую строку. &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>OnOpen &nbsp; &nbsp; &nbsp; &nbsp;Вызывается, когда Rave желает инициализировать начало сессии. Должно быть сохранено текущее состояние, что бы потом его можно было восстановить в событии OnRestore. &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>OnRestore &nbsp; &nbsp; &nbsp; &nbsp;Вызывается, когда Rave желает восстановить состояние предыдущей сессии, которое было перед ее открытием. &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>OnSetFilter &nbsp; &nbsp; &nbsp; &nbsp;Вызывается, когда Rave желает фильтровать данные, такие как Master-Detail отчеты. &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>OnSetSort &nbsp; &nbsp; &nbsp; &nbsp;Вызывается, когда Rave желает сортировать данные. Подробности смотри ниже. &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>OnValidateRow &nbsp; &nbsp; &nbsp; &nbsp;Вызывается для каждой строки, позволяя тем сам управлять фильтрацией данных. Для пользовательских приложений, данное событие обычно не нужно, поскольку фильтрация данных через событие OnNext более эффективно. Тем не менее, данное событие очень полезно для других, более автоматизированных подключений, таких как TRvDataSetConnection. Подробности смотри ниже. &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p class="note">Примечание:</p>
<p>Компонент TRvCustomConnection имеет свойства DataIndex и DataRows типа integer. Они предназначены для использования в событиях пользовательских подключений и если используются, то могут быть определены в OnFirst, OnNext и OnEOF событиях. DataIndex используется как позиция курсора, первая строка имеет номер 0. DataRows используется как счетчик строк данных. Например, если вы определяете пользовательское подключение к массиву данных, вам будет достаточно установить свойство Connection.DataRows равным количеству элементов в массиве и затем позволить Rave управлять OnFirst, OnNext и OnEOF событиями. В событии OnGetRow, Вы должны, обратиться к свойству Connection.DataIndex для определения какой элемент массива требуется вернуть назад (не забывайте, что нумерация идет с 0).</p>
<p>Событие OnGetCols </p>
<p>Событие OnGetCols вызывается, когда Rave желает получить мета данные. Внутри этого события Вы захотите вызвать метод&nbsp; Connection.WriteField для каждого поля (колонки) ваших данных. Определение WriteField следующее:</p>
<p>procedure WriteField(Name: string;DataType: TRpDataType;Width: integer;</p>
<p>FullName: string;Description: string);</p>
<p>Name это короткое имя поля и должно состоять только из алфавитно-цифровых символов. DataType это тип данных поля и должен быть одним из следующих типов: dtString, dtInteger, dtBoolean, dtFloat, dtCurrency, dtBCD, dtDate, dtTime, dtDateTime, dtBlob, dtMemo или dtGraphic. Width это относительная ширина поля в символах. Full name это полное, более описательное имя поля и может включать в себя пробелы и другие не&nbsp; алфавитно-цифровые символы. Если FullName пустое, то будет использовано короткое имя поля. Description это полное описание поля и обычно редактируется с помощью компонента, поэтому может состоять из нескольких строк. Используйте свойство Description для описания, как используется поле или для любой другой более, нужной информации насчет данного поля.</p>
<p>Пример:</p>
<pre>
procedure TDataForm.CustomCXNGetCols(Connection: TRvCustomConnection);
begin
  With Connection do begin
  WriteField('Index',dtInteger,8,'Index Field','Описание 1');
  WriteField('Name',dtString,30,'Name Field','Описание 2');
  WriteField('Amount',dtFloat,20,'Amount Field','Описание 3');
  end; { with }
end;
</pre>
<p>Событие OnOpen </p>
<p>Событие OnOpen возбуждается при инициализации сессии данных. В этом событие Вы можете открыть файлы данных, инициализировать переменные и сохранить текущее состояние данных для события OnRestore, которое будет возбуждено при закрытии сессии данных.</p>
<p>Пример:</p>
<pre>
procedure TDataForm.CustomCXNOpen(Connection: TRvCustomConnection);
begin
  AssignFile(DataFile,'DATAFILE.DAT');
  Reset(DataFile,1);
end;
</pre>
&nbsp;</p>
&nbsp;</p>
<p>Событие OnFirst </p>
<p>Событие OnFirst вызывается, когда требуется перемещение курсора данных на первую строку данных.</p>
<p>Пример:</p>
<pre>
procedure TDataForm.CustomCXNFirst(Connection: TRvCustomConnection);
begin
  Seek(DataFile,0);
  BlockRead(DataFile,DataRecord,SizeOf(DataRecord),DataRead);
end;
</pre>
&nbsp;</p>
&nbsp;</p>
<p>Событие OnNext </p>
<p>Событие OnNext вызывается, когда требуется перемещение курсора данных на следующую строку данных.</p>
<p>Пример:</p>
<pre>
procedure TDataForm.CustomCXNNext(Connection: TRvCustomConnection);
begin
  BlockRead(DataFile,DataRecord,SizeOf(DataRecord),DataRead);
end;
</pre>

<p>Событие OnEOF </p>
<p>Событие OnEOF вызывается для возврата состояния курсора данных, находится ли он на данных или уже вышел за конец. Значение TRUE должно быть возвращено, если данных больше нет или если вызов события OnNext привел к выходу из последней строки.</p>
<p>Пример:</p>
<pre>
procedure TMainForm.CustomCXNEOF(Connection: TRvCustomConnection;var EOF: Boolean);
begin
  EOF := DataRead &lt; SizeOf(DataRecord);
end;
</pre>

<p>Событие OnGetRow </p>
<p>Событие OnGetRow вызывается для получения данных для текущей строки. Имеется несколько методов для записи данных в специальные буферы используемые Rave. Порядок и типы записываемых полей должен быть точно таким же, как полученные определения полей в событии OnGetCols.</p>
<p>В следующем списке приведены методы объекта Connection для записи данных в буфера.</p>
<p>procedure WriteStrData(FormatData: string; NativeData: string); {dtString}</p>
<p>procedure WriteIntData(FormatData: string; NativeData: integer); {dtInteger}</p>
<p>procedure WriteBoolData(FormatData: string; NativeData: boolean); {dtBoolean}</p>
<p>procedure WriteFloatData(FormatData: string; NativeData: extended); {dtFloat}</p>
<p>procedure WriteCurrData(FormatData: string; NativeData: currency); {dtCurrency}</p>
<p>procedure WriteBCDData(FormatData: string; NativeData: currency); {dtBCD}</p>
<p>procedure WriteDateTimeData(FormatData: string; NativeData: TDateTime);</p>
<p>{dtDate, dtTime and dtDateTime}</p>
<p>procedure WriteBlobData(var Buffer; Len: longint); </p>
<p>{dtBlob, dtMemo and dtGraphic}</p>
<p>Также имеется специальный метод, названный WriteNullData (без параметров), который может быть использован для некоторых полей, для указания неинициализированных данных (null). Параметр FormatData используется для передачи строки форматирования данных для данного поля. Параметр NativeData предназначен для передачи неформатированных или чистых данных поля. Если строка форматирования определена в отчете Rave, то она используется для форматирования, иначе используется FormatData.</p>
<p>Пример:</p>
<pre>
procedure TDataForm.CustomCXNGetRow(Connection: TRvCustomConnection);
begin
  With Connection do begin
  WriteIntData('',DataRecord.IntField);
  WriteStrData('',DataRecord.StrField);
  WriteFloatData('',DataRecord.FloatField);
  end; { with }
end;
</pre>
&nbsp;</p>
&nbsp;</p>
<p>Событие OnValidateRow </p>
<p>Событие OnValidateRow возникает для каждой строки данных, позволяя управлять включением строки данных в отчет или нет. Обычно это единственное событие, которое&nbsp; определяется для не пользовательских подключений.</p>
<p>Пример:</p>
<pre>
procedure TDataForm.CustomCXNValidateRow(Connection: TRvCustomConnection;
var ValidRow: Boolean);
begin
  ValidRow := DataRecord.FloatField &gt;= 0.0;
end;
</pre>

<p>Событие OnRestore </p>
<p>Событие OnRestore для прекращения текущей сессии и восстановления предыдущего состояния. В этом событие Вы можете закрыть файлы данных, освободить ресурсы и восстановить предыдущее состояние, которое было перед событием OnOpen.</p>
<p>Пример:</p>
<pre>
procedure TDataForm.CustomCXNRestore(Connection: TRvCustomConnection);
begin
  CloseFile(DataFile);
end;
</pre>

