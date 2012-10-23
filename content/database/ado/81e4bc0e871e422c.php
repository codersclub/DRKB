<h1>Как работать из Delphi напрямую с ADO?</h1>
<div class="date">01.01.2007</div>



<div class="author">Автор: Nomadic </div>

<p>Итак, хочу поделиться некоторыми достижениями... так на всякий случай. Если у вас вдруг потребуется сделать в своей программке доступ к базе данных, а BDE использовать будет неохота (или невозможно) - то есть довольно приятный вариант: использовать ActiveX Data Objects. Однако с их использованием есть некоторые проблемы, и одна из них это как передавать Optional параметры, которые вроде как можно не указывать. Однако, если вы работаете с ADO по-человечески, а не через тормозной IDispatch.Invoke то это превращается в головную боль. Вот как от нее избавляться:</p>

<pre>
var
  OptionalParam: OleVariant;
  VarData: PVarData;
begin
  OptionalParam := DISP_E_PARAMNOTFOUND;
  VarData := @OptionalParam;
  VarData^.VType := varError;
 
</pre>

<p>после этого переменную OptionalParam можно передавать вместо неиспользуемого аргумента. </p>

<p>Далее, самый приятный способ получения Result sets: </p>

<p>Там есть масса вариантов, но как выяснилось оптимальным является следующий вариант, который позволяет получить любой желаемый вид курсора (как клиентский, так и серверный)</p>
<pre>
var
  MyConn: _Connection;
  MyComm: _Command;
  MyRecSet: _Recordset;
  prm1: _Parameter;
begin
  MyConn := CoConnection.Create;
  MyConn.ConnectionString := 'DSN=pubs;uid=sa;pwd=;'; MyConn.Open( '', '', '', -1 );
  MyCommand := CoCommand.Create;
  MyCommand.ActiveConnection := MyConn;
  MyCommand.CommandText := 'SELECT * FROM blahblah WHERE BlahID=?'
  Prm1 := MyCommand.CreateParameter( 'Id', adInteger.adParamInput, -1, &lt;value&gt; );
  MyCommand.AppendParameter( Prm1 );
  MyRecSet := CoRecordSet.Create;
  MyRecSet.Open( MyCommand, OptionalParam, adOpenDynamic, adLockReadOnly, adCmdText );
</pre>


<p>... теперь можно фетчить записи. Работает шустро и классно. Меня радует. Особенно радуют серверные курсоры. </p>

<p>Проверялось на Delphi 3.02 + ADO 1.5 + MS SQL 6.5 sp4. Пашет как зверь. </p>

<p>Из вкусностей ADO - их легко можно использовать во всяких многопоточных приложениях, где BDE порой сбоит, если, конечно, ODBC драйвер грамотно сделан... </p>

<p>Ну и еще можно использовать для доступа к данным всяких там "нестандартных" баз типа MS Index Server или MS Active Directory Services. </p>

<p>В Delphi (как минимум в 4 версии) существует "константа" EmptyParam, которую можно подставлять в качестве пустого параметра. </p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

<p class="note">Примечание Vit</p>
<p>С появлением в последющих версиях Дельфи ADO компонентов делает работу с ADO гораздо проще и понятнее, хотя в отдельных проектах всё ещё могут понадобится прямые обращения к недокументированным или не имплементированным в Дельфи возможностям ADO.</p>
