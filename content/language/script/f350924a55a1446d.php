<h1>Использование Microsoft ScriptControl (статья)</h1>
<div class="date">01.01.2007</div>


Введение</p>
<p>При разработке настраиваемых информационных систем часто возникает необходимость добавить в свою программу встроенный язык программирования. Такой язык позволял бы конечным пользователям настраивать поведение программы без участия автора и без перекомпиляции. Однако самостоятельная реализация интерпретатора является задачей непосильной для многих разработчиков, а для большинства остальных потребует очень много времени и усилий.</p>
<p>В то же время, в Windows, как правило, уже имеется достаточно качественный интерпретатор, который может быть легко встроен в Вашу программу. Речь идет о Microsoft ScriptControl. Он стандартно устанавливается с Internet Explorer, входит в Windows 2000 и Windows 98, а для младших версий доступен в виде свободно распространяемого отдельного дистрибутива, объем которого составляет около 200 КБ. Получить его можно по адресу http://msdn.microsoft.com/scripting. В дистрибутив входит ActiveX-компонент и файл помощи с описанием его свойств и методов.</p>

Добавление TScriptControl в программу</p>
Импорт ActiveX сервера</p>
<p>Чтобы добавить Microsoft ScriptControl на палитру компонентов Delphi необходимо импортировать ActiveX компонент, под названием Microsoft Script Control</p>
<p><img src="/pic/embim1699.png" width="458" height="528" vspace="1" hspace="1" border="0" alt=""></p>
<p>После этого на закладке ActiveX появится не визуальный компонент TScriptControl, который можно разместить на форме.</p>

Настройка свойств и вызов скриптов</p>
<p>Рассмотрим ключевые свойства и методы TScriptControl.</p>
<p>property Language: String</p>
<p>Задает язык, интерпретатор которого будет реализовывать компонент. В стандартной поставке доступны VBScript и JScript, однако, если в вашей системе установлены расширения Windows Scripting, возможно использование других языков, таких как Perl или Rexx</p>
<p>property Timeout: Integer</p>
<p>Задает интервал исполнения скрипта, по истечении которого генерируется ошибка. Значение &#8211;1 позволяет отключить ошибки таймаута и позволить скрипту исполняться неограниченное время</p>
<p>property UseSafeSubset: Boolean</p>
<p>При установке этого свойства в TRUE компонент может выполнять ограниченный набор действий, заданный текущими установками безопасности в системе. Использование этого свойства полезно, если Вы запускаете скрипты, полученные, например, по Интернет.</p>
<p>procedure AddCode(const Code: WideString);</p>
<p>Добавляет код, заданный параметром к списку процедур компонента. В дальнейшем эти процедуры могут быть вызваны при помощи метода Run, либо из других процедур скрипта.</p>
<p>  ScriptControl1.AddCode(Memo1.Text);</p>
<p>function Eval(const Expression: WideString): OleVariant</p>
<p>Выполняет код, заданный в параметре Expression и возвращает результат исполнения. Позволяет выполнить код без добавления его к списку процедур компонента.</p>
<p>procedure AddObject(const Name: WideString; Object_: IDispatch; AddMembers: WordBool);</p>
<p>Добавляет объект к пространству имен компонента. Объект должен быть OLE-automation сервером. Добавленный объект доступен как объект в коде скрипта. Например, если в программе создан Automation сервер External, реализующий метод DoSomething(Value: Integer), то добавив объект</p>
<p> ScriptControl1.AddObject('External', TExternal as IDispatch, FALSE);</p>
<p>Мы можем в коде скрипта использовать его следующим образом:</p>
<p>Dim I</p>
<p>I = 8 + External.DoSomething(8)</p>
<p>function Run(const ProcedureName: WideString; var Parameters: PSafeArray): OleVariant;</p>
<p>Выполняет именованную процедуру из числа ранее добавленных при помощи метода AddCode. В массиве Parameters могут быть переданы параметры</p>
<p>procedure Reset;</p>
<p>Сбрасывает компонент в начальное состояние, удаляя все добавленные ранее объекты и код.</p>
<p>Таким образом, TScriptControl представляет собой достаточно гибкую исполняющую систему с возможностями расширения путем добавления в её пространство имен серверов автоматизации OLE.</p>

Использование Microsoft ScriptControl</p>

Интеграция TScriptControl с VCL</p>
<p>В существующем виде возможности TScriptControl сильно ограничены сложным доступом к классам VCL. Исполнение интерпретируемого кода &#8211; это хорошо, однако хотелось бы иметь возможность их него обращаться к компонентам в программе, получать и устанавливать их свойства, обрабатывать возникающие в них события, например следующим образом:</p>

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


<p>Дальнейшая часть главы посвящена реализации такой функциональности, однако, прежде чем приступить к этому, необходимо более подробно рассмотреть некоторые механизмы, лежащие в основе модели расширения TScriptControl и VCL</p>

Модель расширения ScriptControl</p>
<p>Как уже было рассмотрено выше, Microsoft ScriptControl позволяет сделать доступными из скрипта объекты, реализованные в программе при помощи метода AddObject. При обращении к таким объектам он предполагает, что они реализуют интерфейс IDispatch и являются, таким образом, OLE-automation серверами. В Delphi в качестве таких объектов могут выступать наследники TAutoObject, создать которых можно при помощи мастера, вызываемого из меню File -&gt; New -&gt; ActiveX -&gt; Automation Object. При вызове методов этих объектов ScriptControl последовательно вызывает методы GetIdsOfNames и Invoke их интерфейса IDispatch, что приводит к вызовам соответствующих методов объекта. Однако здесь имеются определенные сложности:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>По окончании работы с объектом (например, при выходе его за пределы области видимости процедуры скрипта) TScriptControl автоматически вызывает его метод _Release, что приведет к уничтожению класса Delphi. Таким образом, для каждого класса приходится создавать некий объект-представитель, который бы транслировал вызовы TScriptControl в методы и свойства класса Delphi, а при исчезновении необходимости &#8211; уничтожался, не уничтожая самого класса</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Функциональность наследников TAutoObject задается на этапе компиляции и не может быть расширена в процессе исполнения программы. Это заставляет создавать отдельных представителей для каждого класса VCL, что очень сложно в реализации и не позволяет использовать классы, для которых нет соответствующего представителя.</td></tr></table></div>Чтобы понять пути обхода этой проблемы необходимо более детально вникнуть в реализацию базового интерфейса, лежащего в основе автоматизации OLE</p>

Интерфейс IDispatch</p>
<p>Интерфейс IDispatch обеспечивает возможность позднего связывания, т.е. вызовов методов объектов не по адресам, а по именам на этапе выполнения программы. Интерфейс определен как:</p>

<pre>
type
  IDispatch = interface(IUnknown)
    ['{00020400-0000-0000-C000-000000000046}']
    function GetTypeInfoCount(out Count: Integer): Integer; stdcall;
    function GetTypeInfo(Index, LocaleID: Integer; 
      out TypeInfo): Integer; stdcall;
    function GetIDsOfNames(const IID: TGUID; Names: Pointer;
      NameCount, LocaleID: Integer; DispIDs: Pointer): Integer;
      stdcall;
    function Invoke(DispID: Integer; const IID: TGUID; 
      LocaleID: Integer; Flags: Word; var Params; VarResult,
      ExcepInfo, ArgErr: Pointer): Integer; stdcall;
  end;
</pre>

<p>Ключевыми методами интерфейса являются GetIdsOfNames и Invoke.</p>

function GetIdsOfNames</p>
<p>Этот метод осуществляет трансляцию имен методов и свойств объекта автоматизации в целочисленные идентификаторы. Если OLE пытается разрешить ссылку вида:</p>
<p>SomeObject.DoSomeThing</p>
<p>Она запрашивает у SomeObject интерфейс IDispatch и вызывает метод GetIdsOfNames, передавая ему ссылку на массив имен требующих разрешения в параметре Names, количество имен в параметре NameCount и региональный контекст в параметре LocaleId. Метод должен заполнить массив, на который указывает параметр DispIds значениями идентификаторов имен. Объект имеет возможность предоставить разные имена методов для каждого поддерживаемого языка. Если это не нужно &#8211; Вы можете игнорировать параметр LocaleId.</p>
<p>Стандартная реализация IDispatch ищет информацию об именах методов и их идентификаторах в библиотеке типов объекта, однако, программист вполне может взять эту работу на себя и осуществлять самостоятельную трансляцию.</p>
function Invoke</p>
<p>После получения идентификатора запрошенного метода OLE вызывает функцию Invoke, передавая в неё:</p>
<p>DispID</p>
<p>Идентификатор вызываемого метода или свойства, полученный от GetIdsOfNames</p>
<p>LocaleId</p>
<p>Региональный контекст (тот же, что и в GetIdsOfNames)</p>
<p>Flags</p>
<p>Битовая маска, состоящая из следующих флагов</p>
Значение &nbsp; &nbsp; &nbsp; &nbsp;Комментарий &nbsp; &nbsp; &nbsp; 
DISPATCH_METHOD &nbsp; &nbsp; &nbsp; &nbsp;Вызывается метод. Если у объекта есть свойство с таким же именем, то будет установлен также флаг DISPATCH_PROPERTYGET &nbsp; &nbsp; &nbsp; 
DISPATCH_PROPERTYGET &nbsp; &nbsp; &nbsp; &nbsp;Запрашивается значение свойства &nbsp; &nbsp; &nbsp; 
DISPATCH_PROPERTYPUT &nbsp; &nbsp; &nbsp; &nbsp;Устанавливается значение свойства &nbsp; &nbsp; &nbsp; 
<p>DISPATCH_PROPERTYPUTREF &nbsp; &nbsp; &nbsp; &nbsp;Параметр передается по ссылке. Если флаг не установлен &#8211; по значению &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>Params</p>
<p>Структура DISPPARAMS, содержащая массив параметров, массив идентификаторов для именованных параметров, и количества элементов в этих массивах. Параметры передаются в порядке, обратном их порядку следования в функции, как это принято в Visual Basic</p>
<p>VarResult</p>
<p>Адрес переменной типа OleVariant, в которую должен быть помещен результат вызова метода или значение свойства или NIL, если возвращаемое значение не требуется.</p>
<p>ExcepInfo</p>
<p>Адрес структуры EXCEPTINFO, которую метод должен заполнить информацией об ошибке, если она возникнет.</p>
<p>ArgErr</p>
<p>Адрес массива, в который должны быть помещены индексы неверных параметров, в случае, если такая ситуация будет обнаружена.</p>
<p>При вызове Invoke не осуществляется никаких проверок, поэтому при его самостоятельной реализации необходимо соблюдать аккуратность при работе с переданными адресами массивов и переменных.</p>
<p>Как видно из описания IDispatch &#8211; имеется возможность самостоятельно реализовать этот интерфейс, динамически преобразуя обращения к объекту автоматизации в обращения к соответствующим свойствам классов Delphi.</p>
&nbsp;</p>
Информация RTTI Delphi</p>
<p>Delphi имеет свой внутренний протокол, позволяющий осуществлять обращение к опубликованным (объявленным в секции published) свойствам и методам класса. Для этого служат функции модуля TypInfo.pas. Ключевой является функция</p>
<p>function GetPropInfo(TypeInfo: PTypeInfo;</p>
<p>  const PropName: String): PPropInfo;</p>
<p>которая позволяет по имени свойства получить адрес структуры PPropInfo, содержащей информацию о свойстве. В дальнейшем можно получить значение этого свойства при помощи функций GetXXXProp или установить его функциями SetXXXProp. При этом будут корректно вызваны функции получения или установки свойства. Таким образом, у нас есть возможность по имени свойства определить его наличие и установить или получить его значение. Такая возможность позволяет нам создать реализацию IDispatch, динамически транслирующую обращения к свойствам зарегистрированного в TScriptControl объекта автоматизации в обращения к свойствам связанного с ним экземпляра класса VCL</p>
Сводим воедино</p>
<p>Итак, как рассмотрено выше &#8211; RTTI Delphi предоставляет достаточную функциональность для того, чтобы обеспечить трансляцию вызовов OLE-Automation в обращения к свойствам компонентов VCL. Для этого необходимо:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>В методе GetIdsOfNames проверить существование свойства, при помощи функции GetPropInfo и, если такое свойство найдено &#8211; вернуть какой-нибудь числовой идентификатор. В роли такого идентификатора удобно использовать результат, возвращаемый функцией GetPropInfo.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>В методе Invoke &#8211; установить или получить значение свойства, используя функции GetXXXProp или SetXXXProp.</td></tr></table></div><p>Для трансляции вызовов OLE в VCL создадим класс TVCLProxy</p>
<pre>
type
  // Этот интерфейс понадобится для получения ссылки на 
  // класс VCL из методов, в которые передается его
  // интерфейс IDispatch
  IQueryPersistent = interface
 ['{26F5B6E1-9DA5-11D3-BCAD-00902759A497}']
    function GetPersistent: TPersistent;
  end;
 
  TVCLProxy = class(TInterfacedObject, IDispatch, IQueryPersistent)
  private
    FOwner: TPersistent;
    FScriptControl: TVCLScriptControl;
    procedure DoCreateControl(AName, AClassName: WideString;
      WithEvents: Boolean);
    function SetVCLProperty(PropInfo: PPropInfo; 
      Argument: TVariantArg): HRESULT;
    function GetVCLProperty(PropInfo: PPropInfo; dps: TDispParams;
      PDispIds: PDispIdList; var Value: OleVariant): HRESULT;
    { IDispatch }
    function GetTypeInfoCount(out Count: Integer): HResult; stdcall;
    function GetTypeInfo(Index, LocaleID: Integer; 
      out TypeInfo): HResult; stdcall;
    function GetIDsOfNames(const IID: TGUID; Names: Pointer;
      NameCount, LocaleID: Integer; 
      DispIDs: Pointer): HResult; stdcall;
    function Invoke(DispID: Integer; const IID: TGUID; 
      LocaleID: Integer; Flags: Word; var Params; 
      VarResult, ExcepInfo, ArgErr: Pointer): HResult; stdcall;
    { IQueryPersistent }
    function GetPersistent: TPersistent;
  protected
    function DoInvoke (DispID: Integer; const IID: TGUID; 
      LocaleID: Integer; Flags: Word; var dps : TDispParams; 
      pDispIds : PDispIdList; VarResult, ExcepInfo, 
      ArgErr: Pointer): HResult; virtual;
  public
    constructor Create(AOwner: TPersistent; 
      ScriptControl: TVCLScriptControl);
    destructor Destroy; override;
  end;
</pre>
<p>Экземпляр этого класса создается при регистрации объекта в TScriptControl и уничтожается автоматически, когда необходимость в нем исчезает.</p>
<p>Поле FOwner хранит ссылку на экземпляр класса VCL, интерфейс к которому предоставляет этот объект. TVCLScriptControl &#8211; это наследник TScriptControl.</p>
<p>Главным его отличием является наличие списка зарегистрированных экземпляров TVCLProxy и обработчиков событий, позволяющих компонентам VCL вызывать методы скрипта.</p>
<p>Здесь рассмотрены лишь ключевые моменты реализации, полный код, вместе с примером использования, приведен на компакт диске.</p>
&nbsp;</p>
Пишем GetIdsOfNames</p>
<p>В методе GetIdsOfNames мы должны проверить наличие запрошенного свойства и вернуть адрес его структуры TPropInfo, если такое свойство найдено.</p>
<p>Свойства компонентов VCL</p>
<pre>
function TVCLProxy.GetIDsOfNames(const IID: TGUID; Names: Pointer;
  NameCount, LocaleID: Integer; DispIDs: Pointer): HResult;
var
  S: String;
  Info: PPropInfo;
begin
  Result := S_OK;
  // Получаем имя функции или свойства
  S := PNamesArray(Names)[0];
  // Проверяем, есть ли VCL свойство с таким-же именем
  Info := GetPropInfo(FOwner.ClassInfo, S);
  if Assigned(Info) then begin
    // Свойство есть, возвращаем в качестве DispId
    // адрес структуры PropInfo
    PDispIdsArray(DispIds)[0] := Integer(Info);
  end 
</pre>

<p>Дополнительные функции</p>
<p>Дополним нашу реализацию возможностью вызова некоторых дополнительных функций:</p>
<p>Controls</p>
<p>Для наследников TWinControl возвращает ссылку на дочерний компонент с именем или индексом, заданным в параметре</p>
<p>Count</p>
<p>Для компонентов TWinControl &#8211; возвращает количество дочерних компонентов</p>
<p>Для TCollection &#8211; возвращает количество элементов</p>
<p>Для TStrings &#8211; возвращает количество строк</p>
<p>Add</p>
<p>Для компонентов TWinControl &#8211; создает дочерний компонент</p>
<p>Для TCollection &#8211; добавляет элемент в коллекцию</p>
<p>Для TStrings &#8211; добавляет строку</p>
<p>HasProperty</p>
<p>Возвращает истину, если у объекта есть свойство с заданным именем</p>
<p>Для этого дополним метод GetIdsOfNames следующим кодом:</p>
<pre>
  else
  // Нет такого свойства, проверяем, не имя ли это
  // одной из определенных нами функций
  if CompareText(S, 'CONTROLS') = 0 then begin
    if (FOwner is TWinControl) then
      PDispIdsArray(DispIds)[0] := DISPID_CONTROLS
    else
      Result := DISP_E_UNKNOWNNAME;
  end
  else
  if CompareText(S, 'COUNT') = 0 then begin
    if (FOwner is TCollection) or (FOwner is TStrings)
       or (FOwner is TWinControl) then
      PDispIdsArray(DispIds)[0] := DISPID_COUNT
    else
      Result := DISP_E_UNKNOWNNAME;
  end
  else
  if CompareText(S, 'ADD') = 0 then begin
    Result := S_OK;
    if (FOwner is TCollection) or (FOwner is TStrings) or
       (FOwner is TWinControl) then
      PDispIdsArray(DispIds)[0] := DISPID_ADD
    else
      Result := DISP_E_UNKNOWNNAME;
  end
  else
  if CompareText(S, 'HASPROPERTY') = 0 then
    PDispIdsArray(DispIds)[0] := DISPID_HASPROPERTY
  else
    Result := DISP_E_UNKNOWNNAME;
end;
</pre>

<p>Константы DISPID_CONTROLS, DISPID_COUNT и т.д. определены как целые числа из диапазона 1 … 1 000 000. Это вполне безопасно, т.к. адрес структуры TPropInfo никак не может оказаться ниже 1 Мб</p>
Пишем Invoke</p>
<p>Первая часть задачи выполнена &#8211; мы проинформировали OLE о наличии в нашем сервере автоматизации поддерживаемых функций. Теперь необходимо реализовать метод Invoke для выполнения этих функций. Из соображений модульности Invoke выполняет подготовительную работу со списком параметров и вызывает метод DoInvoke, в котором мы осуществляем трансляцию DispID в обращения к методам класса VCL.</p>
<p>В методе используются три служебных функции:</p>
<p>CheckArgCount &#8211; проверяет количество переданных аргументов</p>
<p>_ValidType &#8211; проверяет соответствие аргумента с заданным индексом заданному типу</p>
<p>_IntValue &#8211; получает целое число из аргумента с заданным индексом</p>
<pre>
function TVCLProxy.DoInvoke(DispID: Integer; const IID: TGUID;
  LocaleID: Integer; Flags: Word; var dps: TDispParams;
  pDispIds: PDispIdList; VarResult, ExcepInfo, ArgErr: Pointer
  ): HResult;
var
  S: String;
  Put: Boolean;
  I: Integer;
  P: TPersistent;
  B: Boolean;
  OutValue: OleVariant;
begin
  Result := S_OK;
  case DispId of
</pre>

<p>Для функции Controls мы должны проверить, что передан один параметр. Если он строковый &#8211; дочерний компонент ищется по имени, иначе &#8211; по индексу. Если компонент найден &#8211; вызывается функция FScriptControl.GetProxy, которая проверяет, есть ли уже «представитель» у этого компонента, при необходимости создает его и возвращает интерфейс IDispatch. Такой алгоритм необходим для корректной работы оператора VBScript Is, который сравнивает две ссылки на объект и выдает истину, если это один и тот же объект, например:</p>
<pre>
Dim A
Dim B
Set A = C
Set B = C
If A is B Then ...
</pre>
<p>Если создавать TVCLProxy при каждом случае, когда запрашивается ссылка &#8211; они окажутся разными, и оператор Is не будет работать.</p>
<pre>
   DISPID_CONTROLS:
      begin  // Вызвана функция Controls
        with FOwner as TWinControl do
        begin
          // Проверяем параметр
          CheckArgCount(dps.cArgs, [1], TRUE);
          P := NIL;
          if _ValidType(0, VT_BSTR, FALSE) then begin
            // Если параметр - строка - ищем дочерний компонент
            // с таким именем
            S := dps.rgvarg^[pDispIds^[0]].bstrVal;
            for I := 0 to Pred(ControlCount) do
              if CompareText(S, Controls[I].Name) = 0 then begin
                P := Controls[I];
                Break;
              end;
          end else begin
            // Иначе - параметр - число, берем компонент по индексу
            I := _IntValue(0);
            P := Controls[I];
          end;
          if not Assigned(P) then
            // Компонент не найден
            raise EInvalidParamType.Create('');
          // Возвращаем интерфейс IDispatch для найденного компонента
          OleVariant(VarResult^) := FScriptControl.GetProxy(P);
        end;
      end;
</pre>
<p>Функция Count должна вызываться без параметров и возвращает количество элементов в запрашиваемом объекте.</p>
<pre>
   DISPID_COUNT:
      begin // Вызвана функция Count
        // Проверяем, что не было параметров
        CheckArgCount(dps.cArgs, [0], TRUE);
        if FOwner is TWinControl then
          // Возвращаем количество дочерних компонентов
          OleVariant(VarResult^) := TWinControl(FOwner).ControlCount;
        else
        if FOwner is TCollection then
          // Возвращаем количество элементов коллекции
          OleVariant(VarResult^) := TCollection(FOwner).Count
        else
        if FOwner is TStrings then
          // Возвращаем количество строк
          OleVariant(VarResult^) := TStrings(FOwner).Count;
      end;
</pre>

<p>Метод Add добавляет элемент к объекту-владельцу «представителя». Обратите внимание на реализацию необязательных параметров для TWinControl и TStrings</p>
<pre>
 
   DISPID_ADD:
      begin  // Вызвана функция Add
        if FOwner is TWinControl then begin
          // Проверяем количество аргументов
          CheckArgCount(dps.cArgs, [2,3], TRUE);
          // Проверяем типы обязательных аргументов
          _ValidType(0, VT_BSTR, TRUE);
          _ValidType(1, VT_BSTR, TRUE);
          // Третий аргумент - необязательный, если он не задан -
          // полагаем FALSE
          if (dps.cArgs = 3) and _ValidType(2, VT_BOOL, TRUE) then
            B := dps.rgvarg^[pDispIds^[0]].vbool
          else
            B := FALSE;
          // Вызываем метод для создания компонента
          DoCreateControl(dps.rgvarg^[pDispIds^[0]].bstrVal,
            dps.rgvarg^[pDispIds^[1]].bstrVal, B);
        end
        else
        if FOwner is TCollection then begin
          // Добавляем компонент
          P := TCollection(FOwner).Add;
          // И возвращаем его интерфейс IDispatch
          OleVariant(varResult^) := FScriptControl.GetProxy(P);
        end
        else
        if FOwner is TStrings then begin
          // Проверяем наличие аргументов
          CheckArgCount(dps.cArgs, [1,2], TRUE);
          // Проверяем, что аргумент – строка
          _ValidType(0, VT_BSTR, TRUE);
          if dps.cArgs = 2 then
            // Второй аргумент - позиция в списке
            I := _IntValue(1)
          else
            // Если его нету - вставляем в конец
            I := TStrings(FOwner).Count;
          // Добавляем строку
          TStrings(FOwner).Insert(I,
            dps.rgvarg^[pDispIds^[0]].bstrVal);
        end;
      end;
</pre>
<p>И, наконец, функция HasProperty проверяет наличие у объекта VCL опубликованного свойства с заданным именем</p>
<pre>
   DISPID_HASPROPERTY:
     begin // Вызвана функция HasProperty
        // Проверяем наличие аргумента
        CheckArgCount(dps.cArgs, [1], TRUE);
        // Проверяем тип аргумента
        _ValidType(0, VT_BSTR, TRUE);
        S := dps.rgvarg^[pDispIds^[0]].bstrVal;
        // Возвращаем True, если свойство есть
        OleVariant(varResult^) := 
          Assigned(GetPropInfo(FOwner.ClassInfo, S));
      end;
</pre>

<p>Если ни один из DispID не обработан &#8211; значит DispID содержит адрес структуры TPropInfo свойства VCL</p>
<pre>
  else
    // Это не наша функция, значит это свойство
    // Проверяем Flags, чтобы узнать устанавливается значение
    // или получается
    Put := (Flags and DISPATCH_PROPERTYPUT) &lt;&gt; 0;
    if Put then begin
      // Устанавливаем значение
      // Проверяем наличие аргумента
      CheckArgCount(dps.cArgs, [1], TRUE);
      // И устанавливаем свойство
      Result := SetVCLProperty(PPropInfo(DispId), 
        dps.rgvarg^[pDispIds^[0]])
    end
    else
    begin
      // Получаем значение
      if DispId = 0 then begin
        // DispId = 0 - требуется свойство по умолчанию
        // Возвращаем свой IDispatch
        OleVariant(VarResult^) := Self as IDispatch;
        Exit;
      end;
      // Получаем значение свойства
      Result := GetVCLProperty(PPropInfo(DispId), 
        dps, pDispIds, OutValue);
      if Result = S_OK then
        // Получили успешно - сохраняем результат
        OleVariant(VarResult^) := OutValue;
    end;
  end;
end;
</pre>

<p>Добавление собственных функций</p>
<p>Для добавления функций, которые понадобятся для решения ваших задач необходимо выполнить ряд простых шагов:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>В методе GetIdsOfNames проанализировать имя запрашиваемой функции и определить, может ли она быть вызвана для объекта, на который ссылается FOwner</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Если функция может быть вызвана, Вы должны вернуть уникальный DispID, в противном случае &#8211; присвоить Result := DISP_E_UNKNOWNNAME</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>В методе Invoke необходимо обнаружить свой DispID, проверить корректность переданных параметров, получить их значения и выполнить действие.</td></tr></table></div><p>Обработка событий в компонентах VCL</p>
<p>Важным дополнением к реализуемой функциональности является возможность ассоциировать процедуру на VBScript с событием в компоненте VCL, таким, как OnEnter, OnClick или OnTimer. Для этого добавим в компонент TVCLScriptControl методы, которые будут служить обработчиками созданных в коде скрипта компонентов</p>
<pre>
  TVCLScriptControl = class(TScriptControl)
  …
  published
    procedure OnChangeHandler(Sender: TObject);
    procedure OnClickHandler(Sender: TObject);
    procedure OnEnterHandler(Sender: TObject);
    procedure OnExitHandler(Sender: TObject);
    procedure OnTimerHandler(Sender: TObject);
  end;
</pre>

<p>В методе DoCreateControl, который вызывается из DoInvoke при обработке метода «Add», реализуем подключение соответствующих обработчиков событий создаваемого компонента к созданным методам</p>
<pre>
procedure TVCLProxy.DoCreateControl(AName, AClassName: WideString;
  WithEvents: Boolean);
 
  procedure SetHandler(Control: TPersistent; Owner: TObject; 
    Name: String);
    // Функция устанавливает обработчик события Name на метод формы
    // с именем Name + 'Handler'
  var
    Method: TMethod;
    PropInfo: PPropInfo;
  begin
    // Получаем информацию RTTI
    PropInfo := GetPropInfo(Control.ClassInfo, Name);
    if Assigned(PropInfo) then begin
      // Получаем адрес обработчика
      Method.Code := FScriptControl.MethodAddress(Name + 'Handler');
      if Assigned(Method.Code) then begin
        // Обработчик есть
        Method.Data := FScriptControl;
        // Устанавливаем обработчик
        SetMethodProp(Control, PropInfo, Method);
      end;
    end;
  end;
var
  ThisClass: TControlClass;
  C: TComponent;
  NewOwner: TCustomForm;
begin
  // Назначаем свойство Owner на форму
  if not (FOwner is TCustomForm) then
    NewOwner := GetParentForm(FOwner as TControl)
  else
    NewOwner := FOwner as TCustomForm;
  // Получаем класс создаваемого компонента
  ThisClass := TControlClass(GetClass(AClassName));
  // Создаем компонент
  C := ThisClass.Create(NewOwner);
  // Назначаем имя
  C.Name := AName;
  if C is TControl then
    // Назначаем свойство Parent
    TControl(C).Parent := FOwner as TWinControl;
  if WithEvents then begin
    // Устанавливаем обработчики
    SetHandler(C, NewOwner, 'OnClick');
    SetHandler(C, NewOwner, 'OnChange');
    SetHandler(C, NewOwner, 'OnEnter');
    SetHandler(C, NewOwner, 'OnExit');
    SetHandler(C, NewOwner, 'OnTimer');
  end;
  // Создаем класс реализующий интерфейс IDispatch и добавляем его
  // в пространство имен TScriptControl
  FScriptControl.RegisterClass(AName, C);
end;
</pre>
<p>Таким образом, если третьим параметром метода «Add» будет задано True, то TVCLScriptControl установит обработчики событий OnClick, OnChange, OnEnter, OnExit и OnTimer на свои методы, реализованные следующим образом:</p>
<pre>
procedure TVCLScriptControl.OnClickHandler(Sender: TObject);
begin
  RunProc((Sender as TComponent).Name + '_' + 'OnClick');
end;
</pre>

<p>Примером использования данной функциональности может служить следующий код:</p>
<pre>Sub Main()
  Self.Add "Timer1", "TTimer", True
  With Timer1
    .Interval = 1000
    .Enabled = True
  End With
End Sub
Sub Timer1_OnTimer()
  Self.Caption = CStr(Time)
End Sub
</pre>
<p>Если требуется назначить обработчики событий имеющихся на форме компонентов &#8211; это может быть сделано в коде</p>
<p>  Button1.OnClick := ScriptControl1.OnClickHandler;</p>
<p>или реализацией соответствующего метода в GetIdsOfNames и Invoke</p>
<p>Получение свойств</p>
<p>Для получения свойств классов VCL служит метод GetVCLProperty. В нем осуществляется трансляция типов данных Object Pascal в типы данных OLE.</p>
<pre>
function TVCLProxy.GetVCLProperty(PropInfo: PPropInfo; 
  dps: TDispParams; PDispIds: PDispIdList; var Value: OleVariant
  ): HResult;
var
  I, J, K: Integer;
  S: String;
  P, P1: TPersistent;
  Data: PTypeData;
  DT: TDateTime;
  TypeInfo: PTypeInfo;
begin
  Result := S_OK;
  case PropInfo^.PropType^.Kind of
</pre>

<p>Для данных строкового и целого типа Delphi осуществляет автоматическую трансляцию</p>
<pre>
    tkString, tkLString, tkWChar, tkWString:
      // Символьная строка
      Value := GetStrProp(FOwner, PropInfo);
    tkChar, tkInteger:
      // Целое число
      Value := GetOrdProp(FOwner, PropInfo);
</pre>
<p>Для перечисляемых типов OLE не имеет прямых аналогов. Поэтому для всех типов, кроме Boolean будем передавать символьную строку с именем соответствующей константы. Для Boolean имеется подходящий тип данных и этот случай необходимо обрабатывать отдельно</p>
<pre>
    tkEnumeration:
      begin
        // Проверяем, не Boolean ли это
        if CompareText(PropInfo^.PropType^.Name, 'BOOLEAN') = 0 then
          // Передаем как Boolean
          Value := Boolean(GetOrdProp(FOwner, PropInfo));
        else begin
          // Остальные - передаем как строку
          I := GetOrdProp(FOwner, PropInfo);
          Value := GetEnumName(PropInfo^.PropType^, I);
        end;
      end;
</pre>
<p>Самым сложным случаем является свойство объектного типа. Нормальным поведением будет возврат интерфейса IDispatch, позволяющего OLE обращаться к методам класса, на который ссылается свойство. Однако, для некоторых классов, имеющих свойства «по умолчанию», таких как TStrings и TCollection свойство может быть запрошено с индексом. В этом случае надо выдать соответствующий индексу элемент. В то же время, будучи запрошено без индекса, свойство должно выдать интерфейс IDispatch для работы с экземпляром TCollection или TStrings.</p>
<pre>
    tkClass:
      begin
        // Получаем значение свойства
        P := TPersistent(GetOrdProp(FOwner, PropInfo));
        if Assigned(P) and (P is TCollection) 
           and (dps.cArgs = 1) then begin
          // Запрошен элемент коллекции с индексом (есть параметр)
          if ValidType(dps.rgvarg^[pDispIds^[0]], VT_BSTR,
              FALSE) then begin
            // Параметр строковый, ищем элемент по свойству
            // DisplayName
            S := dps.rgvarg^[pDispIds^[0]].bstrVal;
            P1 := NIL;
            for I := 0 to Pred(TCollection(P).Count) do
              if CompareText(S, 
                TCollection(P).Items[I].DisplayName)  = 0 then begin
                P1 := TCollection(P).Items[I];
                Break;
              end;
            if Assigned(P1) then
              // Найден - возвращаем интерфейс IDispatch
              Value := FScriptControl.GetProxy(P1)
            else
              // Не найден
              Result := DISP_E_MEMBERNOTFOUND;
          end else begin
            // Параметр целый, возвращаем элемент по индексу
            I := IntValue(dps.rgvarg^[pDispIds^[0]]);
            if (I &gt;= 0) and (I &lt; TCollection(P).Count) then begin
              P := TCollection(P).Items[I];
              Value := FScriptControl.GetProxy(P);
            end else
              Result := DISP_E_MEMBERNOTFOUND;
          end;
        end
</pre>
<p>Для класса TStrings результатом будет не интерфейс, а строка, выбранная по имени или по индексу</p>
<pre>
        else
        if Assigned(P) and (P is TStrings) and (dps.cArgs = 1) then 
        begin
          // Запрошен элемент из Strings с индексом (есть параметр)
          if ValidType(dps.rgvarg^[pDispIds^[0]], VT_BSTR, 
            FALSE) then begin
            // Параметр строковый - возвращаем значение свойства 
            // Values
            S := dps.rgvarg^[pDispIds^[0]].bstrVal;
            Value := TStrings(P).Values[S];
          end else begin
            // Параметр целый, возвращаем строку по индексу
            I := IntValue(dps.rgvarg^[pDispIds^[0]]);
            if (I &gt;= 0) and (I &lt; TStrings(P).Count) then
              Value := TStrings(P)[I]
            else
              Result := DISP_E_MEMBERNOTFOUND;
          end;
        end
        else
          // Общий случай, возвращаем интерфейс IDispatch свойства
          if Assigned(P) then
            Value := FScriptControl.GetProxy(P)
          else
            // Или Unassigned, если оно = NIL
            Value := Unassigned;
      end
</pre>
<p>;</p>
<p>У чисел с плавающей точкой также есть особенный тип данных &#8211; TDateTime. Его надо обрабатывать не так, как остальные числа с плавающей точкой, поскольку него в OLE есть отдельный тип данных OleDate.</p>
<pre>
    tkFloat:
      begin
        if (PropInfo^.PropType^ = System.TypeInfo(TDateTime)) or
           (PropInfo^.PropType^ = System.TypeInfo(TDate)) then
        begin
          // Помещаем значение свойства в промежуточную
          // переменную типа TDateTime
          DT := GetFloatProp(FOwner, PropInfo);
          Value := DT;
        end else
          Value := GetFloatProp(FOwner, PropInfo);
      end;
</pre>
<p>В случае свойства типа «набор» (Set), не имеющего аналогов в OLE будем возвращать строку с установленными значениями набора, перечисленными через запятую</p>
<pre>
    tkSet:
      begin
        // Получаем значение свойства (битовая маска)
        I := GetOrdProp(FOwner, PropInfo);
        // Получаем информацию RTTI
        Data := GetTypeData(PropInfo^.PropType^);
        TypeInfo := Data^.CompType^;
        // Формируем строку с набором значений
        S := '';
        if I &lt;&gt; 0 then begin
          for K := 0 to 31 do begin
            J := 1 shl K;
            if (J and I) = J then
              S := S + GetEnumName(TypeInfo, K) + ',';
          end;
          // Удаляем запятую в конце
          System.Delete(S, Length(S), 1);
        end;
        Value := S;
      end;
</pre>
<p>И, наконец, тип Variant не вызывает никаких сложностей.</p>
<pre>
    tkVariant:
      Value := GetVariantProp(FOwner, PropInfo);
  else
    // Остальные типы не поддерживаются
    Result := DISP_E_MEMBERNOTFOUND;
  end;
end;
</pre>

<p>Установка свойств</p>
<p>Для установки свойств классов VCL служит метод SetVCLProperty. В нем осуществляется обратная трансляция типов данных OLE в типы данных Object Pascal.</p>
<pre>
function TVCLProxy.SetVCLProperty(PropInfo: PPropInfo;
  Argument: TVariantArg): HResult;
var
  I, J, K, CommaPos: Integer;
  GoodToken: Boolean;
  S, S1: String;
  DT: TDateTime;
  ST: TSystemTime;
  IP: IQueryPersistent;
  Data, TypeData: PTypeData;
  TypeInfo: PTypeInfo;
begin
  Result := S_OK;
  case PropInfo^.PropType^.Kind of
</pre>
<p>Главным отличием этого метода от SetVCLProperty является необходимость проверки типа данных передаваемого параметра</p>
<pre>
    tkChar, tkString, tkLString, tkWChar, tkWString:
      begin
        // Проверяем тип параметра
        ValidType(Argument, VT_BSTR, TRUE);
        // И устанавливаем свойство
        SetStrProp(FOwner, PropInfo, Argument.bstrVal);
      end;
</pre>
<p>Для целочисленных свойств добавим еще один сервис &#8211; если свойство имеет тип TCursor или TColor &#8211; обеспечим трансляцию символьной строки с соответствующим названием константы в целочисленный идентификатор.</p>
<pre>
    tkInteger:  
      begin
        // Проверяем тип свойства на TCursor, TColor
        // если он совпадает и передано символьное значение
        // пытаемся получить его идентификатор
        if (CompareText(PropInfo^.PropType^.Name, 'TCURSOR') = 0) and
           (Argument.vt = VT_BSTR) then begin
          if not IdentToCursor(Argument.bstrVal, I) then begin
            Result := DISP_E_BADVARTYPE;
            Exit;
          end;
        end else
        if (CompareText(PropInfo^.PropType^.Name, 'TCOLOR') = 0) and
          (Argument.vt = VT_BSTR) then begin
          if not IdentToColor(Argument.bstrVal, I) then begin
            Result := DISP_E_BADVARTYPE;
            Exit;
          end;
        end else
          // Просто цифра
          I := IntValue(Argument);
        // Устанавливаем свойство
        SetOrdProp(FOwner, PropInfo, I);
      end;
</pre>

<p>Для перечислимых типов, за исключением Boolean значение передается в виде символьной строки, Boolean, как и раньше обрабатываем отдельно</p>
<pre>
    tkEnumeration:
      begin
        // Проверяем на тип Boolean - для него в VBScript есть
        // отдельный тип данных
        if CompareText(PropInfo^.PropType^.Name, 'BOOLEAN') = 0 then
        begin
          // Проверяем тип данных аргумента
          ValidType(Argument, VT_BOOL, TRUE);
          // Это свойство Boolean - получаем значение и значение
          SetOrdProp(FOwner, PropInfo, Integer(Argument.vBool));
        end else begin
          // Перечислимый тип передается в виде символьной строки
          // Проверяем тип данных аргумента
          ValidType(Argument, VT_BSTR, TRUE);
          // Получаем значение
          S := Trim(Argument.bstrVal);
          // Переводим в Integer
          I := GetEnumValue(PropInfo^.PropType^, S);
          // Если успешно - устанавливаем свойство
          if I &gt;= 0 then
            SetOrdProp(FOwner, PropInfo, I)
          else
            raise EInvalidParamType.Create('');
        end;
      end;
</pre>
<p>При установке объектного свойства необходимо получить ссылку на класс Delphi, представителем которого является переданный интерфейс IDispatch. Для этого служит ранее определенный нами интерфейс IQueryPersistent. Запросив его у объекта-представителя, мы можем получить ссылку на объект VCL и корректно установить свойство.</p>
<pre>
    tkClass:
      begin
        // Проверяем тип данных - должен быть интерфейс IDispatch
        ValidType(Argument, VT_DISPATCH, TRUE);
        if Assigned(Argument.dispVal) then begin
          // Передано непустое значение
          // Получаем интерфейс IQueryPersistent
          IP := IDispatch(Argument.dispVal) as IQueryPersistent;
          // Получаем ссылку на класс, представителем которого
          // является интерфейс
          I := Integer(IP.GetPersistent);
        end else
          // Иначе - очищаем свойство
          I := 0;
        // Устанавливаем значение
        SetOrdProp(FOwner, PropInfo, I);
      end;
</pre>

<p>Для чисел с плавающей точкой основной проблемой является отработка свойства типа TDateTime. Дополнительно обеспечим возможность установить это свойство в виде символьной строки. При установке свойства типа TDateTime необходимо обеспечить трансляцию его из формата TOleDate в TDateTime</p>
<pre>
   tkFloat:
      begin
        if (PropInfo^.PropType^ = System.TypeInfo(TDateTime)) or
           (PropInfo^.PropType^ = System.TypeInfo(TDate)) then
        begin
          // Проверяем тип данных аргумента
          if Argument.vt = VT_BSTR then begin
            DT := StrToDate(Argument.bstrVal);
          end else begin
            ValidType(Argument, VT_DATE, TRUE);
            if VariantTimeToSystemTime(Argument.date, ST) &lt;&gt; 0 then
              DT := SystemTimeToDateTime(ST)
            else begin
              Result := DISP_E_BADVARTYPE;
              Exit;
            end;
          end;
          SetFloatProp(FOwner, PropInfo, DT);
        end else begin
          // Проверяем тип данных аргумента
          ValidType(Argument, VT_R8, TRUE);
          // Устанавливаем значение
          SetFloatProp(FOwner, PropInfo, Argument.dblVal);
        end;
      end;
</pre>
<p>Наиболее сложным случаем является установка данных типа «набор» (Set). Необходимо выделить из переданной символьной строки разделенные запятыми элементы, для каждого из них &#8211; проверить, является ли он допустимым для устанавливаемого свойства, и установить соответствующий бит в числе, которое будет установлено в качестве свойства.</p>
<pre>
   tkSet:
      begin
        // Проверяем тип данных, должна быть символьная строка
        ValidType(Argument, VT_BSTR, TRUE);
        // Получаем данные
        S := Trim(Argument.bstrVal);
        // Получаем информацию RTTI
        Data := GetTypeData(PropInfo^.PropType^);
        TypeInfo := Data^.CompType^;
        TypeData := GetTypeData(TypeInfo);
        I := 0;
        while Length(S) &gt; 0 do begin
          // Проходим по строке, выбирая разделенные запятыми
          // значения идентификаторов
          CommaPos := Pos(',', S);
          if CommaPos = 0 then
            CommaPos := Length(S) + 1;
          S1 := Trim(System.Copy(S, 1, CommaPos - 1));
          System.Delete(S, 1, CommaPos);
          if Length(S1) &gt; 0 then begin
            // Поверяем, какому из допустимых значений соответствует
            // полученный идентификатор
            K := 1;
            GoodToken := FALSE;
            for J := TypeData^.MinValue to TypeData^.MaxValue do
            begin
              if CompareText(S1, GetEnumName(TypeInfo , J)) = 0 then
              begin
                // Идентификатор найден, добавляем его в маску
                I := I or K;
                GoodToken := TRUE;
              end;
              K := K shl 1;
            end;
            if not GoodToken then begin
              // Идентификатор не найдет
              Result := DISP_E_BADVARTYPE;
              Exit;
            end;
          end;
        end;
        // Устанавливаем значение свойства
        SetOrdProp(FOwner, PropInfo, I);
      end;
</pre>
<p>Свойство типа Variant устанавливается несложно:</p>
<pre>
    tkVariant:
      begin
        // Проверяем тип данных аргумента
        ValidType(Argument, VT_VARIANT, TRUE);
        // Устанавливаем значение
        SetVariantProp(FOwner, PropInfo, Argument.pvarVal^);
      end;
   else
     // Остальные типы данных OLE не поддерживаются
     Result := DISP_E_MEMBERNOTFOUND;
  end;
end;
</pre>

<p>Таким образом, мы реализовали полную функциональность по трансляции вызовов OLE в обращения к свойствам VCL. Наш компонент может динамически создавать другие компоненты на форме, обращаться к их свойствам и даже обрабатывать возникающие в них события.</p>
Оператор For Each</p>
<p>Удобным средством, предоставляемым VBScript, является оператор For Each, организующий цикл по всем элементам заданной коллекции. Добавим поддержку этого оператора в наш компонент.</p>
Интерфейс IEnumVariant</p>
<p>Реализация For Each предусматривает следующее:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Исполняющее ядро ScriptControl вызывает метод Invoke объекта, по элементам которого должен производиться цикл с DispID = DISPID_NEWENUM (-4).</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Объект должен вернуть интерфейс IEnumVariant</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>Далее ядро использует методы IEnumVariant для получения элементов коллекции.</td></tr></table></div><p>Интерфейс IEnumVariant определен как:</p>
<pre>
type
  IEnumVariant = interface(IUnknown)
    ['{00020404-0000-0000-C000-000000000046}']
    function Next(celt: LongWord; var rgvar: OleVariant;
      pceltFetched: PLongWord): HResult; stdcall;
    function Skip(celt: LongWord): HResult; stdcall;
    function Reset: HResult; stdcall;
    function Clone(out Enum: IEnumVariant): HResult; stdcall;
  end;
</pre>

<p>В модуле ActiveX.pas в оригинальной поставке Delphi5 ошибочно определен метод Next</p>
<pre>
  function Next(celt: LongWord; var rgvar: OleVariant;
     out pceltFetched: LongWord): HResult; stdcall;
</pre>
<p>поэтому для корректной реализации интерфейс должен быть переопределен.</p>
Класс TVCLEnumerator</p>
<p>Создадим класс, инкапсулирующий функциональность IEnumVariant</p>
<pre>
type
  TVCLEnumerator = class(TInterfacedObject, IEnumVariant)
  private
    FEnumPosition: Integer;
    FOwner: TPersistent;
    FScriptControl: TVCLScriptControl;
    { IEnumVariant }
    function Next(celt: LongWord; var rgvar: OleVariant;
      pceltFetched: PLongWord): HResult; stdcall;
    function Skip(celt: LongWord): HResult; stdcall;
    function Reset: HResult; stdcall;
    function Clone(out Enum: IEnumVariant): HResult; stdcall;
  public
    constructor Create(AOwner: TPersistent; 
      AScriptControl: TVCLScriptControl);
  end;
</pre>
<p>Конструктор устанавливает свойства FOwner и FScriptControl</p>
<pre>
constructor TVCLEnumerator.Create(AOwner: TPersistent;
  AScriptControl: TVCLScriptControl);
begin
  inherited Create;
  FOwner := AOwner;
  FScriptControl := AScriptControl;
  FEnumPosition := 0;
end;
Метод Reset подготавливает реализацию интерфейса к началу перебора
function TVCLEnumerator.Reset: HResult;
begin
  FEnumPosition := 0;
  Result := S_OK;
end;
</pre>

<p>Главная функциональность сосредоточена в методе Next, который получает следующие переменные:</p>
<p>celt &#8211; количество запрашиваемых элементов</p>
<p>rgvar &#8211; адрес первого элемента массива переменных типа OleVariant</p>
<p>pceltFetched &#8211; адрес переменной, в которую должно быть записано количество реально переданных элементов. Этот адрес может быть равен NIL, в этом случае ничего записывать не надо.</p>
<p>Метод должен заполнить запрошенное количество элементов rgvar и вернуть S_OK, если это удалось и S_FALSE, если элементов не хватило.</p>
<pre>
type
  TVariantList = array [0..0] of OleVariant;
 
function TVCLEnumerator.Next(celt: LongWord; var rgvar: OleVariant;
  pceltFetched: PLongWord): HResult;
var
  I: Cardinal;
begin
  Result := S_OK;
  I := 0;
Для объекта TWinControl возвращаем интерфейсы IDispatch для компонентов из свойства Controls
  if FOwner is TWinControl then begin
    with TWinControl(FOwner) do begin
      while (FEnumPosition &lt; ControlCount) and (I &lt; celt) do begin
        TVariantList(rgvar)[I] :=
          FScriptControl.GetProxy(Controls[FEnumPosition]);
        Inc(I);
        Inc(FEnumPosition);
      end;
    end;
  end
</pre>
<p>Для TCollection организуется перебор элементов коллекции</p>
<pre>
  else
  if FOwner is TCollection then begin
    with TCollection(FOwner) do begin
      while (FEnumPosition &lt; Count) and (I &lt; celt) do begin
        TVariantList(rgvar)[I] :=
          FScriptControl.GetProxy(Items[FEnumPosition]);
        Inc(I);
        Inc(FEnumPosition);
      end;
    end;
  end
</pre>

<p>Для TStrings перебираются строки и возвращаются их значения.</p>
<pre>
  else
  if FOwner is TStrings then begin
    with TStrings(FOwner) do begin
      while (FEnumPosition &lt; Count) and (I &lt; celt) do begin
        TVariantList(rgvar)[I] := TStrings(FOwner)[FEnumPosition];
        Inc(I);
        Inc(FEnumPosition);
      end;
    end;
  end else
    Result := S_FALSE;
  if I &lt;&gt; celt then
    Result := S_FALSE;
  if Assigned(pceltFetched) then
    pceltFetched^ := I;
end;
</pre>
<p>Метод Skip пропускает запрошенное количество элементов и возвращает S_OK, если еще остались элементы для перебора</p>
<pre>
function TVCLEnumerator.Skip(celt: LongWord): HResult;
var
  Total: Integer;
begin
  Result := S_FALSE;
  if FOwner is TWinControl then
    Total := TWinControl(FOwner).ControlCount
  else
  if FOwner is TCollection then
    Total := TCollection(FOwner).Count
  else
  if FOwner is TStrings then
    Total := TStrings(FOwner).Count
  else
    Exit;
  if FEnumPosition + celt &lt;= Total then begin
    Result := S_OK;
    Inc(FEnumPosition, celt)
  end;
end;
</pre>
<p>Метод Clone клонирует объект, возвращая интерфейс его копии</p>
<pre>
function TVCLEnumerator.Clone(out Enum: IEnumVariant): HResult;
var
  NewEnum: TVCLEnumerator;
begin
  NewEnum := TVCLEnumerator.Create(FOwner, FScriptControl);
  NewEnum.FEnumPosition := FEnumPosition;
  Enum := NewEnum as IEnumVariant;
  Result := S_OK;
end;
</pre>
<p>Для того чтобы класс TVCLProxy мог вернуть интерфейс IEnumVariant надо дополнить метод Invoke следующим кодом:</p>
<pre>
  case DispId of
   DISPID_NEWENUM: begin
        // У объекта запрашивают интерфейс IEnumVariant для ForEach
        // создаем класс, реализующий этот интерфейс
        OleVariant(VarResult^) := TVCLEnumerator.Create(FOwner, 
          FScriptControl) as IEnumVariant;
      end;
</pre>
&nbsp;</p>
Компонент TVCLScriptControl</p>
<p>Текст этого компонента приведен на CD-ROM. Он является наследником TScriptControl и реализует функциональность по работе с TVCLProxy.</p>
Заключение</p>
<p>Microsoft ScriptControl &#8211; качественное решение для задач, требующих включения в программу интерпретирующего ядра. Интегрировав его с VCL, мы получаем мощный и гибкий инструмент, позволяющий наращивать возможности в любом направлении. Информация из этой главы вполне достаточна, чтобы на основе приведенного на диске компонента TVCLScriptControl, создать решение, удовлетворяющее любой конкретной задаче.</p>

<div class="author">Автор: Тенцер А. Л., tolik@katren.nsk.ru, ICQ UIN 15925834</div>
<p></p>
