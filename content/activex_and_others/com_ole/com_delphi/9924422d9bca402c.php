<h1>Реализация интерфейсов</h1>
<div class="date">01.01.2007</div>


<p>Реализацией интерфейса в Delphi всегда выступает класс. Для этого в объявлении класса необходимо указать, какие интерфейсы он реализует.</p>
<pre class="delphi">
type
  TMyClass = class(TComponent, IMyInterface, IDropTarget)
    // Реализация методов
  end;
</pre>


<p>Класс TMyClass реализует интерфейсы IMyInterface и IDropTarget. Необходимо понимать, что реализация классом нескольких интерфейсов не означает множественного наследования и вообще наследования класса от интерфейса. Указание интерфейсов в описании класса означает лишь то, что в данном классе реализованы все эти интерфейсы.</p>
<p>Класс должен иметь методы, точно соответствующие по именам и спискам параметров всем методам всех объявленных в его заголовке интерфейсов.</p>
<p>Рассмотрим более подробный пример.</p>
<pre class="delphi">
type
  ITest = interface
  ['{61F26D40-5CE9-11D4-84DD-F1B8E3A70313}']
    procedure Beep;
  end;
 
  TTest = class(TInterfacedObject, ITest)
    procedure Beep;
    destructor Destroy; override;
  end;
…
procedure TTest.Beep;
begin
  Windows.Beep(0,0);
end;
 
destructor TTest.Destroy;
begin
  inherited;
  MessageBox(0, 'TTest.Destroy', NIL, 0);
end;
 
Здесь класс TTest реализует интерфейс ITest. Рассмотрим использование интерфейса из программы.
 
procedure TForm1.Button1Click(Sender: TObject);
var
  Test: ITest;
begin
  Test := TTest.Create;
  Test.Beep;
end;
</pre>


<p>Данный код выглядит довольно странно, поэтому остановимся на нем подробнее.</p>
<p>Во-первых - оператор присваивания при приведении типа данных к интерфейсу неявно вызывает метод _AddRef. При этом количество ссылок на интерфейс увеличивается на 1.</p>
<p>Во-вторых - код не содержит никаких попыток освободить память, выделенную под объект TTest. Тем не менее, если выполнить эту программу, то на экран будет выведено сообщение о том, что деструктор был вызван. Это происходит потому, что при выходе переменной, ссылающейся на интерфейс за область видимости (либо, при присвоении ей другого значения) компилятор Delphi генерирует код для вызова метода _Release, информируя реализацию о том, что ссылка на неё больше не нужна.</p>
<p>!         Если у класса запрошен хотя бы один интерфейс - не вызывайте его метод Free (или Destroy). Класс будет освобожден тогда, когда отпадет необходимость в последней ссылке на его интерфейсы. Если Вы к этому моменту уничтожили экземпляр класса вручную - произойдет ошибка доступа к памяти</p>
<p>Так, следующий код приведет к ошибке в момент выхода из функции:</p>
<pre class="delphi">
var
  Test: ITest;
  T: TTest;
begin
  T := TTest.Create;
  Test := T;
  Test.Beep;
  T.Free;
end;   // в этот момент произойдет ошибка
</pre>


<p>Если вы хотите уничтожить реализацию интерфейса немедленно, не дожидаясь выхода переменной за область видимости - просто присвойте ей значение NIL</p>
<pre class="delphi">
var
  Test: ITest;
  T: TTest;
begin
  T := TTest.Create;
  Test := T;
  Test.Beep;
  Test := NIL;  // Неявно вызывается IUnknown._Release;
end;
</pre>


<p>Обратите особое внимание, что вызовы методов IUnknown осуществляются Delphi неявно и автоматически. Поэтому - не вызывайте методов IUnknown самостоятельно. Это может нарушить нормальную работу автоматического подсчета ссылок и привести к не освобождению памяти, либо нарушениям защиты памяти при работе с интерфейсами. Во избежание этого - необходимо просто помнить, что:</p>
- При приведении типа объекта к интерфейсу, вызывается метод _AddRef.<br>
- При выходе переменной, ссылающейся на интерфейс за область видимости, либо при присвоении ей другого значения вызывается метод _Release<br>
- Единожды запросив у объекта интерфейс, Вы в дальнейшем не должны освобождать объект вручную. Лучше вообще, начиная с этого момента работать с объектом только через интерфейсные ссылки.
<p>В рассмотренных примерах код для получения интерфейса у класса генерировался (с проверкой типов) на этапе компиляции. Если класс не реализует требуемого интерфейса, то программа не откомпилируется. Однако, существует возможность запросить интерфейс и во время выполнения программы. Для этого служит оператор as, который вызывает QueryInterface и, в случае успеха, возвращает ссылку на полученный интерфейс. В противном случае генерируется исключение.</p>
<p>Например, следующий код будет успешно откомпилирован, но вызовет ошибку «Interface not supported» при выполнении:</p>
<pre class="delphi">
var
  Test: ITest;
begin
  Test := TInterfacedObject.Create as ITest;
  Test.Beep;
end;
В то же время код:
var
  Test: ITest;
begin
  Test := TTest.Create as ITest;
  Test.Beep;
end;
</pre>


<p>Будет успешно компилироваться и исполняться.</p>

<p>Реализация интерфейсов - расширенное рассмотрение</p>
<p>
<p>Рассмотрим вопросы реализации интерфейсов подробнее.</p>
<p>Объявим два интерфейса:</p>
<pre class="delphi">
type
  ITest = interface
  ['{61F26D40-5CE9-11D4-84DD-F1B8E3A70313}']
    procedure Beep;
  end;
 
  ITest2 = interface
  ['{61F26D42-5CE9-11D4-84DD-F1B8E3A70313}']
    procedure Beep;
  end;
</pre>


<p>Теперь создадим класс, который будет реализовывать оба этих интерфейса</p>
<pre class="delphi">
  TTest2 = class(TInterfacedObject, ITest, ITest2)
    procedure Beep1;
    procedure Beep2;
    procedure ITest.Beep = Beep1;
    procedure ITest2.Beep = Beep2;
  end;
</pre>


<p>Как видно, класс не может содержать сразу двух методов Beep. Поэтому, Delphi предоставляет способ для разрешения конфликтов имен, позволяя явно указать какой метод класса будет служить реализацией соответствующего метода интерфейса.</p>
<p>Если реализация методов TTest2.Beep1 и TTest2.Beep2 идентична, то можно не создавать двух разных методов, а объявить класс следующим образом:</p>
<pre class="delphi">
  TTest2 = class(TInterfacedObject, ITest, ITest2)
    procedure MyBeep;
    procedure ITest.Beep = MyBeep;
    procedure ITest2.Beep = MyBeep;
  end;
</pre>


<p>При реализации классов, поддерживающих множество интерфейсов и много методов может оказаться удобным делегировать реализацию некоторых их них дочерним классам. Рассмотрим пример класса, реализующего два интерфейса:</p>
<pre class="delphi">
type
  TBeeper = class
    procedure Beep;
  end;
 
  TMessager = class
    procedure ShowMessage(const S: String);
  end;
 
  TTest3 = class(TInterfacedObject, ITest, IAnotherTest)
  private
    FBeeper: TBeeper;
    FMessager: TMessager;
    property Beeper: TBeeper read FBeeper implements ITest;
    property Messager: TMessager read FMessager implements IAnotherTest;
  public
    constructor Create;
    destructor Destroy; override;
  end;
</pre>


<p>Для делегирования реализации интерфейса другому классу служит ключевое слово implements</p>

<pre class="delphi">
{ TBeeper }
procedure TBeeper.Beep;
begin
  Windows.Beep(0,0);
end;
 
{ TMessager }
procedure TMessager.ShowMessage(const S: String);
begin
  MessageBox(0, PChar(S), NIL, 0);
end;
 
{ TTest3 }
constructor TTest3.Create;
begin
  inherited;
  // Создаем экземпляры дочерних классов
  FBeeper := TBeeper.Create;
  FMessager := TMessager.Create;
end;
 
destructor TTest3.Destroy;
begin
  // Освобождаем экземпляры дочерних классов
  FBeeper.Free;
  FMessager.Free;
  inherited;
end;
</pre>

<p>Такой подход позволяет разбить реализацию сложного класса на несколько простых, что упрощает программирование и повышает модульность программы.</p>
<p>Обращаться к полученному классу можно точно так же, как и к любому классу, реализующему интерфейсы:</p>

<pre class="delphi">
var
  Test: ITest;
  Test2: IAnotherTest;
begin
  Test2 := TTest3.Create;
  Test2.ShowMessage('Hi');
  Test := Test2 as ITest;
  Test.Beep;
end;
</pre>


