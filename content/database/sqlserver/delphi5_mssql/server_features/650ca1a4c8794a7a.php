<h1>Соответствие стандарту ANSI SQL 92</h1>
<div class="date">01.01.2007</div>


Соответствие стандарту ANSI SQL 92</p>
<p>В MS SQL Server имеются настройки, позволяющие изменять степень соответствия сервера стандарту ANSI SQL 92.</p>
<p>SET ANSI_NULLS {ON|OFF} - регулирует результат сравнения значений, содержащих NULL. Если ANSI_NULLS = OFF, то запрос</p>
<pre>
SELECT * FROM MyTable WHERE MyField = NULL
</pre>


<p>Вернет все строки, в которых MyField установлено в NULL. Если ANSI_NULLS = OFF, то, в соответствии со стандартом ANSI SQL92 сравнение с NULL возвращает UNKNOWN. Другие установки, на которые следует обратить внимание:</p>
<p>SET CURSOR_CLOSE_ON_COMMIT &mdash; Устанавливает режим закрытия курсоров по завершению транзакции</p>
<p>SET ANSI_NULL_DFLT_ON и  SET ANSI_NULL_DFLT_OFF &mdash; Устанавливают nullability полей по умолчанию при создании таблицы</p>
<p>SET IMPLICIT_TRANSACTIONS &mdash; Устанавливает режим Autocommit</p>
<p>SET ANSI_PADDING &mdash; Устанавливает режим «отсечения» концевых пробелов для вновь создаваемых полей</p>
<p>SET QUOTED_IDENTIFIER &mdash; Разрешает выделение идентификаторов двойными кавычками</p>
<p>SET ANSI_WARNINGS &mdash; Устанавливает реакцию на математические ошибки</p>
<p>Рассмотрение этих параметров выходит за рамки книги, однако необходимо обратить на них внимание при чтении документации.</p>
<p>Установка SET ANSI_DEFAULTS устанавливает режим максимальной совместимости с ANSI SQL92. При установке SET ANSI_DEFAULTS ON устанавливаются в ON следующие параметры:</p>
<p>SET ANSI_NULLS, SET CURSOR_CLOSE_ON_COMMIT, SET ANSI_NULL_DFLT_ON, SET IMPLICIT_TRANSACTIONS, SET ANSI_PADDING, SET QUOTED_IDENTIFIER и SET ANSI_WARNINGS</p>
<p>По умолчанию ANSI_DEFAULTS = ON для клиентов ODBC и OLE DB (ADO) и OFF для клиента DB-Library (BDE). Поскольку предпочтительным (и поддерживаемым в будущем) методом доступа является OLE DB, то при разработке клиентской части, использующей BDE, рекомендуется явно устанавливать SET ANSI_DEFAULTS ON. С разностью этой установки связана и проблема, возникающая при разработке запросов при помощи Query Analyzer. Если в нем и в клиентском приложении имеются разные настройки совместимости с ANSI - одни и те же запросы могут выдавать разные результаты. Поэтому рекомендуется проверять настройки Query Analyzer на предмет соответствия их тем, что предполагается иметь в клиенте.</p>

