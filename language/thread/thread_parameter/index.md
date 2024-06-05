---
Title: Как передать при создании нити (TThread) ей некоторое значение?
Date: 01.01.2007
Source: <https://dmitry9.nm.ru/info/>
---


Как передать при создании нити (TThread) ей некоторое значение?
===============================================================

> Как передать при создании нити (TThread) ей некоторое значение?
> К примеру, функция "прослушивает" каталог на предмет файлов. Если
> находит файл, то создает нить, которая будет обрабатывать этот файл.
> Потомку надо передать имя файла, а вот как?

Странный вопрос. Я бы понял, если бы требовалось передавать данные во
время работы нити. А так обычно поступают следующим образом.

В объект нити, происходящий от TThread дописывают поля. Как правило, в
секцию PRIVATE. Затем переопределяют конструктор CREATE, который,
принимая необходимые параметры заполняет соответствующие поля. А уже в
методе EXECUTE легко можно пользоваться данными, переданными ей при его
создании.

Например:

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

