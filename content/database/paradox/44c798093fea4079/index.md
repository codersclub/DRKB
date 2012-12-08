---
Title: Создание таблицы с автоинкрементальным полем
Date: 01.01.2007
---


Создание таблицы с автоинкрементальным полем
============================================

::: {.date}
01.01.2007
:::

Допустим у вас имеется форма с кнопкой. Щелчок на кнопке с помощью
DbiCreateTable должен создать таблицу Paradox с автоинкрементальным
(приращиваемым) полем.

    unit Autoinc;
     
    interface
     
    uses
      SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
      Forms, Dialogs, DBTables, DB, ExtCtrls, DBCtrls, Grids, DBGrids, StdCtrls,
      DbiTypes, DbiErrs, DBIProcs;
     
    const
      szTblName = 'CR8PXTBL'; { Имя создаваемой таблицы. }
      szTblType = szPARADOX; { Используемый тип таблицы. }
     
      { При создании таблицы используется полное описание поля }
    const
      fldDes: array[0..1] of FLDDesc = (
        ({ Поле 1 - AUTOINC }
        iFldNum: 1; { Номер поля }
        szName: 'AUTOINC'; { Имя поля }
        iFldType: fldINT32; { Тип поля }
        iSubType: fldstAUTOINC; { Подтип поля }
        iUnits1: 0; { Размер поля }
        iUnits2: 0; { Десятичный порядок следования ( 0 ) }
        iOffset: 0; { Смещение в записи     ( 0 ) }
        iLen: 0; { Длина в байтах        ( 0 ) }
        iNullOffset: 0; { Для Null-битов        ( 0 ) }
        efldvVchk: fldvNOCHECKS; { Проверка корректности ( 0 ) }
        efldrRights: fldrREADWRITE { Права }
        ),
        ({ Поле 2 - ALPHA }
        iFldNum: 2; szName: 'ALPHA';
        iFldType: fldZSTRING; iSubType: fldUNKNOWN;
        iUnits1: 10; iUnits2: 0;
        iOffset: 0; iLen: 0;
        iNullOffset: 0; efldvVchk: fldvNOCHECKS;
        efldrRights: fldrREADWRITE
        ));
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
        Database1: TDatabase;
        procedure Button1Click(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      TblDesc: CRTblDesc;
      uNumFields: Integer;
      Rslt: DbiResult;
      ErrorString: array[0..dbiMaxMsgLen] of Char;
    begin
      FillChar(TblDesc, sizeof(CRTblDesc), #0);
      lStrCpy(TblDesc.szTblName, szTblName);
      lStrCpy(TblDesc.szTblType, szTblType);
      uNumFields := trunc(sizeof(fldDes) / sizeof(fldDes[0]));
      TblDesc.iFldCount := uNumFields;
      TblDesc.pfldDesc := @fldDes;
     
      Rslt := DbiCreateTable(Database1.Handle, TRUE, TblDesc);
      if Rslt <> dbiErr_None then
      begin
        DbiGetErrorString(Rslt, ErrorString);
        MessageDlg(StrPas(ErrorString), mtWarning, [mbOk], 0);
      end;
    end;
     
    end.

Взято с <https://delphiworld.narod.ru>
