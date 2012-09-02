<h1>Объекты соединения с источниками данных</h1>
<div class="date">01.01.2007</div>


<p>Внутренний механизм ADO, обеспечивающий соединение с хранилищем данных, использует два типа объектов. Это объекты-источники данных и объекты-сессии. </p>

<p>Объект-источник данных обеспечивает представление информации о требуемом реальном источнике данных и подключение к нему. </p>

<p>Для ввода сведений о хранилище данных используется интерфейс iDBProperties. Для успешного подключения необходимо задать обязательные сведения. Вероятно, для любого хранилища данных будет актуальной информация об его имени, пользователе и пароле. Однако каждый тип хранилища имеет собственные уникальные настройки. Для получения списка всех обязательных параметров соединения с данным хранилищем можно воспользоваться методом </p>

<p>function GetPropertylnfo(cPropertylDSets: UINT; rgPropertylDSets: PDBPropIDSetArray; var pcPropertylnfoSets: UINT; out prgPropertylnfoSets: PDBPropInfoSet; ppDescBuffer: PPOleStr): HResult; stdcall; </p>

<p>который возвращает заполненную структуру DBPROPINFO. </p>

<p>PDBPropInfo = ^TDBPropInfo; </p>

<p>DBPROPINFO = packed record </p>
<p>  pwszDescription: PWideChar; </p>
<p>  dwPropertylD: DBPROPID; </p>
<p>  dwFlags: DBPROPFLAGS; </p>
<p>  vtType: Word; </p>
<p>  vValues: OleVariant; </p>
<p>end;&nbsp; </p>

<p>TDBPropInfo = DBPROPINFO; </p>

<p>Для каждого обязательного параметра в элементе dwFlags устанавливается значение DBPROPFLAGS_REQUIRED. </p>

<p>Для инициализации соединения необходимо использовать метод </p>

<p>function Initialize: HResult; stdcall; </p>

<p>интерфейса iDBinitiaiize объекта-источника данных. </p>

