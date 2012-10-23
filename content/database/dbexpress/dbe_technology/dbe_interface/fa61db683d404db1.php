<h1>ISQLCommand</h1>
<div class="date">01.01.2007</div>


<p>Интерфейс isQLCommand обеспечивает функционирование запроса dbExpress. Компоненты dbExpress, работающие с наборами данных, используют его для реализации своих методов.</p>
<p>Параметры запроса устанавливаются методом</p>
<p>function setParameter(ulParameter: Word; ulChildPos: Word; eParamType: TSTMTParamType; uLogType: Word; uSubType: Word; iPrecision: Integer; iScale: Integer; Length: LongWord; pBuffer: Pointer; llnd: Integer): SQLResult; stdcall;</p>
<p>где ulParameter &#8212; порядковый номер параметра; если параметр является дочерним для сложных типов данных, ulchildPos задает его порядковый номер; eParamType задает тип параметра (входной, выходной, смешанный); uLogType &#8212; тип данных параметра; uSubType &#8212; вспомогательный параметр типа данных; iscale &#8212; максимальный размер значения в байтах; iPrecision &#8212; максимальная точность типа данных; Length &#8212; размер буфера; pBuffer &#8212; буфер, содержащий значение параметра; lInd &#8212; флаг, определяющий, может ли параметр иметь нулевое значение.</p>
<p>Для каждого параметра метод вызывается снова. Информацию о параметре можно получить, используя метод</p>
<p>function getParameter(ParameterNumber: Word; ulChildPos: Word; Value: Pointer; Length: Integer; var IsBlank: Integer): SQLResult; stdcall;</p>
<p>где ParameterNumber &#8212; порядковый номер параметра; если параметр является дочерним для сложных типов данных, ulchildPos задает его порядковый номер; value &#8212; указатель на буфер значения параметра; Length &#8212; размер буфера; isBlank &#8212; признак незаполненного параметра.</p>
<p>Метод</p>
<p>function prepare(SQL: PChar; ParamCount: Word): SQLResult; stdcall;</p>
<p>готовит запрос к выполнению с учетом значений параметров. Выполнение запроса осуществляется методом</p>
<p>function execute(var Cursor: ISQLCursor): SQLResult; stdcall;</p>
<p>который возвращает в параметре интерфейс курсора, если запрос выполнен. Или метод</p>
<p>function executelmmediate(SQL: PChar; var Cursor: ISQLCursor): SQLResult; stdcall;</p>
<p>который выполняет запрос, не требующий подготовки (не имеющий параметров). Он также возвращает в параметре cursor готовый интерфейс курсора, если запрос выполнен успешно. Текст запроса определяется параметром SQL.</p>
<p>И метод</p>
<p>function getNextCursor(var Cursor: ISQLCursor): SQLResult; stdcall;</p>
<p>определяет в параметре Cursor курсор следующего набора данных, если выполнялась хранимая процедура, которая возвращает несколько наборов данных.</p>
<p>Интерфейс iSQLCommand используется компонентом TCustomSQLDataSet и недоступен потомкам.</p>

