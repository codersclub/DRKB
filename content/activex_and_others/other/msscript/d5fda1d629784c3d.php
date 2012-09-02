<h1>Использование Microsoft ScriptControl</h1>
<div class="date">01.01.2007</div>

<p>Использование Microsoft ScriptControl</p>
<p>Анатолий Тенцер</p>
<p>&nbsp;<br>
<p>&nbsp;</p>
<p>Содержание</p>
<p>&nbsp;<br>
<p>&nbsp;</p>
<p>Введение</p>
<p>Добавление TScriptControl в программу</p>
<p>Импорт ActiveX-сервера</p>
<p>Настройка свойств и вызов скриптов</p>
<p>Интеграция TScriptControl с VCL</p>
<p>Модель расширения TScriptControl</p>
<p>Интерфейс IDispatch</p>
<p>function GetIdsOfNames</p>
<p>function Invoke</p>
<p>Информация RTTI Delphi </p>
<p>Сводим воедино</p>
<p>Пишем GetIdsOfNames</p>
<p>Пишем Invoke</p>
<p>Оператор For Each</p>
<p>Интерфейс IEnumVariant </p>
<p>Класс TVCLEnumerator </p>
<p>Компонент TVCLScriptControl</p>
<p>Заключение</p>
<p>Введение </p>
<p>&nbsp;<br>
<p>&nbsp;</p>
<p>При разработке настраиваемых информационных систем часто возникает необходимость добавить в свою программу встроенный язык программирования. Такой язык позволял бы конечным пользователям настраивать поведение программы без участия автора и перекомпиляции. Однако самостоятельная реализация интерпретатора является непосильной для многих разработчиков задачей, а от большинства остальных потребует очень много времени и усилий. </p>
<p>В то же время в Windows, как правило, уже имеется достаточно качественный интерпретатор, который может быть легко встроен в вашу программу. Речь идет о Microsoft ScriptControl. Он устанавливается вместе с Microsoft Internet Explorer, входит в Windows 2000 и Windows 98, а для младших версий доступен в виде свободно распространяемого отдельного дистрибутива, объем которого составляет около 200 Кбайт. Его можно получить по адресу http://msdn.microsoft.com/scripting или установить с нашего компакт-диска. В дистрибутив входят ActiveX-компонент и файл помощи с описанием его свойств и методов. </p>
<p>Добавление TScriptControl в программу</p>
<p>&nbsp;<br>
<p>&nbsp;</p>
<p>Импорт ActiveX-сервера </p>
<p>&nbsp;<br>
<p>&nbsp;</p>
<p>Чтобы добавить Microsoft ScriptControl на палитру компонентов Delphi, необходимо импортировать компонент ActiveX под названием Microsoft ScriptControl. </p>
<p><img src="/pic/clip0076.gif" width="477" height="544" border="0" alt="clip0076"></p>
<p>После этого на закладке ActiveX появится невизуальный компонент TScriptControl, который можно разместить на форме. </p>
<p>Настройка свойств и вызов скриптов </p>
<p>&nbsp;<br>
<p>&nbsp;</p>
<p>Рассмотрим ключевые свойства и методы TScriptControl. </p>
<p>property Language: String </p>
<p>Задает язык, интерпретатор которого будет реализовывать компонент. В стандартной поставке доступны VBScript и JScript, однако, если в вашей системе установлены расширения Windows Scripting, возможно использование других языков, таких как Perl или Rexx. </p>
<p>property Timeout: Integer </p>
<p>Задает интервал исполнения скрипта, по истечении которого генерируется ошибка. Значение &#8211;1 позволяет отключить ошибки, связанные с истечением отведенного времени (timeout), что позволит скрипту исполняться неограниченное время. </p>
<p>property UseSafeSubset: Boolean </p>
<p>При установке этого свойства в TRUE компонент может выполнять ограниченный набор действий, заданный текущими установками безопасности в системе. Это свойство полезно, если вы запускаете скрипты, полученные, например, через Интернет. </p>
<p>procedure AddCode(const Code: WideString); </p>
<p>Добавляет код, заданный параметром к списку процедур компонента. В дальнейшем эти процедуры могут быть вызваны при помощи метода Run либо из других процедур скрипта. </p>
<p>  ScriptControl1.AddCode(Memo1.Text);&nbsp; </p>
<p>function Eval(const Expression: WideString): OleVariant </p>
<p>Выполняет код, заданный в параметре Expression, и возвращает результат исполнения. Позволяет выполнить код без добавления его к списку процедур компонента. </p>
<p>procedure AddObject(const Name: WideString; Object_: IDispatch; AddMembers: WordBool); </p>
<p>Добавляет объект к пространству имен компонента. Объект должен быть сервером автоматизации. Добавленный объект доступен как объект в коде скрипта. Например, если в программе создан сервер автоматизации External, реализующий метод DoSomething(Value: Integer), то, добавив объект </p>
<p> ScriptControl1.AddObject(&#8216;External&#8217;, TExternal as IDispatch, FALSE);&nbsp; </p>
<p>мы можем в коде скрипта использовать его следующим образом: </p>
<p>Dim I</p>
<p> I = 8 + External.DoSomething(8)&nbsp; </p>
<p>function Run(const ProcedureName: WideString; var Parameters: PSafeArray): OleVariant; </p>
<p>Выполняет именованную процедуру из числа ранее добавленных при помощи метода AddCode. В массиве Parameters могут быть переданы параметры. </p>
<p>procedure Reset; </p>
<p>Сбрасывает компонент в начальное состояние, удаляя все добавленные ранее объекты и код. </p>
<p>Таким образом, TScriptControl представляет собой достаточно гибкую исполняющую систему с возможностями расширения путем добавления в ее пространство имен серверов автоматизации. </p>
<p>Интеграция TScriptControl с VCL </p>
<p>В существующем виде возможности TScriptControl сильно ограничены сложным доступом к классам VCL. Исполнение интерпретируемого кода &#8211; это хорошо, однако хотелось бы иметь возможность обращаться из него к компонентам в программе, получать и устанавливать их свойства, обрабатывать возникающие в них события, например, следующим образом: </p>
<pre>
Sub Main()
   Dim Control
   Control = Self.Controls("Panel2")
   Control.Add "Panel3", "TPanel"
   With Panel3
     .Align = "alTop"
     .BevelOuter = "bvNone"
     .Height = 40
     .Caption = ""
     .Add "Btn", "TButton", True
     With Btn
      .Top = 10
      .Left = .Top
      .Caption = "Click me"
     End With
 
   End With
 End Sub  
Sub Btn_OnClick()
   Dim StatusBar
   Dim Panel
   Dim I
   I = 0
   For Each Panel In StatusBar.Panels
     I = I + 1
     With Panel
       .Text = .Text &amp; " " &amp; CStr(I)
     End With
   Next
 End Sub  
</pre>
<p>Следующая часть главы посвящена реализации такой функциональности, однако прежде чем приступить к ее исполнению, необходимо более подробно рассмотреть некоторые механизмы, лежащие в основе модели расширения TScriptControl и VCL. </p>
<p>Модель расширения TScriptControl</p>
<p>Как уже было сказано выше, Microsoft ScriptControl позволяет сделать доступными из скрипта объекты, реализованные в программе при помощи метода AddObject. При обращении к таким объектам он предполагает, что они реализуют интерфейс IDispatch и являются, таким образом, серверами автоматизации. В Delphi в качестве таких объектов могут выступать наследники TAutoObject, создать которые можно при помощи мастера, вызываемого из меню File -&gt; New -&gt; ActiveX -&gt; Automation Object. При вызове методов этих объектов ScriptControl последовательно вызывает методы GetIdsOfNames и Invoke их интерфейса IDispatch, что обеспечивает вызовы соответствующих методов объекта. Однако здесь имеются определенные сложности: </p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>По окончании работы с объектом (например, при выходе его за пределы области видимости процедуры скрипта) TScriptControl автоматически вызывает его метод _Release, что приводит к уничтожению класса Delphi. Таким образом, для каждого класса приходится создавать некий объект-представитель, который бы транслировал вызовы TScriptControl в методы и свойства класса Delphi, а став ненужным &#8212; уничтожался, не уничтожая самого класса. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Функциональность наследников TAutoObject задается на этапе компиляции и не может быть расширена в процессе исполнения программы. Это требует создания отдельных представителей для каждого класса VCL, что очень сложно осуществить, к тому же при этом нельзя использовать классы, не имеющие соответствующего представителя. </td></tr></table></div><p>Чтобы найти обходные пути для решения этой проблемы, необходимо более детально вникнуть в реализацию базового интерфейса, лежащего в основе автоматизации. </p>
<p>Интерфейс IDispatch </p>
<p>Интерфейс IDispatch обеспечивает возможность позднего связывания, то есть вызовов методов объектов не по адресам, а по именам на этапе выполнения программы. Интерфейс определен как: </p>
<pre>
  IDispatch = (IUnknown)
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ['{00020400-0000-0000-C000-000000000046}']
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; GetTypeInfoCount( Count: Integer): Integer; ;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; GetTypeInfo(Index, LocaleID: Integer;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TypeInfo): Integer; ;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; GetIDsOfNames( IID: TGUID; Names: Pointer;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NameCount, LocaleID: Integer; DispIDs: Pointer):&nbsp;&nbsp;&nbsp; Integer;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Invoke(DispID: Integer; IID: TGUID;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LocaleID: Integer; Flags: Word; var Params; VarResult,
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ExcepInfo, ArgErr: Pointer): Integer; ;
 &nbsp;&nbsp;&nbsp; ; 
</pre>
<p>Ключевыми методами интерфейса являются GetIdsOfNames и Invoke. </p>
<p>function GetIdsOfNames </p>
<p>Этот метод осуществляет трансляцию имен методов и свойств объекта автоматизации в целочисленные идентификаторы. Если OLE пытается разрешить ссылку вида: </p>
<p>SomeObject.DoSomeThing </p>
<p>то у SomeObject запрашивается интерфейс IDispatch, вызывается метод GetIdsOfNames, которому передаются ссылка на массив имен, требующих разрешения в параметре Names, количество имен в параметре NameCount и региональный контекст в параметре LocaleId. Метод должен заполнить массив, на который указывает параметр DispIds, значениями идентификаторов имен. Объект имеет возможность предоставить разные имена методов для каждого поддерживаемого языка. Если это не требуется &#8212; параметр LocaleId можно игнорировать. </p>
<p>Стандартная реализация IDispatch ищет информацию об именах методов и их идентификаторах в библиотеке типов объекта, однако программист вполне может взять эту работу на себя и осуществлять самостоятельную трансляцию. </p>
<p>function Invoke </p>
<p>После получения идентификатора запрошенного метода OLE вызывает функцию Invoke, передавая в нее: </p>
<p>DispID </p>
<p>Идентификатор вызываемого метода или свойства, полученный от GetIdsOfNames. </p>
<p>LocaleId </p>
<p>Региональный контекст (тот же, что и в GetIdsOfNames). </p>
<p>Flags </p>
<p>Битовая маска, состоящая из следующих флагов: </p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td ><p>DISPATCH_METHOD </p>
</td>
<td ><p>Вызывается метод. Если у объекта есть свойство с таким же именем, то будет установлен также флаг DISPATCH_PROPERTYGET </p>
</td>
</tr>
<tr >
<td ><p>DISPATCH_PROPERTYGET </p>
</td>
<td ><p>Запрашивается значение свойства </p>
</td>
</tr>
<tr >
<td ><p>DISPATCH_PROPERTYPUT </p>
</td>
<td ><p>Устанавливается значение свойства </p>
</td>
</tr>
<tr >
<td ><p>DISPATCH_PROPERTYPUTREF </p>
</td>
<td ><p>Параметр передается по ссылке. Если флаг не установлен &#8211; по значению. 
</td>
</tr>
</table>
<p>Params </p>
<p>Структура DISPPARAMS, содержащая массив параметров, массив идентификаторов для именованных параметров и количества элементов в этих массивах. Параметры передаются в порядке, обратном порядку их следования в функции, как это принято в Visual Basic. </p>
<p>VarResult </p>
<p>Адрес переменной типа OleVariant, в которую должны быть помещены результат вызова метода, или значение свойства, или , если возвращаемое значение не требуется. </p>
<p>ExcepInfo </p>
<p>Адрес структуры EXCEPTINFO, которую метод должен заполнить информацией об ошибке, если она возникнет. </p>
<p>ArgErr </p>
<p>Адрес массива, в который должны быть помещены индексы неверных параметров, в случае если такая ситуация будет обнаружена. </p>
<p>При вызове Invoke не осуществляется никаких проверок, поэтому в ходе его самостоятельной реализации необходимо соблюдать аккуратность при работе с переданными адресами массивов и переменных. </p>
<p>Как видно из описания Idispatch, имеется возможность самостоятельно реализовать этот интерфейс, динамически преобразуя обращения к объекту автоматизации в обращения к соответствующим свойствам классов Delphi. </p>
<p>Информация RTTI Delphi </p>
<p>Delphi имеет свой внутренний протокол, позволяющий осуществлять обращение к опубликованным (объявленным в секции published) свойствам и методам класса. Этой цели служат функции модуля TypInfo.pas. Ключевой является функция </p>
<p> GetPropInfo(TypeInfo: PTypeInfo;</p>
<p> &nbsp;&nbsp; PropName: ): PPropInfo;&nbsp; </p>
<p>которая позволяет по имени свойства получить адрес структуры PPropInfo, содержащей информацию о свойстве. В дальнейшем можно получить значение этого свойства при помощи функций GetXXXProp или установить его функциями SetXXXProp. При этом будут корректно вызваны функции получения или установки свойства. Таким образом, по имени свойства можно определить его наличие и установить или получить его значение. Такая возможность позволяет создать реализацию IDispatch, динамически транслирующую обращения к свойствам зарегистрированного в TScriptControl объекта автоматизации в обращения к свойствам связанного с ним экземпляра класса VCL. </p>
<p>Сводим воедино </p>
<p>&nbsp;<br>
<p>&nbsp;</p>
<p>Итак, как показано выше, RTTI Delphi предоставляет достаточную функциональность для того, чтобы обеспечить трансляцию вызовов OLE-Automation в обращения к свойствам компонентов VCL. Для этого необходимо: </p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>В методе GetIdsOfNames проверить существование свойства при помощи функции GetPropInfo и, если такое свойство найдено, вернуть какой-нибудь числовой идентификатор. В роли такого идентификатора удобно использовать результат, возвращаемый функцией GetPropInfo. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>В методе Invoke установить или получить значение свойства, используя функции GetXXXProp или SetXXXProp. </td></tr></table></div><p>Для трансляции вызовов OLE в VCL создадим класс TVCLProxy: </p>
<pre>
  // Этот интерфейс понадобится для получения ссылки на
   // класс VCL из методов, в которые передается его
   // интерфейс IDispatch
   IQueryPersistent = 
  ['{26F5B6E1-9DA5-11D3-BCAD-00902759A497}']
      GetPersistent: TPersistent;
   ;
 
   TVCLProxy = (TInterfacedObject, IDispatch, IQueryPersistent)
 
     FOwner: TPersistent;
     FScriptControl: TVCLScriptControl;
      DoCreateControl(AName, AClassName: WideString;
       WithEvents: Boolean);
      SetVCLProperty(PropInfo: PPropInfo;
       Argument: TVariantArg): HRESULT;
     GetVCLProperty(PropInfo: PPropInfo; dps: TDispParams;
       PDispIds: PDispIdList; var Value: OleVariant): HRESULT;
     { IDispatch }
      GetTypeInfoCount(out Count: Integer): HResult; ;
      GetTypeInfo(Index, LocaleID: Integer;
        TypeInfo): HResult; ;
      GetIDsOfNames( IID: TGUID; Names: Pointer;
       NameCount, LocaleID: Integer;
       DispIDs: Pointer): HResult; ;
      Invoke(DispID: Integer;  IID: TGUID;
       LocaleID: Integer; Flags: Word;  Params;
       VarResult, ExcepInfo, ArgErr: Pointer): HResult; ;
     { IQueryPersistent }
      GetPersistent: TPersistent;
 
      DoInvoke (DispID: Integer;  IID: TGUID;
       LocaleID: Integer; Flags: Word; var dps : TDispParams;
       pDispIds : PDispIdList; VarResult, ExcepInfo,
       ArgErr: Pointer): HResult; ;
 
      Create(AOwner: TPersistent;
       ScriptControl: TVCLScriptControl);
      Destroy; ;
   ;  
</pre>
<p>Экземпляр этого класса создается при регистрации объекта в TScriptControl и уничтожается автоматически, когда потребность в нем исчезает. </p>
<p>Поле FOwner хранит ссылку на экземпляр класса VCL, интерфейс к которому предоставляет объект, зарегистрированный в TScriptControl. TVCLScriptControl &#8211; это наследник TScriptControl. </p>
<p>Главным его отличием является наличие списка зарегистрированных экземпляров TVCLProxy и обработчиков событий, позволяющих компонентам VCL вызывать методы скрипта. </p>
<p>Пишем GetIdsOfNames </p>
<p>В методе GetIdsOfNames мы должны проверить наличие запрошенного свойства и вернуть адрес его структуры TPropInfo, если такое свойство найдено. </p>
<p>Свойства компонентов VCL </p>
<pre>
 TVCLProxy.GetIDsOfNames( IID: TGUID; Names: Pointer;
 &nbsp; NameCount, LocaleID: Integer; DispIDs: Pointer): HResult;
&nbsp;
 &nbsp; S: ;
 &nbsp; Info: PPropInfo;
&nbsp;
 &nbsp; Result := S_OK;
 &nbsp; // Получаем имя функции или свойства
 &nbsp; S := PNamesArray(Names)[0];
 &nbsp; // Проверяем, есть ли VCL-свойство с таким же именем
 &nbsp; Info := GetPropInfo(FOwner.ClassInfo, S);
 &nbsp;&nbsp; Assigned(Info) 
 &nbsp;&nbsp;&nbsp; // Свойство есть, возвращаем в качестве DispId
 &nbsp;&nbsp;&nbsp; // адрес структуры PropInfo
 &nbsp;&nbsp;&nbsp; PDispIdsArray(DispIds)[0] := Integer(Info);
</pre>
<p>Дополнительные функции </p>
<p>Дополним нашу реализацию возможностью вызова некоторых дополнительных функций: </p>
<p>Controls </p>
<p>Для наследников TWinControl возвращает ссылку на дочерний компонент с именем или индексом, заданным в параметре. </p>
<p>Count </p>
<p>Для компонентов TWinControl &#8211; возвращает количество дочерних компонентов. </p>
<p>Для TCollection &#8211; возвращает количество элементов. </p>
<p>Для TStrings &#8211; возвращает количество строк. </p>
<p>Add </p>
<p>Для компонентов TWinControl &#8211; создает дочерний компонент. </p>
<p>Для TCollection &#8211; добавляет элемент в коллекцию. </p>
<p>Для TStrings &#8211; добавляет строку. </p>
<p>HasProperty </p>
<p>Возвращает истину, если у объекта есть свойство с заданным именем. </p>
<p>Для этого дополним метод GetIdsOfNames следующим кодом: </p>
<pre>  // Нет такого свойства, проверяем, не имя ли это
 &nbsp; // одной из определенных нами функций
 &nbsp;&nbsp; CompareText(S, 'CONTROLS') = 0 
 &nbsp;&nbsp;&nbsp;&nbsp; (FOwner&nbsp; TWinControl) 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PDispIdsArray(DispIds)[0] := DISPID_CONTROLS
&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Result := DISP_E_UNKNOWNNAME;
&nbsp;
&nbsp;
 &nbsp; CompareText(S, 'COUNT') = 0 
 &nbsp;&nbsp;&nbsp;&nbsp; (FOwner&nbsp; TCollection)&nbsp; (FOwner&nbsp; TStrings)
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (FOwner&nbsp; TWinControl) 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PDispIdsArray(DispIds)[0] := DISPID_COUNT
&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Result := DISP_E_UNKNOWNNAME;
&nbsp;
 &nbsp; CompareText(S, 'ADD') = 0 
 &nbsp;&nbsp;&nbsp; Result := S_OK;
 &nbsp;&nbsp;&nbsp;&nbsp; (FOwner&nbsp; TCollection)&nbsp; (FOwner&nbsp; TStrings) 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (FOwner&nbsp; TWinControl) 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PDispIdsArray(DispIds)[0] := DISPID_ADD
&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Result := DISP_E_UNKNOWNNAME;
&nbsp;
 &nbsp; CompareText(S, 'HASPROPERTY') = 0 
 &nbsp;&nbsp;&nbsp; PDispIdsArray(DispIds)[0] := DISPID_HASPROPERTY
&nbsp;
 &nbsp;&nbsp;&nbsp; Result := DISP_E_UNKNOWNNAME;
 ;&nbsp; 
</pre>
<p>Константы DISPID_CONTROLS, DISPID_COUNT и т.д. определены как целые числа из диапазона 1&#8230;1 000 000. Это вполне безопасно, поскольку адрес структуры TPropInfo никак не может оказаться менее 1 Мбайт. </p>
<p>Пишем Invoke </p>
<p>Первая часть задачи выполнена: мы проинформировали OLE о наличии в нашем сервере автоматизации поддерживаемых функций. Теперь необходимо реализовать метод Invoke для выполнения этих функций. Из соображений модульности Invoke выполняет подготовительную работу со списком параметров и вызывает метод DoInvoke, в котором мы осуществляем трансляцию DispID в обращения к методам класса VCL. </p>
<p>В методе используются три служебные функции: </p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>проверяет количество переданных аргументов. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>проверяет соответствие аргумента с заданным индексом заданному типу. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>получает целое число из аргумента с заданным индексом. </td></tr></table></div><p> TVCLProxy.DoInvoke(DispID: Integer;&nbsp; IID: TGUID;</p>
<p> &nbsp; LocaleID: Integer; Flags: Word;&nbsp; dps: TDispParams;</p>
<p> &nbsp; pDispIds: PDispIdList; VarResult, ExcepInfo, ArgErr: Pointer</p>
<p> &nbsp; ): HResult;</p>
<p> &nbsp; S: ;</p>
<p> &nbsp; Put: Boolean;</p>
<p> &nbsp; I: Integer;</p>
<p> &nbsp; P: TPersistent;</p>
<p> &nbsp; B: Boolean;</p>
<p> &nbsp; OutValue: OleVariant;&nbsp; </p>
<p> &nbsp; Result := S_OK;</p>
<p> &nbsp;&nbsp; DispId </p>
<p>Для функции Controls мы должны проверить, что передан один параметр. Если он строковый &#8212; поиск дочернего компонента будет происходить по имени, в противном случае &#8212; по индексу. Если компонент найден &#8211; вызывается функция FScriptControl.GetProxy, которая проверяет наличие &#171;представителя&#187; у этого компонента, при необходимости создает его и возвращает интерфейс IDispatch. Такой алгоритм необходим для корректной работы оператора VBScript Is, который сравнивает две ссылки на объект и выдает истину в случае, если речь идет об одном и том же объекте, например: </p>
<p>Dim A</p>
<p> Dim B</p>
<p> Set A = C</p>
<p> Set B = C</p>
<p> If A is B Then ...&nbsp; </p>
<p>Если создавать экземпляр класса TVCLProxy каждый раз, когда запрашивается ссылка, эти экземпляры окажутся разными и оператор Is не будет работать. </p>
<pre> &nbsp; DISPID_CONTROLS:
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Вызвана функция Controls
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FOwner&nbsp; TWinControl 
&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Проверяем параметр
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CheckArgCount(dps.cArgs, [1], TRUE);
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; P := ;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; _ValidType(0, VT_BSTR, FALSE) 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Если параметр - строка - ищем дочерний компонент
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // с таким именем
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; S := dps.rgvarg^[pDispIds^[0]].bstrVal;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; I := 0  Pred(ControlCount) 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CompareText(S, Controls[I].Name) = 0 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; P := Controls[I];
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Break;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ;
&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Иначе - параметр - число, берем компонент по индексу
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; I := _IntValue(0);
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; P := Controls[I];
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Assigned(P) 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Компонент не найден
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; EInvalidParamType.Create('');
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Возвращаем интерфейс IDispatch для найденного компонента
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; OleVariant(VarResult^) := FScriptControl.GetProxy(P);
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ;&nbsp; 
</pre>
<p>Функция Count должна вызываться без параметров и призвана возвращать количество элементов в запрашиваемом объекте. </p>
<pre> &nbsp; DISPID_COUNT:
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Вызвана функция Count
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Проверяем, что не было параметров
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CheckArgCount(dps.cArgs, [0], TRUE);
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FOwner&nbsp; TWinControl 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Возвращаем количество дочерних компонентов
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; OleVariant(VarResult^) := TWinControl(FOwner).ControlCount;
&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FOwner&nbsp; TCollection 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Возвращаем количество элементов коллекции
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; OleVariant(VarResult^) := TCollection(FOwner).Count
&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FOwner&nbsp; TStrings 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Возвращаем количество строк
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; OleVariant(VarResult^) := TStrings(FOwner).Count;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ;&nbsp; 
</pre>
<p>Метод Add добавляет элемент к объекту-владельцу &#171;представителя&#187;. Обратите внимание на реализацию необязательных параметров для TWinControl и TStrings. </p>
<pre> &nbsp; DISPID_ADD:
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Вызвана функция Add
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FOwner&nbsp; TWinControl 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Проверяем количество аргументов
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CheckArgCount(dps.cArgs, [2,3], TRUE);
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Проверяем типы обязательных аргументов
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; _ValidType(0, VT_BSTR, TRUE);
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; _ValidType(1, VT_BSTR, TRUE);
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Третий аргумент - необязательный, если он не задан -
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // полагаем FALSE
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (dps.cArgs = 3)&nbsp; _ValidType(2, VT_BOOL, TRUE) 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; B := dps.rgvarg^[pDispIds^[0]].vbool
&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; B := FALSE;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Вызываем метод для создания компонента
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DoCreateControl(dps.rgvarg^[pDispIds^[0]].bstrVal,
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dps.rgvarg^[pDispIds^[1]].bstrVal, B);
&nbsp;
&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FOwner&nbsp; TCollection 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Добавляем компонент
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; P := TCollection(FOwner).Add;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // И возвращаем его интерфейс IDispatch
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; OleVariant(varResult^) := FScriptControl.GetProxy(P);
&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FOwner&nbsp; TStrings 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Проверяем наличие аргументов
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CheckArgCount(dps.cArgs, [1,2], TRUE);
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Проверяем, что аргумент – строка
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; _ValidType(0, VT_BSTR, TRUE);
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dps.cArgs = 2 then
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Второй аргумент - позиция в списке
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; I := _IntValue(1)
&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Если его нет - вставляем в конец
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; I := TStrings(FOwner).Count;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Добавляем строку
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TStrings(FOwner).Insert(I,
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dps.rgvarg^[pDispIds^[0]].bstrVal);
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ;&nbsp; 
</pre>
<p>И наконец, функция HasProperty проверяет наличие у объекта VCL опубликованного свойства с заданным именем. </p>
<pre>
 &nbsp; DISPID_HASPROPERTY:
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Вызвана функция HasProperty
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Проверяем наличие аргумента
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CheckArgCount(dps.cArgs, [1], TRUE);
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Проверяем тип аргумента
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; _ValidType(0, VT_BSTR, TRUE);
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; S := dps.rgvarg^[pDispIds^[0]].bstrVal;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Возвращаем True, если свойство есть
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; OleVariant(varResult^) :=
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Assigned(GetPropInfo(FOwner.ClassInfo, S));
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ;&nbsp; 
</pre>
<p>Если ни один из DispID не обработан &#8212; значит DispID содержит адрес структуры TPropInfo свойства VCL </p>
<pre> &nbsp;&nbsp;&nbsp;&nbsp; // Это не наша функция, значит это свойство
 &nbsp;&nbsp;&nbsp; // Проверяем Flags, чтобы узнать, устанавливается значение
 &nbsp;&nbsp;&nbsp; // или получается
 &nbsp;&nbsp;&nbsp; Put := (Flags&nbsp; DISPATCH_PROPERTYPUT) &lt;&gt; 0;
 &nbsp;&nbsp;&nbsp;&nbsp; Put 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Устанавливаем значение
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Проверяем наличие аргумента
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CheckArgCount(dps.cArgs, [1], TRUE);
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // И устанавливаем свойство
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Result := SetVCLProperty(PPropInfo(DispId),
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dps.rgvarg^[pDispIds^[0]])
&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Получаем значение
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DispId = 0 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // DispId = 0 - требуется свойство по умолчанию
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Возвращаем свой IDispatch
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; OleVariant(VarResult^) := Self&nbsp; IDispatch;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Exit;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Получаем значение свойства
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Result := GetVCLProperty(PPropInfo(DispId),
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dps, pDispIds, OutValue);
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Result = S_OK 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Получили успешно - сохраняем результат
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; OleVariant(VarResult^) := OutValue;
 &nbsp;&nbsp;&nbsp; ;
 &nbsp; ;
 ;&nbsp; 
</pre>
<p>Добавление собственных функций </p>
<p>Для добавления функций, которые требуются для решения ваших задач, необходимо выполнить ряд простых шагов: </p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>В методе GetIdsOfNames проанализировать имя запрашиваемой функции и определить, может ли она быть вызвана для объекта, на который ссылается FOwner. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Если функция может быть вызвана, вы должны вернуть уникальный DispID, в противном случае &#8211; присвоить Result := DISP_E_UNKNOWNNAME. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>В методе Invoke необходимо обнаружить свой DispID, проверить корректность переданных параметров, получить их значения и выполнить действие. </td></tr></table></div><p>Обработка событий в компонентах VCL </p>
<p>Важным дополнением к реализуемой функциональности является возможность ассоциировать процедуру на VBScript с событием в компоненте VCL, таким как OnEnter, OnClick или OnTimer. Для этого добавим в компонент TVCLScriptControl методы, которые будут служить обработчиками созданных в коде скрипта компонентов. </p>
<pre>  TVCLScriptControl = (TScriptControl)
 &nbsp; …
&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp; OnChangeHandler(Sender: TObject);
 &nbsp;&nbsp;&nbsp;&nbsp; OnClickHandler(Sender: TObject);
 &nbsp;&nbsp;&nbsp;&nbsp; OnEnterHandler(Sender: TObject);
 &nbsp;&nbsp;&nbsp;&nbsp; OnExitHandler(Sender: TObject);
 &nbsp;&nbsp;&nbsp;&nbsp; OnTimerHandler(Sender: TObject);
 &nbsp; ;
</pre>
<p>В методе DoCreateControl, который вызывается из DoInvoke при обработке метода &#171;Add&#187;, реализуем подключение соответствующих обработчиков событий создаваемого компонента к созданным методам. </p>
<pre>TVCLProxy.DoCreateControl(AName, AClassName: WideString;
 &nbsp; WithEvents: Boolean);
&nbsp;
 &nbsp;&nbsp; SetHandler(Control: TPersistent; Owner: TObject;
 &nbsp;&nbsp;&nbsp; Name: String);
 &nbsp;&nbsp;&nbsp; // Функция устанавливает обработчик события Name на метод формы
 &nbsp;&nbsp;&nbsp; // с именем Name + 'Handler'
&nbsp;
 &nbsp;&nbsp;&nbsp; Method: TMethod;
 &nbsp;&nbsp;&nbsp; PropInfo: PPropInfo;
&nbsp;
 &nbsp;&nbsp;&nbsp; // Получаем информацию RTTI
 &nbsp;&nbsp;&nbsp; PropInfo := GetPropInfo(Control.ClassInfo, Name);
 &nbsp;&nbsp;&nbsp;&nbsp; Assigned(PropInfo) 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Получаем адрес обработчика
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Method.Code := FScriptControl.MethodAddress(Name + 'Handler');
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Assigned(Method.Code) 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Обработчик есть
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Method.Data := FScriptControl;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Устанавливаем обработчик
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SetMethodProp(Control, PropInfo, Method);
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ;
 &nbsp;&nbsp;&nbsp; ;
 &nbsp; ;
&nbsp;
&nbsp;
 &nbsp; ThisClass: TControlClass;
 &nbsp; C: TComponent;
 &nbsp; NewOwner: TCustomForm;
&nbsp;
 &nbsp; // Назначаем свойство Owner на форму
 &nbsp; (FOwner&nbsp; TCustomForm) 
 &nbsp;&nbsp;&nbsp; NewOwner := GetParentForm(FOwner&nbsp; TControl)
&nbsp;
 &nbsp;&nbsp;&nbsp; NewOwner := FOwner&nbsp; TCustomForm;
 &nbsp; // Получаем класс создаваемого компонента
 &nbsp; ThisClass := TControlClass(GetClass(AClassName));
 &nbsp; // Создаем компонент
 &nbsp; C := ThisClass.Create(NewOwner);
 &nbsp; // Назначаем имя
 &nbsp; C.Name := AName;
 &nbsp;&nbsp; C&nbsp; TControl 
 &nbsp;&nbsp;&nbsp; // Назначаем свойство Parent
 &nbsp;&nbsp;&nbsp; TControl(C).Parent := FOwner&nbsp; TWinControl;
 &nbsp;&nbsp; WithEvents 
 &nbsp;&nbsp;&nbsp; // Устанавливаем обработчики
 &nbsp;&nbsp;&nbsp; SetHandler(C, NewOwner, 'OnClick');
 &nbsp;&nbsp;&nbsp; SetHandler(C, NewOwner, 'OnChange');
 &nbsp;&nbsp;&nbsp; SetHandler(C, NewOwner, 'OnEnter');
 &nbsp;&nbsp;&nbsp; SetHandler(C, NewOwner, 'OnExit');
 &nbsp;&nbsp;&nbsp; SetHandler(C, NewOwner, 'OnTimer');
 &nbsp; ;
 &nbsp; // Создаем класс, реализующий интерфейс Idispatch, и добавляем его
 &nbsp; // в пространство имен TScriptControl
 &nbsp; FScriptControl.RegisterClass(AName, C);
 ;&nbsp; 
Таким образом, если третьим параметром метода «Add» будет задано True, то TVCLScriptControl установит обработчики событий OnClick, OnChange, OnEnter, OnExit и OnTimer на свои методы, реализованные следующим образом: 
 TVCLScriptControl.OnClickHandler(Sender: TObject);
&nbsp;
 &nbsp; RunProc((Sender&nbsp; TComponent).Name + '_' + 'OnClick');
 ;&nbsp; 
</pre>
<p>Примером использования данной функциональности может служить следующий код: </p>
<pre>Sub Main()
&nbsp;
 &nbsp; Self.Add "Timer1", "TTimer", TRUE
 &nbsp; With Timer1
 &nbsp;&nbsp;&nbsp; .Interval = 1000
 &nbsp;&nbsp;&nbsp; .Enabled = True
 &nbsp; End With
&nbsp;
 End Sub
&nbsp;
 Sub Timer1_OnTimer()
&nbsp;
 &nbsp; Self.Caption = CStr(Time)
&nbsp;
 End Sub&nbsp; 
</pre>
<p>Если требуется назначить обработчики событий, имеющихся на форме компонентов, это может быть сделано в коде </p>
<p>  Button1.OnClick := ScriptControl1.OnClickHandler;&nbsp; </p>
<p>или путем реализации соответствующего метода в GetIdsOfNames и Invoke. </p>
<p>Получение свойств </p>
<p>Для получения свойств классов VCL служит метод GetVCLProperty. В нем осуществляется трансляция типов данных Object Pascal в типы данных OLE. </p>
<pre> TVCLProxy.GetVCLProperty(PropInfo: PPropInfo;
 &nbsp; dps: TDispParams; PDispIds: PDispIdList;&nbsp; Value: OleVariant
 &nbsp; ): HResult;
&nbsp;
 &nbsp; I, J, K: Integer;
 &nbsp; S: String;
 &nbsp; P, P1: TPersistent;
 &nbsp; Data: PTypeData;
 &nbsp; DT: TDateTime;
 &nbsp; TypeInfo: PTypeInfo;
 &nbsp; Result := S_OK;
 &nbsp;&nbsp; PropInfo^.PropType^.Kind&nbsp;&nbsp; 
Для данных строкового и целого типа Delphi осуществляет автоматическую трансляцию.&nbsp;&nbsp; 
 &nbsp;&nbsp;&nbsp; tkString, tkLString, tkWChar, tkWString:
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Символьная строка
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Value := GetStrProp(FOwner, PropInfo);&nbsp; 
 &nbsp;&nbsp; tkChar, tkInteger:
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Целое число
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Value := GetOrdProp(FOwner, PropInfo);
</pre>
<p>Для перечисленных типов OLE не имеет прямых аналогов. Поэтому для всех типов, кроме Boolean, будем передавать символьную строку с именем соответствующей константы. Для Boolean имеется подходящий тип данных, и этот случай необходимо обрабатывать отдельно. </p>
<pre> &nbsp;&nbsp; tkEnumeration:
&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Проверяем, не Boolean ли это
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CompareText(PropInfo^.PropType^.Name, 'BOOLEAN') = 0 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Передаем как Boolean
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Value := Boolean(GetOrdProp(FOwner, PropInfo));
&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Остальные - передаем как строку
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; I := GetOrdProp(FOwner, PropInfo);
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Value := GetEnumName(PropInfo^.PropType^, I);
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ; 
</pre>
<p>Самым сложным случаем является свойство объектного типа. Нормальным поведением будет возврат интерфейса IDispatch, позволяющего OLE обращаться к методам класса, на который ссылается свойство. Однако для некоторых классов, имеющих свойства &#171;по умолчанию&#187;, таких как TStrings и TСollection, свойство может быть запрошено с индексом. В этом случае следует выдать соответствующий индексу элемент. В то же время, будучи запрошенным без индекса, свойство должно выдать интерфейс IDispatch для работы с экземпляром TCollection или TStrings. </p>
<pre> &nbsp;&nbsp; tkClass:
&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Получаем значение свойства
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; P := TPersistent(GetOrdProp(FOwner, PropInfo));
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Assigned(P)&nbsp; (P&nbsp; TCollection)
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (dps.cArgs = 1) 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Запрошен элемент коллекции с индексом (есть параметр)
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ValidType(dps.rgvarg^[pDispIds^[0]], VT_BSTR,
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FALSE) 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Параметр строковый, ищем элемент по свойству
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // DisplayName
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; S := dps.rgvarg^[pDispIds^[0]].bstrVal;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; P1 := ;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; I := 0  Pred(TCollection(P).Count) 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CompareText(S,
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TCollection(P).Items[I].DisplayName)&nbsp; = 0 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; P1 := TCollection(P).Items[I];
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Break;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Assigned(P1) 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Найден - возвращаем интерфейс IDispatch
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Value := FScriptControl.GetProxy(P1)
&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Не найден
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Result := DISP_E_MEMBERNOTFOUND;
&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Параметр целый, возвращаем элемент по индексу
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; I := IntValue(dps.rgvarg^[pDispIds^[0]]);
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (I &gt;= 0) and (I &lt; TCollection(P).Count) 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; P := TCollection(P).Items[I];
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Value := FScriptControl.GetProxy(P);
&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Result := DISP_E_MEMBERNOTFOUND;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ;
</pre>
<p>Для класса TStrings результатом будет не интерфейс, а строка, выбранная по имени или по индексу. </p>
<pre> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Assigned(P)&nbsp; (P&nbsp; TStrings)&nbsp; (dps.cArgs = 1) 
&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Запрошен элемент из Strings с индексом (есть параметр)
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ValidType(dps.rgvarg^[pDispIds^[0]], VT_BSTR,
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FALSE) 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Параметр строковый - возвращаем значение свойства
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Values
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; S := dps.rgvarg^[pDispIds^[0]].bstrVal;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Value := TStrings(P).Values[S];
&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Параметр целый, возвращаем строку по индексу
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; I := IntValue(dps.rgvarg^[pDispIds^[0]]);
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (I &gt;= 0)&nbsp; (I &lt; TStrings(P).Count)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Value := TStrings(P)[I]
&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Result := DISP_E_MEMBERNOTFOUND;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ;
&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Общий случай, возвращаем интерфейс IDispatch свойства
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Assigned(P) 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Value := FScriptControl.GetProxy(P)
&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Или Unassigned, если оно = NIL
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Value := Unassigned;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ;&nbsp; 
</pre>
<p>У чисел с плавающей точкой также есть особенный тип данных &#8211; TDateTime. Его необходимо обрабатывать иначе, чем остальные числа с плавающей точкой, поскольку у него в OLE есть отдельный тип данных &#8212; OleDate. </p>
<pre> &nbsp;&nbsp; tkFloat:
&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (PropInfo^.PropType^ = System.TypeInfo(TDateTime))
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (PropInfo^.PropType^ = System.TypeInfo(TDate)) 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; //Помещаем значение свойства в промежуточную
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // переменную типа TDateTime&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DT := GetFloatProp(FOwner, PropInfo);
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Value := DT;
&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Value := GetFloatProp(FOwner, PropInfo);
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ;&nbsp; 
</pre>
<p>В случае свойства типа &#171;набор&#187; (Set), не имеющего аналогов в OLE, будем возвращать строку с установленными значениями набора, перечисленными через запятую. </p>
<pre> &nbsp;&nbsp; tkSet:
&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Получаем значение свойства (битовая маска)
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; I := GetOrdProp(FOwner, PropInfo);
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Получаем информацию RTTI
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Data := GetTypeData(PropInfo^.PropType^);
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TypeInfo := Data^.CompType^;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Формируем строку с набором значений
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; S := '';
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; I &lt;&gt; 0 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; K := 0  31 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; J := 1  K;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (J&nbsp; I) = J 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; S := S + GetEnumName(TypeInfo, K) + ',';
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Удаляем запятую в конце
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; System.Delete(S, Length(S), 1);
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Value := S;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ; 
</pre>
<p>И наконец, с типом Variant не возникает никаких сложностей. </p>
<pre> &nbsp;&nbsp; tkVariant:
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Value := GetVariantProp(FOwner, PropInfo);
&nbsp;
 &nbsp;&nbsp;&nbsp; // Остальные типы не поддерживаются
 &nbsp;&nbsp;&nbsp; Result := DISP_E_MEMBERNOTFOUND;
 &nbsp; ;
 ;&nbsp; 
</pre>
<p>Установка свойств </p>
<p>Для установки свойств классов VCL служит метод SetVCLProperty. В нем осуществляется обратная трансляция типов данных OLE в типы данных Object Pascal. </p>
<pre> TVCLProxy.SetVCLProperty(PropInfo: PPropInfo;
 &nbsp; Argument: TVariantArg): HResult;
&nbsp;
 &nbsp; I, J, K, CommaPos: Integer;
 &nbsp; GoodToken: Boolean;
 &nbsp; S, S1: ;
 &nbsp; DT: TDateTime;
 &nbsp; ST: TSystemTime;
 &nbsp; IP: IQueryPersistent;
 &nbsp; Data, TypeData: PTypeData;
 &nbsp; TypeInfo: PTypeInfo;
&nbsp;
 &nbsp; Result := S_OK;
 &nbsp;&nbsp; PropInfo^.PropType^.Kind&nbsp; 
</pre>
<p>Главным отличием этого метода от SetVCLProperty является необходимость проверки типа данных передаваемого параметра. </p>
<pre>
  tkChar, tkString, tkLString, tkWChar, tkWString:
 
         // Проверяем тип параметра
         ValidType(Argument, VT_BSTR, TRUE);
         // И устанавливаем свойство
         SetStrProp(FOwner, PropInfo, Argument.bstrVal);
       ;  
</pre>
<p>Для целочисленных свойств добавим еще один сервис (если свойство имеет тип TCursor или Tcolor) &#8212; обеспечим трансляцию символьной строки с соответствующим названием константы в целочисленный идентификатор. </p>
<pre>
   tkInteger: 
 
         // Проверяем тип свойства на TCursor, TColor,
         // если он совпадает и передано символьное значение,
         // пытаемся получить его идентификатор
          (CompareText(PropInfo^.PropType^.Name, 'TCURSOR') = 0) 
            (Argument.vt = VT_BSTR) 
           IdentToCursor(Argument.bstrVal, I) 
             Result := DISP_E_BADVARTYPE;
             Exit;
           ;
 
          (CompareText(PropInfo^.PropType^.Name, 'TCOLOR') = 0) 
           (Argument.vt = VT_BSTR) 
           IdentToColor(Argument.bstrVal, I) 
             Result := DISP_E_BADVARTYPE;
             Exit;
           ;
 
           // Просто цифра
           I := IntValue(Argument);
         // Устанавливаем свойство
         SetOrdProp(FOwner, PropInfo, I);
       ;
</pre>
<p>Для перечисленных типов, за исключением Boolean, значение передается в виде символьной строки, а Boolean, как и раньше, обрабатывается отдельно. </p>
<pre>
  tkEnumeration:
 
         // Проверяем на тип Boolean - для него в VBScript есть
         // отдельный тип данных
          CompareText(PropInfo^.PropType^.Name, 'BOOLEAN') = 0  
           // Проверяем тип данных аргумента
           ValidType(Argument, VT_BOOL, TRUE);
           // Это свойство Boolean - получаем значение и значение
           SetOrdProp(FOwner, PropInfo, Integer(Argument.vBool));
 
           // Перечисленный тип передается в виде символьной строки
           // Проверяем тип данных аргумента
           ValidType(Argument, VT_BSTR, TRUE);
           // Получаем значение
           S := Trim(Argument.bstrVal);
           // Переводим в Integer
           I := GetEnumValue(PropInfo^.PropType^, S);
           // Если успешно - устанавливаем свойство
            I &gt;= 0 
             SetOrdProp(FOwner, PropInfo, I)
 
              EInvalidParamType.Create('');
         ;
       ;  
</pre>
<p>При установке объектного свойства необходимо получить ссылку на класс Delphi, представителем которого является переданный интерфейс IDispatch. Для этой цели служит ранее определенный нами интерфейс IQueryPersistent. Запросив его у объекта-представителя, мы можем получить ссылку на объект VCL и корректно установить свойство. </p>
<pre> &nbsp;&nbsp; tkClass:
&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Проверяем тип данных - должен&nbsp;&nbsp;&nbsp; быть интерфейс IDispatch
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ValidType(Argument, VT_DISPATCH,&nbsp;&nbsp;&nbsp; TRUE);
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Assigned(Argument.dispVal) 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Передано непустое&nbsp;&nbsp;&nbsp; значение
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Получаем интерфейс&nbsp;&nbsp;&nbsp; IQueryPersistent
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IP := IDispatch(Argument.dispVal)&nbsp;&nbsp;&nbsp; IQueryPersistent;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Получаем ссылку на&nbsp;&nbsp;&nbsp; класс, представителем которого
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // является интерфейс
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; I := Integer(IP.GetPersistent);
&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Иначе - очищаем свойство
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; I := 0;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Устанавливаем значение
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SetOrdProp(FOwner, PropInfo, I);
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ; 
</pre>
<p>Для чисел с плавающей точкой основной проблемой является отработка свойства типа TDateTime. Дополнительно обеспечим возможность установить это свойство в виде символьной строки. При установке свойства типа TDateTime необходимо обеспечить трансляцию его из формата TOleDate в TDateTime. </p>
<pre>
   tkFloat:
 
          (PropInfo^.PropType^ = System.TypeInfo(TDateTime))
            (PropInfo^.PropType^ = System.TypeInfo(TDate)) 
           // Проверяем тип данных аргумента
            Argument.vt = VT_BSTR 
             DT := StrToDate(Argument.bstrVal);
 
             ValidType(Argument, VT_DATE, TRUE);
              VariantTimeToSystemTime(Argument.date, ST) &lt;&gt; 0 
               DT := SystemTimeToDateTime(ST)
 
               Result := DISP_E_BADVARTYPE;
               Exit;
             ;
           ;
           SetFloatProp(FOwner, PropInfo, DT);
 
           // Проверяем тип данных аргумента
           ValidType(Argument, VT_R8, TRUE);
           // Устанавливаем значение
           SetFloatProp(FOwner, PropInfo, Argument.dblVal);
         ;
       ; 
</pre>
<p>Наиболее сложным случаем является установка данных типа &#171;набор&#187; (Set). Необходимо выделить из переданной символьной строки разделенные запятыми элементы, для каждого из них &#8211; проверить, является ли он допустимым для устанавливаемого свойства, и установить соответствующий бит в числе, которое будет установлено в качестве свойства. </p>
<pre>
  tkSet:
 
         // Проверяем тип данных, должна быть символьная строка
         ValidType(Argument, VT_BSTR, TRUE);
         // Получаем данные
         S := Trim(Argument.bstrVal);
         // Получаем информацию RTTI
         Data := GetTypeData(PropInfo^.PropType^);
         TypeInfo := Data^.CompType^;
         TypeData := GetTypeData(TypeInfo);
         I := 0;
          Length(S) &gt; 0 
           // Проходим по строке, выбирая разделенные запятыми
           // значения идентификаторов
           CommaPos := Pos(',', S);
            CommaPos = 0 
             CommaPos := Length(S) + 1;
           S1 := Trim(System.Copy(S, 1, CommaPos - 1));
           System.Delete(S, 1, CommaPos);
            Length(S1) &gt; 0 
             // Поверяем, какому из допустимых значений соответствует
             // полученный идентификатор
             K := 1;
             GoodToken := FALSE;
              J := TypeData^.MinValue  TypeData^.MaxValue 
 
                CompareText(S1, GetEnumName(TypeInfo , J)) = 0 
                 // Идентификатор найден, добавляем его в маску
                 I := I  K;
                 GoodToken := TRUE;
               ;
               K := K  1;
             ;
              GoodToken 
               // Идентификатор не найдет
               Result := DISP_E_BADVARTYPE;
               Exit;
             ;
           ;
         ;
         // Устанавливаем значение свойства
         SetOrdProp(FOwner, PropInfo, I);
       ;  
</pre>
<p>Свойство типа Variant установить несложно. </p>
<pre>
   tkVariant:
 
         // Проверяем тип данных аргумента
         ValidType(Argument, VT_VARIANT, TRUE);
         // Устанавливаем значение
         SetVariantProp(FOwner, PropInfo, Argument.pvarVal^);
       ;
 
      // Остальные типы данных OLE не поддерживаются
      Result := DISP_E_MEMBERNOTFOUND;
   ;
 ; 
</pre>
<p>Таким образом, мы реализовали полную функциональность по трансляции вызовов OLE в обращения к свойствам VCL. Наш компонент может динамически создавать другие компоненты на форме, обращаться к их свойствам и даже обрабатывать возникающие в них события. </p>
<p>Оператор For Each </p>
<p>Удобным средством, предоставляемым VBScript, является оператор For Each, организующий цикл по всем элементам заданной коллекции. Добавим поддержку этого оператора в наш компонент. </p>
<p>Интерфейс IEnumVariant </p>
<p>Реализация For Each предусматривает следующее: </p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Исполняющее ядро ScriptControl вызывает метод Invoke объекта, по элементам которого должен производиться цикл с DispID = DISPID_NEWENUM (-4). </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Объект должен вернуть интерфейс IenumVariant. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Далее ядро использует методы IEnumVariant для получения элементов коллекции. </td></tr></table></div><p>Интерфейс IEnumVariant определен как: </p>
<pre>
  IEnumVariant = (IUnknown)
     ['{00020404-0000-0000-C000-000000000046}']
      Next(celt: LongWord;  rgvar: OleVariant;
       pceltFetched: PLongWord): HResult; ;
      Skip(celt: LongWord): HResult; ;
      Reset: HResult; ;
     Clone(out Enum: IEnumVariant): HResult; ;
   ;
</pre>
<p>В модуле ActiveX.pas в оригинальной поставке Delphi5 ошибочно определен метод Next </p>
<p> &nbsp; Next(celt: LongWord;&nbsp; rgvar: OleVariant;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; pceltFetched: LongWord): HResult; ;&nbsp; </p>
<p>поэтому для корректной реализации интерфейс должен быть переопределен. </p>
<p>Класс TVCLEnumerator </p>
<p>Создадим класс, инкапсулирующий функциональность IEnumVariant. </p>
<pre>
  TVCLEnumerator = (TInterfacedObject, IEnumVariant)
 
     FEnumPosition: Integer;
     FOwner: TPersistent;
     FScriptControl: TVCLScriptControl;
     { IEnumVariant }
      Next(celt: LongWord;  rgvar: OleVariant;
       pceltFetched: PLongWord): HResult; ;
     Skip(celt: LongWord): HResult; ;
      Reset: HResult; ;
     Clone(Enum: IEnumVariant): HResult; ;
 
     Create(AOwner: TPersistent;
       AScriptControl: TVCLScriptControl);
   ;  
</pre>
<p>Конструктор устанавливает свойства FOwner и FScriptControl. </p>
<pre>
 TVCLEnumerator.Create(AOwner: TPersistent;
   AScriptControl: TVCLScriptControl);
 
   Create;
   FOwner := AOwner;
   FScriptControl := AScriptControl;
   FEnumPosition := 0;
 ;
</pre>
<p>Метод Reset подготавливает реализацию интерфейса к началу перебора. </p>
<p> TVCLEnumerator.Reset: HResult;</p>
<p> &nbsp; FEnumPosition := 0;</p>
<p> &nbsp; Result := S_OK;</p>
<p> ;&nbsp; </p>
<p>Главная функциональность сосредоточена в методе Next, который получает следующие переменные: </p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>celt &#8211; количество запрашиваемых элементов; </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>rgvar &#8211; адрес первого элемента массива переменных типа OleVariant; </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>pceltFetched &#8211; адрес переменной, в которую должно быть записано количество реально переданных элементов. Этот адрес может быть равен NIL, в этом случае не потребуется ничего записывать. </td></tr></table></div><p>Метод должен заполнить запрошенное количество элементов rgvar и вернуть S_OK, если это удалось, и S_FALSE, если элементов не хватило. </p>
<pre>
 TVariantList = [0..0] OleVariant;
 
 
 TVCLEnumerator.Next(celt: LongWord;  rgvar: OleVariant;
   pceltFetched: PLongWord): HResult;
 
   I: Cardinal;
 
   Result := S_OK;
   I := 0;  
</pre>
<p>Для объекта TWinControl возвращаем интерфейсы IDispatch для компонентов из свойства Controls. </p>
<p> &nbsp; FOwner&nbsp; TWinControl </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; TWinControl(FOwner) </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (FEnumPosition &lt; ControlCount)&nbsp; (I &lt; celt) </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TVariantList(rgvar)[I] :=</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FScriptControl.GetProxy(Controls[FEnumPosition]);</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Inc(I);</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Inc(FEnumPosition);</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ;</p>
<p> &nbsp;&nbsp;&nbsp; ;</p>
<p>Для TCollection организуется перебор элементов коллекции. </p>
<p> &nbsp; FOwner TCollection </p>
<p> &nbsp;&nbsp;&nbsp; TCollection(FOwner) </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (FEnumPosition &lt; Count) (I &lt; celt) </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TVariantList(rgvar)[I] :=</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FScriptControl.GetProxy(Items[FEnumPosition]);</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Inc(I);</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Inc(FEnumPosition);</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ;</p>
<p> &nbsp;&nbsp;&nbsp; ; </p>
<p>Для TStrings перебираются строки и возвращаются их значения. </p>
<p> &nbsp;&nbsp; FOwner TStrings </p>
<p> &nbsp;&nbsp;&nbsp; TStrings(FOwner) </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (FEnumPosition &lt; Count) (I &lt; celt) </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TVariantList(rgvar)[I] := TStrings(FOwner)[FEnumPosition];</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Inc(I);</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Inc(FEnumPosition);</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ;</p>
<p> &nbsp;&nbsp;&nbsp; ;</p>
<p> &nbsp;&nbsp;&nbsp; Result := S_FALSE;</p>
<p> &nbsp;&nbsp; I &lt;&gt; celt </p>
<p> &nbsp;&nbsp;&nbsp; Result := S_FALSE;</p>
<p> &nbsp;&nbsp; Assigned(pceltFetched) </p>
<p> &nbsp;&nbsp;&nbsp; pceltFetched^ := I;</p>
<p> ;&nbsp; </p>
<p>Метод Skip пропускает запрошенное количество элементов и возвращает S_OK, если еще остались элементы для перебора. </p>
<p>TVCLEnumerator.Skip(celt: LongWord): HResult;</p>
<p> &nbsp; Total: Integer;</p>
<p> &nbsp; Result := S_FALSE;</p>
<p> &nbsp;&nbsp; FOwner&nbsp; TWinControl </p>
<p> &nbsp;&nbsp;&nbsp; Total := TWinControl(FOwner).ControlCount</p>
<p> &nbsp;&nbsp; FOwner&nbsp; TCollection </p>
<p> &nbsp;&nbsp;&nbsp; Total := TCollection(FOwner).Count</p>
<p> &nbsp;&nbsp; FOwner&nbsp; TStrings </p>
<p> &nbsp;&nbsp;&nbsp; Total := TStrings(FOwner).Count</p>
<p> &nbsp;&nbsp;&nbsp; Exit;</p>
<p> &nbsp;&nbsp; FEnumPosition + celt &lt;= Total </p>
<p> &nbsp;&nbsp;&nbsp; Result := S_OK;</p>
<p> &nbsp;&nbsp;&nbsp; Inc(FEnumPosition, celt)</p>
<p> &nbsp; ;</p>
<p> ;&nbsp; </p>
<p>Метод Clone клонирует объект, возвращая интерфейс его копии. </p>
<p>TVCLEnumerator.Clone( Enum: IEnumVariant): HResult;</p>
<p> &nbsp; NewEnum: TVCLEnumerator;</p>
<p> &nbsp; NewEnum := TVCLEnumerator.Create(FOwner, FScriptControl);</p>
<p> &nbsp; NewEnum.FEnumPosition := FEnumPosition;</p>
<p> &nbsp; Enum := NewEnum&nbsp; IEnumVariant;</p>
<p> &nbsp; Result := S_OK;</p>
<p> ;&nbsp; </p>
<p>Для того чтобы класс TVCLProxy мог вернуть интерфейс IEnumVariant, требуется дополнить метод Invoke следующим кодом: </p>
<p>  DispId </p>
<p> &nbsp;&nbsp; DISPID_NEWENUM: </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // У объекта запрашивают интерфейс IEnumVariant для ForEach</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // создаем класс, реализующий этот интерфейс</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; OleVariant(VarResult^) := TVCLEnumerator.Create(FOwner,</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FScriptControl)&nbsp; IEnumVariant;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ;&nbsp; </p>
<p>Компонент TVCLScriptControl </p>
<p>Текст этого компонента приведен на CD-ROM. Данный компонент является наследником TScriptControl и реализует функциональность по работе с TVCLProxy. </p>
<p>Заключение </p>
<p>&nbsp;<br>
<p>&nbsp;</p>
<p>Microsoft ScriptControl &#8211; качественное решение для задач, требующих включения в программу интерпретирующего ядра. Интегрировав его с VCL, мы получаем мощный и гибкий инструмент, позволяющий наращивать возможности в любом направлении. Приведенной в данной статье информации вполне достаточно, чтобы на основе помещенного на компакт-диске компонента TVCLScriptControl создать решение, удовлетворяющее любой конкретной задаче. </p>
