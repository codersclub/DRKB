<h1>Выполнение запросов к базе данных в фоне</h1>
<div class="date">01.01.2007</div>


<p>Данный документ объясняет как выполнить запрос в фоновом режиме, используя класс TThread. Для получения общей информации о классе TThread, пожалуйста обратитесь к документации Borland и электронной справке. Для понимания данного документа вам необходимо иметь представление о том, как работать с компонентами для работы с базами данных, поставляемых в комплекте с Delphi 2.0. </p>

<p>Для осуществления потокового запроса необходимо выполнение двух требований. Во-первых, потоковый запрос должен находиться в своей собственной сессии с использованием отдельного компонента TSession. Следовательно, на вашей форме должен находиться компонент TSession, имя которого должно быть назначено свойству SessonName компонента TQuery, используемого для выполнения потокового запроса. Для каждого используемого в потоке компонента TQuery вы должны использовать отдельный компонент TSession. При использовании компонента TDataBase, для отдельного потокового запроса должен также использоваться отдельный TDataBase. Второе требование заключается в том, что компонент TQuery, используемый в потоке, не должен подключаться в контексте это потока к TDataSource. Это должно быть сделано в контексте первичного потока. </p>

<p>Приведенный ниже пример кода иллюстрирует описываемый процесс. Данный модуль демонстрирует форму, которая содержит по два экземпляра следующих компонентов: TSession, TDatabase, TQuery, TDataSource и TDBGrid. Данные компоненты имеют следующие значения свойств:</p>

<p>  Session1 </p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;Active &nbsp; &nbsp; &nbsp; &nbsp;True;</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;SessionName &nbsp; &nbsp; &nbsp; &nbsp;"Ses1"</p>

<p>  DataBase1</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;AliasName &nbsp; &nbsp; &nbsp; &nbsp;"IBLOCAL"</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;DatabaseName &nbsp; &nbsp; &nbsp; &nbsp;"DB1"</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;SessionName &nbsp; &nbsp; &nbsp; &nbsp;"Ses1"</p>

<p>  Query1</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;DataBaseName &nbsp; &nbsp; &nbsp; &nbsp;"DB1"</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;SessionName &nbsp; &nbsp; &nbsp; &nbsp;"Ses1"</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;SQL.Strings &nbsp; &nbsp; &nbsp; &nbsp;"Select * from employee"</p>

<p>  DataSource1</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;DataSet &nbsp; &nbsp; &nbsp; &nbsp;""</p>

<p>  DBGrid1</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;DataSource &nbsp; &nbsp; &nbsp; &nbsp;DataSource1</p>

<p>  Session2</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;Active &nbsp; &nbsp; &nbsp; &nbsp;True;</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;SessionName &nbsp; &nbsp; &nbsp; &nbsp;"Ses2"</p>

<p>  DataBase2</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;AliasName &nbsp; &nbsp; &nbsp; &nbsp;"IBLOCAL"</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;DatabaseName &nbsp; &nbsp; &nbsp; &nbsp;"DB2"</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;SessionName &nbsp; &nbsp; &nbsp; &nbsp;"Ses2"</p>

<p>  Query2</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;DataBaseName &nbsp; &nbsp; &nbsp; &nbsp;"DB2"</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;SessionName &nbsp; &nbsp; &nbsp; &nbsp;"Ses2"</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;SQL.Strings &nbsp; &nbsp; &nbsp; &nbsp;"Select * from customer"</p>

<p>  DataSource2</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;DataSet &nbsp; &nbsp; &nbsp; &nbsp;""</p>

<p>  DBGrid1</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;DataSource &nbsp; &nbsp; &nbsp; &nbsp;DataSource2</p>

<p>Обратите внимание на то, что свойство DataSet обоих компонентов TDataSource первоначально никуда не ссылается. Оно устанавливается во время выполнения приложения, и это проиллюстрировано в коде.</p>

<pre>
unit Unit1;
 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls,
  Forms, Dialogs, StdCtrls, Grids, DBGrids, DB, DBTables;
 
type
 
  TForm1 = class(TForm)
    Session1: TSession;
    Session2: TSession;
    Database1: TDatabase;
    Database2: TDatabase;
    Query1: TQuery;
    Query2: TQuery;
    DataSource1: TDataSource;
    DataSource2: TDataSource;
    DBGrid1: TDBGrid;
    DBGrid2: TDBGrid;
    GoBtn1: TButton;
    procedure GoBtn1Click(Sender: TObject);
  end;
 
  TQueryThread = class(TThread)
  private
    FSession: TSession;
    FDatabase: TDataBase;
    FQuery: TQuery;
    FDatasource: TDatasource;
    FQueryException: Exception;
    procedure ConnectDataSource;
    procedure ShowQryError;
  protected
    procedure Execute; override;
  public
    constructor Create(Session: TSession; DataBase:
      TDatabase; Query: TQuery; DataSource: TDataSource);
      virtual;
  end;
 
var
  Form1: TForm1;
 
implementation
 
constructor TQueryThread.Create(Session: TSession; DataBase: TDatabase; Query:
  TQuery; Datasource: TDataSource);
begin
  inherited Create(True); // Создаем поток c состоянием suspendend
  FSession := Session; // подключаем все privat-поля
  FDatabase := DataBase;
  FQuery := Query;
  FDataSource := Datasource;
  FreeOnTerminate := True;
    // Устанавливаем флаг освобождения потока после его завершения
  Resume; // Продолжение выполнения потока
end;
 
procedure TQueryThread.Execute;
begin
  try
    { Выполняем запрос и подключаем источник данных к компоненту TQuery,
    вызывая ConnectDataSource из основного потока
    (для этой цели используем Synchronize)}
    FQuery.Open;
    Synchronize(ConnectDataSource);
  except
    { Ловим исключение (если оно происходит) и его дескриптор
    в контексте основного потока (для этой цели используем
    Synchronize). }
    FQueryException := ExceptObject as Exception;
    Synchronize(ShowQryError);
  end;
end;
 
procedure TQueryThread.ConnectDataSource;
begin
  FDataSource.DataSet := FQuery; // Подключаем DataSource к TQuery
end;
 
procedure TQueryThread.ShowQryError;
begin
  Application.ShowException(FQueryException); // Обрабатываем исключение
end;
 
procedure RunBackgroundQuery(Session: TSession; DataBase: TDataBase; Query:
  TQuery; DataSource: TDataSource);
begin
  { Создаем экземпляр TThread с различными параметрами. }
  TQueryThread.Create(Session, Database, Query, DataSource);
end;
 
{$R *.DFM}
 
procedure TForm1.GoBtn1Click(Sender: TObject);
begin
  { Запускаем два отдельных запроса, каждый в своем потоке }
  RunBackgroundQuery(Session1, DataBase1, Query1, Datasource1);
  RunBackgroundQuery(Session2, DataBase2, Query2, Datasource2);
end;
 
end.
</pre>


<p>Метод TForm1.GoBtn1Click является обработчиком события нажатия кнопки. Данный обработчик события дважды вызывает процедуру RunBackgroundQuery, это случается при каждой передаче новых параметров компонентам для работы с базой данных. RunBackgroundQuery создает отдельный экземпляр класса TQueryThread, передает различные компоненты для работы с базой данных в его конструктор, который, в свою очередь, назначает их закрытым полям TQueryThread. </p>

<p>TQueryThread содержит две определенные пользователем процедуры: ConnectDataSource и ShowQryError. ConnectDataSource связывает FDataSource.DataSet с FQuery. Тем не менее, это делается в первичном потоке с помощью метода TThread.Synchronize. ShowQryError обрабатывает исключение в контексте первиного потока, также используя метод Synchronize. Конструктор Create и метод Execute снабжены подробными комментариями.</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
