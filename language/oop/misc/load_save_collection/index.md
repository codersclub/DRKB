---
Title: Сохранение и загрузка данных в объекты на примере коллекций
Date: 01.01.2007
Source: [http://delphi.chertenok.ru](https://delphi.chertenok.ru)
---


Сохранение и загрузка данных в объекты на примере коллекций
===========================================================

Если в Вашей программе используются классы для описания объектов
некоторой предметной области, то данные, их инициализирующие, можно
хранить и в базе данных. Но можно выбрать гораздо более продуктивный
подход, который доступен в Delphi/C++ Builder. Среда разработки
Delphi/C++ Builder хранит ресурсы всех форм в двоичных или текстовых
файлах и эта возможность доступна и для разрабатываемых с ее помощью
программ. В данном случае, для оценки удобств такого подхода лучше всего
рассмотреть конкретный пример.

Необходимо реализовать хранение информации о некоей службе рассылки и ее
подписчиках. Будем хранить данные о почтовом сервере и список
подписчиков. Каждая запись о подписчике хранит его личные данные и
адрес, а также список тем(или каталогов), на которые он подписан. Как
большие поклонники Гради Буча (Grady Booch), а также будучи
заинтересованы в удобной организации кода, мы организуем информацию о
подписчиках в виде объектов. В Delphi для данной задачи идеально
подходит класс TCollection, реализующий всю необходимую функциональность
для работы со списками типизированных объектов. Для этого мы наследуемся
от TCollection, называя новый класс TMailList - список рассылки, а также
создаем наследника от TCollectionItem - TMailClient - адресат рассылки.
Последний будет содержать все необходимые данные о подписчике, а также
реализовывать необходимые функции для работы с ним.

Саму коллекцию с подписчиками нам нужно будет поместить в некий базовый
класс, который мы и будем сохранять и загружать. На роль такового
подходит класс TMailer - почтовый клиент.

Начнем с TMailClient.

    type 
      TMailClient = class(TCollectionItem) 
      private 
        FName: string; 
        FAddress: string; 
        FEnabled: boolean; 
        FFolders: TStringList; 
      public 
        Files: TStringList;  // список файлов к рассылке. заполняется в run-time. Сохранению не подлежит  
        constructor Create(Collection: TCollection); override; 
        destructor Destroy; override; 
        procedure PickFiles; 
      published 
        property Name: string read FName write FName;  // имя адресата 
        property Address: string read FAddress write FAddress; // почтовый адрес 
        property Enabled: boolean read FEnabled write FEnabled default true;
        property Folders: TStringList read FFolders write FFolders; // список папок (тем) подписки 
      end; 


Класс содержит сведения о имени клиента, его адресе, его
статусе(Enabled), а также список каталогов, на которые он подписан.
Процедура PickFiles составляет список файлов к отправке и сохраняет его
в свойстве Files

Класс TMailList, хранящий объекты класса TMailClient, приведен ниже.

      TMailList = class(TCollection) 
      public 
        function GetMailClient(Index: Integer): TMailClient; 
        procedure SetMailClient(Index: Integer; Value: TMailClient); 
      public 
        function  Add: TMailClient; 
        property Items[Index: Integer]: TMailClient read GetMailClient  write SetMailClient; default; 
      end;

Теперь поместим класс TMailList в класс TMailer. В него можно будет
потом включить данные о параметрах доступа к почтовому серверу для
отправки почты. Он мог бы и отправлять почту, но в данном примере это не
использовано, дабы не перегружать код.

То есть в нашем примере он выполняет только роль носителя данных о
подписчиках и их подписке. Класс TComponent, от которого он наследуется
можно сохранить в файл, в то время как TCollection самостоятельно не
сохранится. Только если она агрегирована в TComponent. Именно это у нас
и реализовано.


      TMailer = class(TComponent) 
      private 
        FMailList: TMailList; 
      public 
        constructor Create(AOwner: TComponent); override; 
        destructor Destroy; override; 
      published 
        property MailList: TMailList read FMailList write FMailList; // коллекция - список рассылки. 
        // здесь можно поместить, к примеру, данные о соединении с почтовым сервером  
      end; 


Повторюсь. В данном случае мы наследуемся от класса TComponent, для
того, чтобы была возможности записи данных объекта в файл. Свойство
MailList содержит уже объект класса TMailList.

Реализация всех приведенных классов приведена ниже.

    constructor TMailClient.Create(Collection: TCollection); 
    begin 
      inherited; 
      Folders := TStringList.Create; 
      Files := TStringList.Create; 
      FEnabled := true; 
    end; 
     
    destructor TMailClient.Destroy; 
    begin 
      Folders.Free; 
      Files.Free; 
      inherited; 
    end; 
     
    // здесь во всех каталогах Folders ищем файлы для рассылки и помещаем их в Files. 
    procedure TMailClient.PickFiles; 
    var i: integer;
    begin 
        for i:=0 to Folders.Count-1 do CreateFileList(Files, Folders[i]); 
    end; 
     
    // Стандартный код при наследовании от класса коллекции: переопределяем тип  
    function TMailList.GetMailClient(Index: Integer): TMailClient; 
    begin 
      Result := TMailClient(inherited Items[Index]); 
    end; 
     
    // Стандартный код при наследовании от класса коллекции  
    procedure TMailList.SetMailClient(Index: Integer; Value: TMailClient); 
    begin 
      Items[Index].Assign(Value); 
    end; 
     
     // Стандартный код при наследовании от класса коллекции: переопределяем тип  
    function TMailList.Add: TMailClient; 
    begin 
      Result := TMailClient(inherited Add); 
    end; 
     
    // создаем коллекцию адресатов рассылки TMailList 
    constructor TMailer.Create(AOwner: TComponent); 
    begin 
      inherited Create(AOwner); 
      MailList := TMailList.Create(TMailClient); 
    end; 
     
    destructor TMailer.Destroy; 
    begin 
      MailList.Free; 
      inherited; 
    end; 
    //---------------------  

Функция CreateFileList создает по каким-либо правилам список файлов на
основе переданного ей списка каталогов, обходя их рекурсивно. К примеру,
она может быть реализована так.


    procedure CreateFileList(sl: TStringList; const FilePath: string); 
    var 
      sr: TSearchRec; 
      procedure ProcessFile; 
      begin 
        if (sr.Name = '.')or(sr.Name = '..') then exit; 
        if sr.Attr <> faDirectory then 
          sl.Add(FilePath + '\' + sr.Name); 
        if sr.Attr = faDirectory then 
        begin 
          CreateFileList(sl, FilePath + '\' + sr.Name); 
        end; 
      end; 
    begin 
      if not DirectoryExists(FilePath) then exit; 
      if FindFirst(FilePath + '\' + '*.*', faAnyFile, sr) = 0 then ProcessFile; 
      while FindNext(sr) = 0 do ProcessFile; 
      FindClose(sr); 
    end; 

В итоге мы располагаем классом TMailer, содержащим всю необходимую нам
информацию. Теперь перейдем к созданию объекта, их сохранению и
загрузке.

    var 
      Mailer: TMailer; // это наш объект для хранения данных о почтовой рассылки
     
    // Процедура загрузки данных в объект. Может быть процедурой OnCreate() главной формы.
    procedure TfMain.FormCreate(Sender: TObject);
    var 
      sDataFile, sTmp: string; 
      i, j: integer;
    begin 
     
      Mailer := TMailer.Create(self); 
     
      // будем считать, что данные были сохранены в файл users.dat в каталоге программы
      sDataFile := ExtractFilePath(ParamStr(0)) + 'users.dat'; 
     
      //...загрузка данных из файла 
      if FileExists(sDataFile) then
        LoadComponentFromTextFile(Mailer, sDataFile); 
       { здесь данные из файла загружены }
     
      //...перебор подписчиков 
      for i:=0 to Mailer.MailList.Count-1 do 
      begin 
     
        sTmp := Mailer.MailList[i].Name;  //...обращение к имени 
        sTmp := Mailer.MailList[i].Address; //...обращение к адресу 
        //... sTmp - фиктивная переменная. Поменяйте ее на свои.  

        Mailer.MailList[i].PickFiles;  //... поиск файлов для отправки очередному подписчику. 
     
        //...перебор найденных файлов к отправке 
        for j:=0 to Mailer.MailList[i].Files.Count-1 do 
        begin 
          sTmp := Mailer.MailList[i].Files[j]; 
        end;

      end;
    end;

После загрузки данных мы можем работать с данными в нашей коллекции
подписчиков. Добавлять и удалять их ( Mailer.MailList.Add;
Mailer.MailList.Delete(Index); ). При завершении работы программы
необходимо сохранить уже новые данные в тот же файл.

    // Процедура сохранения данных из объекта в файл. Может быть процедурой OnDestroy() главной формы.
    procedure TfMain.OnDestroy;
    begin
      //...сохранение данных в файл users.dat
      SaveComponentToTextFile(Mailer, ExtractFilePath(ParamStr(0)) + 'users.dat'); 
    end;

Хранение данных в файле позволяет оказаться от использования БД, если
объем данных не слишком велик и нет необходимости в совместном доступе к
данным.
Самое главное - мы организуем все данные в виде набора удобных для
работы классов и не тратим время на их сохранение и инициализацию из
БД.

Приведенный пример лишь иллюстрирует этот подход. Для его реализации
могут подойти и 2 таблицы в БД. Однако приведенный подход удобен при
условии, что данные имеют сложную иерархию. К примеру, вложенные
коллекции разных типов гораздо сложнее разложить в базе данных, для их
извлечения потребуется SQL. Решайте сами, судя по своей конкретной
задаче.

Далее приведен код функций для сохранения/чтения компонента.


    //...процедура загружает(инициализирует) компонент из текстового файла с ресурсом 
    procedure LoadComponentFromTextFile(Component: TComponent; const FileName: string); 
    var 
      ms: TMemoryStream; 
      fs: TFileStream; 
    begin 
      fs := TFileStream.Create(FileName, fmOpenRead); 
      ms := TMemoryStream.Create; 
      try 
        ObjectTextToBinary(fs, ms); 
        ms.position := 0; 
        ms.ReadComponent(Component); 
      finally 
        ms.Free; 
        fs.free; 
      end; 
    end; 
     
    //...процедура сохраняет компонент в текстовый файл 
    procedure SaveComponentToTextFile(Component: TComponent; const FileName: string); 
    var 
      ms: TMemoryStream; 
      fs: TFileStream; 
    begin 
      fs := TFileStream.Create(FileName, fmCreate or fmOpenWrite); 
      ms := TMemoryStream.Create; 
      try 
        ms.WriteComponent(Component); 
        ms.position := 0; 
        ObjectBinaryToText(ms, fs); 
      finally 
        ms.Free; 
        fs.free; 
      end; 
    end; 

Составление статьи: Андрей Чудин, ЦПР ТД Библио-Глобус.

