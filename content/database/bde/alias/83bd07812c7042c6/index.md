---
Title: Задание псевдонима программным путем
Date: 01.01.2007
---


Задание псевдонима программным путем
====================================

::: {.date}
01.01.2007
:::

Эта информация поможет вам разобраться в вопросе создания и
использования ПСЕВДОНИМОВ баз данных в ваших приложениях.

Вне Delphi создание и конфигурирование псевдонимов осуществляется
утилитой BDECFG.EXE. Тем не менее, применяя компонент TDatabase, вы
можете в вашем приложении создать и использовать псевдоним, не
определенный в IDAPI.CFG.

Важно понять, что создав псевдоним, использовать его можно только в
текущем сеансе вашего приложения. Псевдонимы определяеют расположение
таблиц базы данных и параметры связи с сервером баз данных. В конце
концов, вы получаете преимущества использования псевдонимов в пределах
вашего приложения без необходимости беспокоиться о наличии их в
конфигурационном файле IDAPI.CFG в момент инициализации приложения.

Некоторые варианты решения задачи:

Пример \#1:

Пример \#1 создает и конфигурирует псевдоним для базы данных STANDARD
(.DB, .DBF). Псевдоним затем используется компонентом TTable.

Пример \#2:

Пример \#2 создает и конфигурирует псевдоним для базы данных INTERBASE
(.gdb). Псевдоним затем используется компонентом TQuery для подключения
к двум таблицам базы данных.

Пример \#3:

Пример \#3 создает и конфигурирует псевдоним для базы данных STANDARD
(.DB, .DBF). Демонстрация ввода псевдонима пользователем и его
конфигурация во время выполнения программы.

Пример \#1: Используем базу данных .DB или .DBF (STANDARD)

Создаем новый проект.

Располагаем на форме следующие компоненты: - TDatabase, TTable,
TDataSource, TDBGrid, and TButton.

Дважды щелкаем на компоненте TDatabase или через контекстное меню
(правая кнопка мыши) вызываем редактор базы данных.

Присваиваем базе данных имя \'MyNewAlias\'. Это имя будет выполнять роль
псевдонима в свойстве DatabaseName для компонентов типа TTable, TQuery,
TStoredProc.

Выбираем в поле Driver Name (имя драйвера) пункт STANDARD.

Щелкаем на кнопке Defaults. Это автоматически добавляет путь (PATH=) в
секцию перекрытых параметров (окно Parameter Overrides).

Устанавливаем PATH= to C:\\DELPHI\\DEMOS\\DATA
(PATH=C:\\DELPHI\\DEMOS\\DATA).

Нажимаем кнопку OK и закрываем окно редактора.

В компоненте TTable свойству DatabaseName присваиваем \'MyNewAlias\'.

В компоненте TDataSource свойству DataSet присваиваем \'Table1\'.

В компоненте DBGrid свойству DataSource присваиваем \'DataSource1\'.

Создаем в компоненте TButton обработчик события OnClick.

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      Table1.Tablename:= 'CUSTOMER';
      Table1.Active:= True;
    end;

Запускаем приложение.

\*\*\* В качестве альтернативы шагам 3 - 11, вы можете включить все эти
действия в сам обработчик:

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      Database1.DatabaseName:= 'MyNewAlias';
      Database1.DriverName:= 'STANDARD';
      Database1.Params.Clear;
      Database1.Params.Add('PATH=C:\DELPHI\DEMOS\DATA');
      Table1.DatabaseName:= 'MyNewAlias';
      Table1.TableName:= 'CUSTOMER';
      Table1.Active:= True;
      DataSource1.DataSet:= Table1;
      DBGrid1.DataSource:= DataSource1;
    end;

Пример \#2: Используем базу данных INTERBASE

Создаем новый проект.

Располагаем на форме следующие компоненты: - TDatabase, TQuery,
TDataSource, TDBGrid, and TButton.

Дважды щелкаем на компоненте TDatabase или через контекстное меню
(правая кнопка мыши) вызываем редактор базы данных.

Присваиваем базе данных имя \'MyNewAlias\'. Это имя будет выполнять роль
псевдонима в свойстве DatabaseName для компонентов типа TTable, TQuery,
TStoredProc.

Выбираем в поле Driver Name (имя драйвера) пункт INTRBASE.

Щелкаем на кнопке Defaults. Это автоматически добавляет путь (PATH=) в
секцию перекрытых параметров (окно Parameter Overrides).

       SERVER NAME=IB\_SERVEER:/PATH/DATABASE.GDB

       USER NAME=MYNAME

       OPEN MODE=READ/WRITE

       SCHEMA CACHE SIZE=8

       LANGDRIVER=

       SQLQRYMODE=

       SQLPASSTHRU MODE=NOT SHARED

       SCHEMA CACHE TIME=-1

       PASSWORD=

Устанавливаем следующие параметры

       SERVER NAME=C:\\IBLOCAL\\EXAMPLES\\EMPLOYEE.GDB

       USER NAME=SYSDBA

       OPEN MODE=READ/WRITE

       SCHEMA CACHE SIZE=8

       LANGDRIVER=

       SQLQRYMODE=

       SQLPASSTHRU MODE=NOT SHARED

       SCHEMA CACHE TIME=-1

       PASSWORD=masterkey

В компоненте TDatabase свойство LoginPrompt устанавливаем в \'False\'.
Если в секции перекрытых параметров (Parameter Overrides) задан пароль
(ключ PASSWORD) и свойство LoginPrompt установлено в \'False\', при
соединении с базой данный пароль запрашиваться не будет. Предупреждение:
при неправильно указанном пароле в секции Parameter Overrides и
неактивном свойстве LoginPrompt вы не сможете получить доступ к базе
данных, поскольку нет возможности ввести правильный пароль - диалоговое
окно \"Ввод пароля\" отключено свойством LoginPrompt.

Нажимаем кнопку OK и закрываем окно редактора.

В компоненте TQuery свойству DatabaseName присваиваем \'MyNewAlias\'.

В компоненте TDataSource свойству DataSet присваиваем \'Query1\'.

В компоненте DBGrid свойству DataSource присваиваем \'DataSource1\'.

Создаем в компоненте TButton обработчик события OnClick.

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      Query1.SQL.Clear;
      Query1.SQL.ADD(
      'SELECT DISTINCT * FROM CUSTOMER C, SALES S
        WHERE (S.CUST_NO = C.CUST_NO)
        ORDER BY C.CUST_NO, C.CUSTOMER');
      Query1.Active:= True;
    end;

Запускаем приложение.

Пример \#3: Ввод псевдонима пользователем

Этот пример выводит диалоговое окно и создает псевдоним на основе
информации, введенной пользователем.

Директория, имя сервера, путь, имя базы данных и другая необходимая
информация для получения псевдонима может быть получена приложением из
диалогово окна или конфигурационного .INI файла.

Выполняем шаги 1-11 из примера \#1.

Пишем следующий обработчик события OnClick компонента TButton:

    procedure TForm1.Button1Click(Sender: TObject);
    var
      NewString: string;
      ClickedOK: Boolean;
    begin
      NewString := 'C:\';
      ClickedOK := InputQuery('Database Path',
        'Path: --> C:\DELPHI\DEMOS\DATA', NewString);
      if ClickedOK then
      begin
        Database1.DatabaseName := 'MyNewAlias';
        Database1.DriverName := 'STANDARD';
        Database1.Params.Clear;
        Database1.Params.Add('Path=' + NewString);
        Table1.DatabaseName := 'MyNewAlias';
        Table1.TableName := 'CUSTOMER';
        Table1.Active := True;
        DataSource1.DataSet := Table1;
        DBGrid1.DataSource := DataSource1;
      end;
    end;

Запускаем приложение.

Взято с <https://delphiworld.narod.ru>
