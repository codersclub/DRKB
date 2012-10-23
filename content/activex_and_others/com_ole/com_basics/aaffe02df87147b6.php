<h1>IClassFactory</h1>
<div class="date">01.01.2007</div>


<p>Итак, IClassFactory предназначен для того, чтобы создавать экземпляры соответствующего класса. То есть строчкой:</p>
<pre>
  CoGetClassObject(Calc_CLSID, dwClsContext, nil, IClassFactory,p); //Calc_CLSID - GUID нашего калькулятора
</pre>

<p>мы должны получить интерфейс, с помощью которого мы сможем создавать сколь угодно много наших калькуляторов (конкретнее: экземпляров нашего класса MyCalc). Для этого вызывается метод этого интерфейса CreateInstance. Параметры у него до боли знакомые - они точно такие же как три последних параметра у СoCreateInstance или CoGetClassObject. CLSID уже не нужен, так как данный интерфейс принадлежит классу, который создает только объекты определенного класса - того CLSID которого мы указали в СoCreateInstance, который потом передался в CoGetClassObject и который наконец попал в DllGetClassObject.</p>
<p>  Видете, тут довольно забавно получается - мы просим создать объект и выдать для этого объекта интерфейс IClassFactory, с помощью которого мы будем создавать эти же объекты. В принципе, мы совершаем лишнее действие, если собираемся создать только один объект, однако если мы хотим создать множество объектов, то такой путь более эффективен, чем многократный вызов CoCreateInstance или CoGetClassObject, поэтому он и был утвержден.</p>
<p> Чисто теоретически, мы можем сделать так (для нашего калькулятора):</p>
<pre>
var
  p:IClassFactory;
  Calc:ICalc;
begin 
 //создаем объект (MyCalc) и получаем для него интерфейс IClassFactory
 CoGetClassObject(StringTOGUID('{2563AE40-AC27-11D6-A5C2-444553540000}'),nil,CLSCTX_INPROC_SERVER,IClassFactory,p); 
 //получаем интерфейс ICalc
 p.QueryInterface(ICalcGUID,Calc);
end; 
</pre>
<p> Ибо IClassFactory, как и любой интерфейс, является потомком IUnknown, и поддерживает метод QueryInterface (как AddRef и Release, который Delphi вызывает автоматически). Единственная загвоздка состоит в том, что несмотря на то, что этот&nbsp; интерфейс вроде должен пренадежать только что созданному объекту MyCalc, во многих реализациях он ему не пренадлежит. Ну у нас то, конечно, пока еще вообще никакой реализации нет, но если бы это делал кто-то другой, то возможно он бы реализовал DllGetClassObject так:</p>
<pre>
function DllGetClassObject(const CLSID, IID: TGUID; var Obj): HResult; stdcall;
var
 Calc:TObject;
begin
 if GUIDToString(CLSID)&lt;&gt;'{2563AE40-AC27-11D6-A5C2-444553540000}' {GUID нашего класса}  then
 begin
   Result:=CLASS_E_CLASSNOTAVAILABLE;
   exit;
 end;
 // если cпрашивается IClassFactory, то создаем класс-фабрику. 
 if IID=IClassFactory then
   Calc:=CalcFactory.Create
 else
   Calc:=MyCalc.Create;
 if not Calc.GetInterface(IID,Obj) then
 begin
   Result:=E_NOINTERFACE;
   Calc.Free;
   exit;
 end;
 Result:=S_OK;
end;
</pre>

<p> То есть создается один экземпляр маленького класса CalcFactory, который ничего больше не умеет, кроме как создавать калькуляторы (экземпляры класса MyCalc). Естесственно, он поддерживает интерфейс IClassFactory. Такая реализация не редка и попытка получить у такого класса-фабрики интерфейс настоящего класса может закончится ошибкой.</p>
<p> Мы же давайте пойдем другим путем, и просто дополним наш класс интерфейсом IClassFactory. Для этого мы можем сами создать интерфейс IClassFactory, как мы раньше создавали ICalc и ICalc2, а можем воспользоваться готовым описанием, включив в uses библиотеку ActiveX. Так оно выглядит там:</p>
<pre>
  IClassFactory = interface(IUnknown)
    ['{00000001-0000-0000-C000-000000000046}']
    function CreateInstance(const unkOuter: IUnknown; const iid: TIID;
      out obj): HResult; stdcall;
    function LockServer(fLock: BOOL): HResult; stdcall;
  end;
</pre>

<p> Как видите, помимо CreateInstance здесь так же есть метод LockServer. Этот метод предназначен для того, чтобы гарантировать не уничтожение объекта. То есть поставили замок, и пока его не сняли, обект должен жить. Добавим и этот метод а наш класс.</p>
<pre>
 MyCalc=class(TObject,ICalc,ICalc2, IClassFactory)
   fx,fy:integer;
   FRefCount:integer;
 public
   constructor Create;
   procedure SetOperands(x,y:integer);
   function Sum:integer;
   function Diff:integer;
   function Divide:integer;
   function Mult:integer;
   procedure Release;
   function QueryInterface(const IID: TGUID; out Obj): HResult; stdcall;
   function _AddRef:Longint; stdcall;
   function _Release:Longint; stdcall;
 
   //IClassFactory
   function CreateInstance(const unkOuter: IUnknown; const iid: TIID;out obj): HResult; stdcall;
   function LockServer(fLock: BOOL): HResult; stdcall;
 end;
</pre>
<p>Реализация:</p>
<pre>
 function MyCalc.CreateInstance(const unkOuter: IUnknown; const iid: TIID;out obj): HResult; stdcall;
 var
   Calc:MyCalc;
 begin
   Calc:=MyCalc.Create;
   if not Calc.GetInterface(IID,Obj) then
   begin
    Result:=E_NOINTERFACE;
    Calc.Free;
    exit;
   end;
   Result:=S_OK;
 end;
 
 function MyCalc.LockServer(fLock: BOOL): HResult; stdcall;
 begin
   if fLock then
     _AddRef
   else
     Release;
 end;
</pre>

<p>Реализация CreateInstance полностью идентична последним восми строчкам функции DllGetClassObject - просто создаем объект и возвращаем интерфейс, если мы его поддерживаем. С LockServer тоже все просто: если fLock=true тогда увеличиваем счетчик вызовом _AddRef, иначе уменьшаем его вызывая Release.</p>
<p> Ну теперь еще раз. Компилируем dll, тестер менять не надо, и запускаем... Свершилось! Наш калькулятор был создан системной функцией CoCreateInstance!</p>
