---
Title: Работа с транзакциями
Date: 01.01.2007
DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Работа с транзакциями
=====================

    dbMain.StartTransaction;
    try
      spAddOrder.ParamByName('ORDER_NO').AsInteger := OrderNo;
      spAddOrder.ExecProc;
      for i := 0 to PartList.Count - 1 do
      begin
         spReduceParts.ParamByName('PART_NO').AsInteger := PartRec(PartList.Objects[i]).PartNo;
         spReduceParts.ParamByName('NUM_SOLD').AsInteger := PartRec(PartList.Objects[i]).NumSold;
      end;
      dbMain.Commit;
    except
      dbMain.RollBack;
      raise;
    end;


