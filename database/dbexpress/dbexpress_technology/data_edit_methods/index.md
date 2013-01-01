---
Title: Способы редактирования данных
Date: 01.01.2007
---


Способы редактирования данных
=============================

::: {.date}
01.01.2007
:::

Несмотря на декларированные недостатки технологии dbExpress -
однонаправленные курсоры и невозможность редактирования - существуют
программные способы уменьшить масштаб проблемы или даже решить ее.

Во-первых, в нашем распоряжении имеется компонент TSimpleDataSet,
который реализует двунаправленный курсор и обеспечивает редактирование
данных путем их кэширования на клиентской стороне.

Во-вторых, редактирование можно обеспечить настройкой и выполнением
запросов SQL INSERT, UPDATE и DELETE.

У каждого способа есть свои преимущества и недостатки.

Компонент TSimpleDataSet безусловно хорош. Он технологичен, относительно
прост в использовании и, главное, прячет всю функциональность за
несколькими свойствами и методами. Но локальное кэширование изменений
подходит далеко не для всех приложений.

Например, при многопользовательском интенсивном доступе к данным с их
редактированием при локальном кэшировании могут возникнуть проблемы с
целостностью и адекватностью данных. Самый распространенный пример:
продавец в строительном супермаркете, обслуживая покупателя в пик летних
ремонтов, резервирует несколько наименований ходовых товаров. Но
покупатель замешкался, выбирая обои и плитку. А за это время другой
продавец уже продал другому покупателю (заказ первого покупателя еще
находится в локальном кэше!) часть его товаров.

Конечно, фиксацию изменений на сервере можно выполнять после локального
сохранения каждой записи, но это приведет к загрузке соединения и
снижению эффективности системы.

Использование модифицирующих запросов, с одной стороны, позволяет
оперативно вносить изменения в данные на сервере, а с другой - требует
больших затрат на программирование и отладку. Сложность кода в этом
случае существенно выше.

Рассмотрим небольшой пример реализации обоих способов. Приложение Demo
DBX использует соединение с сервером InterBase. Подключена тестовая база
данных \\Borland Shared\\Data\\MastSQL.gdb.

Пример приложения dbExpress с редактируемыми наборами данных

    implementation 
     {$R *.dfm} 
    procedure TfmDemoDBX.FormCreate(Sender: TObj ect); 
     begin 
       tblVens.Open; 
       cdsGusts.Open; 
     end; 
     
    procedure TfmDemoDBX.FormDestroy(Sender: TObject); 
     begin 
      tblVens.Close; 
      cdsCusts.Close; 
     end; 
     
    {Editing feature with updating query} 
    procedure TfmDemoDBX.tblVensAfterScroll(DataSet: TDataSet); 
     begin 
      edVenNo.Text := tblVens.FieldByName('VENDORNO').AsString;  
      edVenName.Text := tblVens.FieldByName('VENDORNAME').AsString;   
      edVenAdr.Text := tblVens.FieldByName('ADDRESS1')AsString; 
      edVenCity.Text := tblVens.FieldByName('CITY').AsString;  
      edVenPhone.Text := tblVens.FieldByName('PHONE').AsString;  
    end; 
     
    procedure TfmDemoDBX.sbCancelClick(Sender: TObject); 
    begin 
      tblVens.First;  
    end; 
     
    procedure TfmDemoDBX.sbNextClick(Sender: TObject); 
    begin 
      tblVens.Next; 
    end; 
     
    procedure TfmDemoDBX.sbPostClick(Sender: TObject); 
    begin 
      with quUpdate do 
      try 
        ParamByName('4dx').Aslnteger :=
     tblVens.FieldByName('VENDORNO').Aslnteger;  
        ParamByName('No').AsString := edVenNo.Text;  
        ParamByName('Name').AsString := edVenName.Text; 
        ParamByName('Adr').AsString := edVenAdr.Text; 
        ParamByName('City').AsString := edVenCity.Text; 
        ParamByName('Phone1').AsString := edVenPhone.Text;  
        ExecSQL; 
      except 
        MessageDlg('Vendors info post error', mtError, [mbOK], 0); 
        tblVens.First; 
      end; 
    end; 
     
    {Editing feature with cached updates} 
    procedure TfmDemoDBX.cdsCustsAfterPost(DataSet: TDataSet); 
    begin 
      cdsCusts.ApplyUpdates(-1); 
    end; 
     
    procedure TfmDemoDBX.cdsCustsReconcileError(DataSet:TCustomClientDataSet; 
    E: EReconcileError; UpdateKind: TUpdateKind; var Action: TReconcileAction); 
    begin 
      MessageDlg('Customers info post error', mtError, [mbOK], 0); 
      cdsCusts.CancelUpdates; 
    end; 
     
    end. 

Для просмотра и редактирования выбраны таблицы Vendors и Customers.
Первая таблица подключена через настроенное соединение (компонент
cnMast) к компоненту tbivens типа TSQLTable. Значение пяти полей
отображается в обычных компонентах TEdit, т. к. компоненты отображения
данных, связанные с компонентом dbExpress через компонент TDataSource,
работают только в режиме просмотра, не позволяя редактировать данные

Использование метода-обработчика AfterScroll позволило легко решить
проблему заполнения компонентов TEdit при навигации по набору данных.
Для сохранения сделанных изменений (нажатие на кнопку sbPost)
используется компонент quupdate типа TSQLQuery. В параметрах запроса
передаются текущие значения полей из компонентов TEdit. Так как в этом
случае работает однонаправленный курсор, проблема обновления набора
данных после выполнения модифицирующего запроса не возникает и набор
данных обновляется только при вызове метода First компонента tbivens.

Вторая таблица подключена через тот же компонент cnMast к компоненту
cdsCusts типа TSimpleDataSet. Он работает в табличном режиме. Данные
отображаются в обычном компоненте TDBGrid.

Для сохранения сделанных изменений здесь использован метод Appiyupdates,
размещенный в методе-обработчике AfterPost, когда изменения уже попали в
локальный кэш. Метод-обработчик вызывается каждый раз при переходе в
компонент TDBGrid на новую строку.

Для компонента cdscusts также предусмотрена простейшая обработка
исключительных ситуаций, возникающих на сервере. Обратите также внимание
на настройку компонента cnMast типа TSQLConnection. Свойства
KeepConnection И LoginPrompt со значениями False обеспечивают открытие
наборов данных при создании формы и автоматическое закрытие соединения
при закрытии приложения с минимальным исходным кодом.
