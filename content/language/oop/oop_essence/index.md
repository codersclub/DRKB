---
Title: Сущность ООП
Date: 01.01.2007
---


Сущность ООП
============

::: {.date}
01.01.2007
:::

Одна из вещей, которую вы могли бы захотеть реализовать -
пользовательский интерфейс, предоставляющий доступ к файлу персональных
данных. ООП предоставляет вам безусловно лучшие механизмы для его
хранения, создания, и эксплуатации, делая эти вещи понятными и легкими
для понимания.

Вот как вы можете сделать это. Забудьте об диалоговом окне хотя бы на
минуту и сконцентрируйтесь на создании файла персональных данных.
Скажем, вы редактируете запись человека со следующими полями: First
Name, Last Name, Age и Active. Скажем, вам нужны следующие операции при
работе с записью: добавление, изменение, удаление и построение списка.

Вам необходимо создать невизуальный объект доступа к файлу,
инкапсулирующий вышеупомянутую функциональность. Это может выглядеть
приблизительно так:

    interface
     
    PPersonRecord = ^TPersonRecord;
    TPersonRecord = record
     
      FirstName: string;
      LastName: string;
      Age: Byte;
      Active: Boolean;
    end;
     
    TPersonFile = class(TObject)
    private
     
      FFileName: TFileName;
      FFile: file of TPersonRec;
    public
     
      constructor Create(AFileName: TFileName);
      destructor Destroy; override;
      procedure LoadRecord(Index: Integer);
      procedure SaveRecord(Index: Integer);
      procedure Add(NewPersonRecord: TPersonRecord);
      procedure Change(ChangedPersonRecord: TPersonRecord; Index: Integer);
      procedure Delete(Index: Integer);
      procedure List(AStringList: TStringList);
      property Person[Index: Integer]: TPersonRecord read LoadRecord write
        SaveRecord;
    end;
     
    implementation
     
    constructor TPersonFile.Create(AFileName: TFileName);
    begin
     
      inherited.Create;
      AssignFile(FFile, AFileName);
      Reset(FFile, SizeOf(TPersonRec));
      New(FPersonRecord);
    end;
     
    destructor TPersonFile.Destroy;
    begin
     
      CloseFile(FFile);
      Dispose(FPersonRecord);
      inherited Destroy;
    end;
     
    function TPersonFile.LoadRecord(Index: Integer): PPersonRec;
    begin
     
      { позиция файла в точке коррекции для чтения записи }
      { ... }
    end;
     
    procedure TPersonFile.SaveRecord(Index: Integer);
    begin
     
      { позиция файла в точке коррекции для записи записи }
      { ... }
    end;
     
    procedure TPersonFile.Add(NewPersonRecord: TPersonRecord);
    begin
     
      { файл позиционируется в конец для записи записи }
      { ... }
    end;
     
    procedure TPersonFile.Change(ChangedPersonRecord: TPersonRecord; Index:
      Integer);
    begin
     
      { именение TStatus ??? }
      { позиция файла в точке коррекции для записи записи }
      { ... }
    end;
     
    procedure TPersonFile.Delete(Index: Integer);
    begin
     
      { изменение TStatus ??? }
      { позиция файла в точке коррекции для записи записи }
      { ... }
    end;
     
    procedure TPersonFile.List(AStringList: TStringList);
    begin
     
      { в цикле обходим все записи, пополняя AStringList??? }
    end;

OK, я надеюсь вы поняли мою идею. Вышеприведенный код взят мною из
головы и, вероятно, несвободен от ошибок, поскольку я не до конца понял
как работает тип file (для доступа к бинарному файлу я использую
TFileStream), но идея следующая: инкапсуляция ваших функций работы с
файлом в невизуальный объект как показано выше.

Теперь вы можете начать думать о ваших диалогах. Вам необходимо создать
диалог, у которого в обработчике события OnCreate была бы примерно такая
строчка кода:

    MyPersonFile := TPersonFile.Create('c:\person.dat');

Естественно, вам необходим модуль, в котором вы объявляете TPersonFile в
секции используемых модулей, а в классе формы необходимо поле с именем
MyPersonFile. Вам также необходимо помнить об освобождении MyPersonFile
в методе формы onClose. Я думаю вы сообразите как разместить в вашей
программе необходимые элементы управления (менюшки, кнопки и прочие
причиндалы), хотя бы для того, чтобы с помощью них можно было бы открыть
файл.

Теперь вы должны разместить на форме компоненты типа Edit, CheckBox и
др., отображающие и позволяющие редактировать поля записи через свойство
Record. Убедитесь в том, что вы поддерживаете должный порядок, и
освобождаете объект (запись) после его создания и использования.
Конечно, эту работу красивой не назовешь, но от нее вас никто еще не
освобождал. Вот красота ООП:

\*После создания комбинации объект / форма диалога вся работа уже
сделана.\*

Вот другая хорошая вещь:

\*Если вы изменяете ваш пользовательский интерфейс (например, при отказе
от кучи диалогов или от использования Delphi (молчу-молчу)), ООП
предоставляет вам простой и легкий в использовании способ переноса
логики приложения, инкапсулированной в объекте TPersonFile.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

Сущность ООП
============
