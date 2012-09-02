<h1>Объект ошибок ADO</h1>
<div class="date">01.01.2007</div>


<p>При рассказе о компонентах ADO в данной главе мы довольно часто упоминали об объектах ошибок ADO. Эти объекты содержат информацию об ошибке, возникшей при выполнении операции каким-либо объектом ADO. </p>

<p>В Delphi для объекта ошибки не предусмотрен специальный тип, но разработчик может использовать его методы интерфейса Error, предоставляемого многими методами других объектов ADO. Например, тип </p>

<p>TRecordsetEvent = procedure(DataSet: TCustomADODataSet; const Error: Error; </p>
<p>var EventStatus: TEventStatus) of object; </p>

<p>используемый для метода-обработчика, вызываемого после обновления набора данных, содержит параметр Error, дающий нам искомую ссылку. </p>

<p>Рассмотрим полезные свойства объекта ошибок ADO. </p>

<p>Свойство </p>

<p>property Description: WideString read Get_Description; </p>

<p>возвращает описание ошибки, переданное из объекта, в котором ошибка произошла. </p>

<p>Свойство </p>

<p>property SQLState: WideString read Get_SQLState; </p>

<p>содержит текст команды, вызвавшей ошибку. Свойство </p>

<p>property NativeError: Integer read Get_NativeError; </p>

<p>возвращает код ошибки, переданный из объекта, в котором ошибка произошла. </p>

