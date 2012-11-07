<h1>Объекты соединения с источниками данных</h1>
<div class="date">01.01.2007</div>


<p>Внутренний механизм ADO, обеспечивающий соединение с хранилищем данных, использует два типа объектов. Это объекты-источники данных и объекты-сессии.</p>

<p>Объект-источник данных обеспечивает представление информации о требуемом реальном источнике данных и подключение к нему.</p>

<p>Для ввода сведений о хранилище данных используется интерфейс iDBProperties. Для успешного подключения необходимо задать обязательные сведения. Вероятно, для любого хранилища данных будет актуальной информация об его имени, пользователе и пароле. Однако каждый тип хранилища имеет собственные уникальные настройки. Для получения списка всех обязательных параметров соединения с данным хранилищем можно воспользоваться методом</p>

<pre class="delphi">
function GetPropertylnfo(cPropertylDSets: UINT; rgPropertylDSets: PDBPropIDSetArray; var pcPropertylnfoSets: UINT; out prgPropertylnfoSets: PDBPropInfoSet; ppDescBuffer: PPOleStr): HResult; stdcall;
</pre>

<p>который возвращает заполненную структуру DBPROPINFO.</p>

<pre class="delphi">
PDBPropInfo = ^TDBPropInfo;

DBPROPINFO = packed record
  pwszDescription: PWideChar;
  dwPropertylD: DBPROPID;
  dwFlags: DBPROPFLAGS;
  vtType: Word;
  vValues: OleVariant;
end;

TDBPropInfo = DBPROPINFO;
</pre>

<p>Для каждого обязательного параметра в элементе dwFlags устанавливается значение DBPROPFLAGS_REQUIRED.</p>

<p>Для инициализации соединения необходимо использовать метод</p>

<pre class="delphi">
function Initialize: HResult; stdcall;
</pre>

<p>интерфейса iDBinitiaiize объекта-источника данных.</p>

