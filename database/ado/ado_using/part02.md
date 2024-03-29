---
Title: Объекты соединения с источниками данных
Date: 01.01.2007
---


Объекты соединения с источниками данных
=======================================

Внутренний механизм ADO, обеспечивающий соединение с хранилищем данных,
использует два типа объектов. Это объекты-источники данных и
объекты-сессии.

Объект-источник данных обеспечивает представление информации о требуемом
реальном источнике данных и подключение к нему.

Для ввода сведений о хранилище данных используется интерфейс
iDBProperties. Для успешного подключения необходимо задать обязательные
сведения. Вероятно, для любого хранилища данных будет актуальной
информация об его имени, пользователе и пароле. Однако каждый тип
хранилища имеет собственные уникальные настройки. Для получения списка
всех обязательных параметров соединения с данным хранилищем можно
воспользоваться методом

    function GetPropertylnfo(cPropertylDSets: UINT; rgPropertylDSets:
      PDBPropIDSetArray; var pcPropertylnfoSets: UINT; out
      prgPropertylnfoSets: PDBPropInfoSet; ppDescBuffer: PPOleStr): HResult;
      stdcall;

который возвращает заполненную структуру DBPROPINFO.

    PDBPropInfo = ^TDBPropInfo;

    DBPROPINFO = packed record
      pwszDescription: PWideChar;
      dwPropertylD: DBPROPID;
      dwFlags: DBPROPFLAGS;
      vtType: Word;
      vValues: OleVariant;
    end; 

    TDBPropInfo = DBPROPINFO;

Для каждого обязательного параметра в элементе dwFlags устанавливается
значение DBPROPFLAGS\_REQUIRED.

Для инициализации соединения необходимо использовать метод

    function Initialize: HResult; stdcall;

интерфейса iDBinitiaiize объекта-источника данных.
