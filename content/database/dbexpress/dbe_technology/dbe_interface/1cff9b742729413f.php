<h1>ISQLDriver</h1>
<div class="date">01.01.2007</div>


<p>Интерфейс ISQLDriver инкапсулирует всего три метода для обслуживания драйвера dbExpress. Экземпляр интерфейса создается для соединения и обеспечивает его связь с драйвером. </p>
<p>function SetOption(eDOption: TSQLDriverOption; PropValue: Longlnt): SQLResult; stdcall; </p>
<p>function GetOption(eDOption: TSQLDriverOption; PropValue: Pointer; MaxLength: Smalllnt; out Length: Smalllnt): SQLResult; stdcall; </p>
<p>позволяют работать с параметрами драйвера. А метод </p>
<p>function getSQLConnection(out pConn: ISQLConnection): SQLResult; stdcall; </p>
<p>возвращает указатель на интерфейс связанного с драйвером соединения ISQLConnection. </p>
<p>Получить доступ к интерфейсу ISQLDriver разработчик может, использовав защищенное свойство </p>
<p>property Driver: ISQLDriver read FSQLDriver; </p>
<p>компонента TSQLConnection. </p>

