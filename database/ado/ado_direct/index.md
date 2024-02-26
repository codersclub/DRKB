---
Title: Как работать из Delphi напрямую с ADO?
Author: Nomadic
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Как работать из Delphi напрямую с ADO?
======================================

Итак, хочу поделиться некоторыми достижениями... так на всякий случай.
Если у вас вдруг потребуется сделать в своей программке доступ к базе
данных, а BDE использовать будет неохота (или невозможно) - то есть
довольно приятный вариант: использовать ActiveX Data Objects. Однако с
их использованием есть некоторые проблемы, и одна из них это как
передавать Optional параметры, которые вроде как можно не указывать.
Однако, если вы работаете с ADO по-человечески, а не через тормозной
IDispatch.Invoke то это превращается в головную боль. Вот как от нее
избавляться:

    var
      OptionalParam: OleVariant;
      VarData: PVarData;
    begin
      OptionalParam := DISP_E_PARAMNOTFOUND;
      VarData := @OptionalParam;
      VarData^.VType := varError;

после этого переменную OptionalParam можно передавать вместо
неиспользуемого аргумента.

Далее, самый приятный способ получения Result sets:

Там есть масса вариантов, но как выяснилось оптимальным является
следующий вариант, который позволяет получить любой желаемый вид курсора
(как клиентский, так и серверный)

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
      Prm1 := MyCommand.CreateParameter( 'Id', adInteger.adParamInput, -1, <value> );
      MyCommand.AppendParameter( Prm1 );
      MyRecSet := CoRecordSet.Create;
      MyRecSet.Open( MyCommand, OptionalParam, adOpenDynamic, adLockReadOnly, adCmdText );

... теперь можно фетчить записи. Работает шустро и классно. Меня
радует. Особенно радуют серверные курсоры.

Проверялось на Delphi 3.02 + ADO 1.5 + MS SQL 6.5 sp4. Пашет как зверь.

Из вкусностей ADO - их легко можно использовать во всяких многопоточных
приложениях, где BDE порой сбоит, если, конечно, ODBC драйвер грамотно
сделан...

Ну и еще можно использовать для доступа к данным всяких там
"нестандартных" баз типа MS Index Server или MS Active Directory
Services.

В Delphi (как минимум в 4 версии) существует "константа" EmptyParam,
которую можно подставлять в качестве пустого параметра.

--------
**Примечание Vit:**

>С появлением в последующих версиях Дельфи ADO компонентов делает работу с
>ADO гораздо проще и понятнее, хотя в отдельных проектах всё ещё могут
>понадобится прямые обращения к недокументированным или не
>имплементированным в Дельфи возможностям ADO.
