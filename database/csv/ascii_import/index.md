---
Title: Импорт CSV ASCII
Date: 01.01.2007
---


Импорт CSV ASCII
================

::: {.date}
01.01.2007
:::

    unit Cdbascii;
     
    interface
     
    uses
     
      SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
      Forms, Dialogs, DbiErrs, DbiTypes, DbiProcs, DB, DBTables;
     
    type
     
      TAsciiDelimTable = class(TTable)
      private
    { Private declarations }
        fQuote: Char;
        fDelim: Char;
      protected
    { Protected declarations }
        function CreateHandle: HDBICur; override;
        procedure SetQuote(newValue: Char);
        procedure SetDelim(newValue: Char);
      public
    { Public declarations }
        constructor Create(AOwner: TComponent); override;
        destructor Destroy; override;
    { Эти свойства не должны больше публиковаться }
        property IndexFieldNames;
        property IndexName;
        property MasterFields;
        property MasterSource;
        property UpdateMode;
      published
    { Published declarations }
        property Quote: Char read fQuote write setQuote default '"';
        property Delim: Char read fDelim write setDelim default ',';
      end;
     
    procedure Register;
     
    implementation
     
    uses DBConsts;
     
    procedure Register;
    begin
     
      RegisterComponents('Data Access', [TAsciiDelimTable]);
    end;
     
    constructor TAsciiDelimTable.Create(AOwner: TComponent);
    begin
     
      inherited Create(AOwner);
      Exclusive := True;
      TableType := ttASCII;
      fQuote := '"';
      fDelim := ',';
    end;
     
    destructor TAsciiDelimTable.Destroy;
    begin
     
      inherited Destroy;
    end;
     
    { Рабочий код }
     
    function CheckOpen(Status: DBIResult): Boolean;
    begin
     
      case Status of
        DBIERR_NONE:
          Result := True;
        DBIERR_NOTSUFFTABLERIGHTS:
          begin
            if not Session.GetPassword then DbiError(Status);
            Result := False;
          end;
      else
        DbiError(Status);
      end;
    end;
     
    function TAsciiDelimTable.CreateHandle: HDBICur;
    const
     
      OpenModes: array[Boolean] of DbiOpenMode = (dbiReadWrite, dbiReadOnly);
      ShareModes: array[Boolean] of DbiShareMode = (dbiOpenShared, dbiOpenExcl);
    var
     
      STableName: array[0..SizeOf(TFileName) - 1] of Char;
      SDriverType: array[0..12] of Char;
    begin
     
      if TableName = '' then DBError(SNoTableName);
      AnsiToNative(DBLocale, TableName, STableName, SizeOf(STableName) - 1);
      StrPCopy(SDriverType, 'ASCIIDRV-' + Quote + '-' + Delim);
      Result := nil;
      while not CheckOpen(DbiOpenTable(DBHandle, STableName, SDriverType,
        nil, nil, 0, OpenModes[ReadOnly], ShareModes[Exclusive],
        xltField, False, nil, Result)) do {Повтор}
        ;
    end;
     
    procedure TAsciiDelimTable.SetQuote(newValue: Char);
    begin
     
      if Active then
    {    DBError(SInvalidBatchMove); };
      fQuote := newValue;
    end;
     
    procedure TAsciiDelimTable.SetDelim(newValue: Char);
    begin
     
      if Active then
    {    DBError(SInvalidBatchMove); };
      fDelim := newValue;
    end;
     
    end.

Взято из Советов по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com)

Сборник Kuliba
