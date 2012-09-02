<h1>Как передать при создании нити (TThread) ей некоторое значение?</h1>
<div class="date">01.01.2007</div>


<p>К примеру, функция "прослушивает" каталог на предмет файлов. Если находит, то создает нить, которая будет обрабатывать файл. Потомку надо передать имя файла, а вот как?</p>

<p>Странный вопрос. Я бы понял, если бы требовалось передавать данные во время работы нити. А так обычно поступают следующим образом.</p>
<p>В объект нити, происходящий от TThread дописывают поля. Как правило, в секцию PRIVATE. Затем переопределяют конструктор CREATE, который, принимая необходимые параметры заполняет соответствующие поля. А уже в методе EXECUTE легко можно пользоваться данными, переданными ей при его создании.</p>

<p>Например:</p>
<pre>
......
TYourThread = class(TTHread)
private
 FFileName: String;
protected
 procedure Execute; overrided;
public
 constructor Create(CreateSuspennded: Boolean;
 const AFileName: String);
end;
.....
constructor TYourThread.Create(CreateSuspennded: Boolean;
  const AFileName: String);
begin
 inherited Create(CreateSuspennded);
 FFIleName := AFileName;
end;
 
procedure TYourThread.Execute;
begin
 try
  ....
  if FFileName = ...
  ....
 except
  ....
 end;
end;
....
TYourForm = class(TForm)
....
private
 YourThread: TYourThread;
 procedure LaunchYourThread(const AFileName: String);
 procedure YourTreadTerminate(Sender: TObject);
....
end;
....
procedure TYourForm.LaunchYourThread(
  const AFileName: String);
begin
 YourThread := TYourThread.Create(True, AFileName);
 YourThread.Onterminate := YourTreadTerminate;
 YourThread.Resume
end;
....
procedure TYourForm.YourTreadTerminate(Sender: TObject);
begin
 ....
end;
....
end.
</pre>



<p>Источник: <a href="https://dmitry9.nm.ru/info/" target="_blank">https://dmitry9.nm.ru/info/</a></p>
