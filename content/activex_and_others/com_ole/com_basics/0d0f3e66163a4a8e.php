<h1>Как система создает объект СОМ</h1>
<div class="date">01.01.2007</div>

<p>Итак, давайте посмотрим как система создает СОМ объект. (Все, что написанно далее про создание СОМ объекта, не является стандартом СOM, а является поддержкой работы COM системой. То есть так поддержка реализованна в Windows. В других системах поддержка COM (если вы ее там найдете) может быть реализована по другому.)  Наиболее часто используемая API функция в Windows для  создания СОМ объекта это CoCreateInstance (все названия функций Win API для работы с СОМ имеют префикс Со). Выглядит она так:</p>

<pre class="delphi">
STDAPI CoCreateInstance(
    REFCLSID rclsid,  
    LPUNKNOWN pUnkOuter,  
    DWORD dwClsContext,          
    REFIID riid,          
    LPVOID * ppv          
   );        
</pre>
<p>Давайте запишим ее в паскалевском виде, и прокомментируем:</p>
<pre class="delphi">
function CoCreateInstance(
   const clsid: TCLSID;   //Индификатор класса объект которого мы хотим создать (это, как всегда, GUID)
   unkOuter: IUnknown;    //указатель на интерфейс агрегирующего объекта (агрегирование мы рассматривать пока не будем поэтому он у нас будет nil) 
   dwClsContext: Longint; //контекст в котором объект должен быть создан объект
   const iid: TIID;       //индификатор интерфейса который мы хотим получить (это тоже GUID)
   out pv                 //переменная в которую будет записан полученный интерфейс
   ): HResult; stdcall;
</pre>

<p>  Параметр dwClsContext указывает как должен быть создан объект. Если мы хотим создавать наш калькулятор c помощью CoCreateInstance этот параметр будет равен CLSCTX_INPROC_SERVER, то есть внутрипроцессорный сервер, так как наш объект находиться внутри dll и не может работать как отдельный процесс. Значит создание нашего объекта будет выглядеть примерно так:</p>
<pre class="delphi">
var
  Calc:ICalc;
begin
  CoCreateInstance({GUID нашего класса которого у наc пока нет},nil,CLSCTX_INPROC_SERVER,ICalc,Calc);
...
end; 
</pre>

<p> Итак у нас нет GUID нашего класса. Ну, его придумать не проблема, нажал в Delphi Ctrl+Shift+G и GUID готов (особо крутые программисты могут написать свою программку генерации GUID, которая будет сосотоять из одного вызова API функции СoCreateGUID или UuidCreate). А как система узнает о том, что этот GUID пренадлижит нашему классу? Правильно, пора заглянуть в реестр.Открываем ключ HKEY_CLASSES_ROOT\CLSID и видим длинный список GUID'ов. Именно в этом списке находятся все GUID зарегистрированных COM классов (GUID классов чаще называют CLSID - Class ID).При вызове CoCreateInstance в этом списке ищется тот GUID который равен параметру CLSID и если он находиться, то рассматривается параметр dwClsContext, и в соответсвии с ним ищется следующий подключ:</p>
<p> если dwClsContext=CLSCTX_INPROC_SERVER ищется подключ InprocServer32</p>
<p> если dwClsContext=CLSCTX_INPROC_HANDLER ищется подключ InprocHandler32</p>
<p> если dwClsContext=CLSCTX_LOCAL_SERVER ищется подключ LocalServer32</p>
<p>и если он существует, то значение этого ключа будет указывать путь к модулю в котором находиться исполняемый код класса.</p>
<p> Итак, чтобы зарегестрировать наш класс, нужно создать новый GUID (пусть это будет {2563AE40-AC27-11D6-A5C2-444553540000} ) и создать в реестре  новый раздел HKEY_CLASSES_ROOT\CLSID\{2563AE40-AC27-11D6-A5C2-444553540000}, а в нем создать еще один подраздел InprocServer32 и в значение по умолчанию записать путь к нашей dll, у меня это C:\Kir\COM\SymplDll\CalcDll.dll. Отлично, теперь система знает где искать наш класс. Теперь давайте посмотрим как она этот класс создает.</p>
<p>  А создает она его так (сейчас мы говорим только о in-proc сервере).Найденная библиотека(dll) с классом загружается в память и в ней вызывается функция DllGetClassObject! Вот основная функция которую наша библиотека должна содержать, и через которую система и создает COM объект. Как она выглядит и что она должна делать? Выглядит она вот так:</p>
<p>function DllGetClassObject(const CLSID, IID: TGUID; var Obj): HResult; stdcall;</p>
<p>а делать она должна то, что делает сейчас наша функция CreateObject - создавать класс.</p>
<p>По сравнению с CreateObject добавляется еще один параметр CLSID, так как библиотека может содержать больше чем один класс, то этот параметр указывает объект какого класса нужно создать. Если параметр CLSID содержит неизвестный нашей библиотеке GUID то функция должна вернуть CLASS_E_CLASSNOTAVAILABLE.</p>
<p>Давайте перепишим наш CreateObject на DllGetClassObject:</p>

<pre class="delphi">
function DllGetClassObject(const CLSID, IID: TGUID; var Obj): HResult; stdcall;
var
 Calc:MyCalc;
begin
 if GUIDToString(CLSID)&lt;&gt;'{2563AE40-AC27-11D6-A5C2-444553540000}' {GUID нашего класса}  then
 begin
   Result:=CLASS_E_CLASSNOTAVAILABLE;
   exit;
 end;
 Calc:=MyCalc.Create;
 if not Calc.GetInterface(IID,Obj) then
 begin
   Result:=E_NOINTERFACE;
   Calc.Free;
   exit;
 end;
 Result:=S_OK;
end;
 
exports
// Не забыть добавить в список экспорта!
  DllGetClassObject;
</pre>
<p>  Итак, первой строчкой проверяем, является ли спрашевыемый индификатор класса(CLSID) индификатором нашего класса, который мы недавно придумали, с помощю Delphi, а далее как было раньше, пытаемся записать в переменную Obj указатель на интерфейс того интерфейса, GUID которого был нам передан в качестве параметра IID. Если такой интерфейс нашим классом не поддерживается, освобождаем объект и возвращаем ошибку. Если же все нормально, возвращаем S_OK, а в выходном параметре Obj будет находиться указатель на спрашиваемый интерфейс.</p>
<p>Так же перепишим в тестере процедуру, где мы создаем наш COM калькулятор - это TForm1.FormCreate:</p>
<pre class="delphi">
procedure TForm1.FormCreate(Sender: TObject);
begin
 ICalcGUID:=StringToGUID('{149D0FC0-43FE-11D6-A1F0-444553540000}');
 ICalc2GUID:=StringToGUID('{D79C6DC0-44B9-11D6-A1F0-444553540000}');
 flag:=true;
 
 if СoCreateInstance(StringTOGUID('{2563AE40-AC27-11D6-A5C2-444553540000}'),nil,CLSCTX_INPROC_SERVER,ICalcGUID,Calc)=S_OK then
   Calc.SetOperands(10,5)
 else
 begin
   ShowMessage('Failed to create Calc');
   Close;
 end;
end;
</pre>

<p>  Как вы видите, мы не загружаем здесь библиотеку в память, чтобы потом вызвать из нее соответсвующую функцию для создания объекта, а перепоручаем всю эту работу CoCreateInstance.</p>
<p>В качестве индификатора класса мы передаем GUID нашего класса, а в касечтве индификатора интерфейса передаем GUID интерфейса ICalc. Ну а сам указатель на интерфейс должен записаться в переменную Calc.</p>
<p> Ну все. Все готово, теперь все компилируем и запускаем... Объект не создается! CoCreateInstance возвращает REGDB_E_CLASSNOTREG - класс не зарегестрирован. Но на самом деле ошибка не в том, что класс не зарегестрирован. А в чем? Давайте пройдемся пошагово по нашей dll. Поставим брекпойнт на первую линию функции DllGetClassObject. Мы видим, что эта функция вызывается, что CLSID соответсвует GUID нашего класса, что сам объект создается, но что дальше? Метод GetInterface не находит спрашеваемого интерфейса! Посмотрите чему равен параметр IID и вы увидите, что он не равен GUID интерфейса ICalc, который мы передавали CoCreateInstance, а равен он вот такому значению: {00000001-0000-0000-C000-000000000046}. Можно заглянуть в реестр Windows, чтобы узнать, что интерфейс с таким GUID носит название IClassFactory. Что ж, выходит CoCreateInstance просит не тот интерфейс, который мы предаем ей как параметр. Microsoft не скрывает реализацию CoCreateInstance - это, на самом деле, всего лишь вспомогательная функция и делает она следующее (вольный перевод на Delphi):</p>

<pre class="delphi">
function CoCreateInstance(const clsid: TCLSID;unkOuter: IUnknown;dwClsContext: Longint; const IID: TIID; out pv): HResult; stdcall;
var
  p:IClassFactory;
begin
  CoGetClassObject(CLSID, dwClsContext, nil, IClassFactory,p); 
  Result = p.CreateInstance(unkOuter, IID, pv);
end;
</pre>

<p>Первой строчкой вызывается API функция CoGetClassObject, параметры у нее точно такие же как у CoCreateInstance, и как раз она является основной функцией - она находит библиотеку с классом и вызывает DllGetClassObject (опять же, это все для in-proc серверов). И как видите, она действительно просит интерфейс IClassFactory. Что бы понять, что делает следующая строчка, нужно рассмотреть еще один офицальный и широко известный интерфейс IClassFactory.</p>
