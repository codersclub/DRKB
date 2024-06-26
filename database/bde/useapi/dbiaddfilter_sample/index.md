---
Title: Пример DbiAddFilter
Author: Mark Erbaugh
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Пример DbiAddFilter
===================

    type
      TmyFilter = record
        Expr: CANExpr;
        Nodes: array[0..2] of CANNode;
        literals: array[0..7] of char;
      end;
     
    const
      myFilter: TMyFilter = (Expr:
        (iVer: 1; iTotalSize: sizeof(TMyFilter); iNodes: 3;
        iNodeStart: sizeof(CANExpr); iLiteralStart: sizeof(CANExpr) +
        3 * sizeof(CANNode));
        Nodes:
        ((canBinary: (nodeClass: nodeBinary; canOP: canEQ;
        iOperand1: sizeof(CANNode); iOperand2: 2 * sizeof(CANNode))),
        (canField: (nodeClass: nodeField; canOP: canField2;
        iFieldNum: 0; iNameOffset: 0)),
        (canConst: (nodeClass: nodeConst; canOP: canCONST2;
        iType: fldZSTRING; iSize: 3; iOffset: 5)));
        literals:
        ('T', 'Y', 'P', 'E', #0, 'I', 'N', #0));
     
    var
      dbResult: DBIResult;
      hFilter, hFilter1: hDBIFilter;
    begin (* procedure SetupFilter *)
      dbResult := DbiAddFilter(tblAP_.Handle, 1, 1,
        False, addr(myFilter), nil, hFilter);
      dbResult := DbiActivateFilter(tblAP_.Handle, hFilter);
      tblAP_.First;
      myFilter.nodes[0].canBinary.canOp := canNE;
      dbResult := DbiAddFilter(tblAP1_.Handle, 1, 1,
        False, addr(myFilter), nil, hFilter1);
      dbResult := DbiActivateFilter(tblAP1_.Handle, hFilter1);
      tblAP1_.First;
      myFilter.nodes[0].canBinary.canOp := canEQ;
    end;

Этот пример устанавливает два фильтра. Первый (применяемый к tblAP\_)
выводит все записи, где ТИП поля имеет значение \'IN\'. Второй
(применяемый к tblAP1\_) выводит все записи, где ТИП поля не имеет
значения \'IN\'.

Также необходимо включить в ваш файл файлы DBITYPES и DBIPROCS, где
определены вызываемые функции и константы.

