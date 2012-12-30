---
Title: Формат и размер dBase-поля
Date: 01.01.2007
---


Формат и размер dBase-поля
==========================

::: {.date}
01.01.2007
:::

    procedure GetdBaseFieldTypes(t: TTable; var l: TStringList);
    var
      pF: pFLDDesc;
      cProps: CURProps;
      p: pFLDDesc;
      i: Byte;
      w: Word;
      s: string;
      oldmode: LongInt;
    begin
      Check(DbiGetCursorProps(t.Handle, cProps));
      Check(DbiGetProp(hDBIObj(t.Handle), curXLTMODE, oldmode, SizeOf(LongInt), w));
      Check(DbiSetProp(hDBIObj(t.Handle), curXLTMODE, LongInt(xltNONE)));
      try
        if MaxAvail < (cProps.iFields * SizeOf(FLDDesc)) then
          raise EOutofMemory.Create('Недостаточно памяти для процесса');
        GetMem(pF, (cProps.iFields * SizeOf(FLDDesc)));
        Check(DbiGetFieldDescs(t.Handle, pF));
        p := pF;
        for i := 1 to cProps.iFields do
          begin
            with p^ do
              begin
                s := IntToStr(iFldNum) + ' : ' + StrPas(szName) + ' : ';
                case iFldType of
                  fldDBCHAR:
                    begin { Char string, строка символов }
                      s := s + 'CHARACTER(' + IntToStr(iUnits1) + ')';
                    end;
                  fldDBNUM:
                    begin { Number, число }
                      s := s + 'NUMBER(' + IntToStr(iUnits1) + ',' + InttoStr(iUnits2) + ')';
                    end;
                  fldDBMEMO:
                    begin { Memo (blob), МEMO-BLOB-поле }
                      s := s + 'MEMO';
                    end;
                  fldDBBOOL:
                    begin { Logical, лочическая величина }
                      s := s + 'LOGICAL';
                    end;
                  fldDBDATE:
                    begin { Date, поле даты }
                      s := s + 'DATE';
                    end;
                  fldDBFLOAT:
                    begin { Float, числа с плавающей точкой }
                      s := s + 'FLOAT(' + IntToStr(iUnits1) + ',' + InttoStr(iUnits2) + ')';
                    end;
                  fldDBLOCK:
                    begin { Логический тип LOCKINFO }
                      s := s + 'LOCKINFO';
                    end;
                  fldDBOLEBLOB:
                    begin { OLE object (blob), OLE-объект, BLOB-поле }
                      s := s + 'OLE';
                    end;
                  fldDBBINARY:
                    begin { Binary data (blob), двоичные данные, BLOB-поле }
                      s := s + 'BINARY';
                    end;
                else
                  s := s + 'НЕИЗВЕСТНО';
                end;
              end;
            l.Add(s);
            Inc(p);
          end;
      finally
        Check(DbiSetProp(hDBIObj(t.Handle), curXLTMODE, oldmode));
        FreeMem(pF, (cProps.iFields * SizeOf(FLDDesc)));
      end;
    end;

-Eryk Bottomley

Взято из Советов по Delphi от [Валентина
Озерова](mailto:mailto:webmaster@webinspector.com)

Сборник Kuliba
