<h1>Работа с транзакциями</h1>
<div class="date">01.01.2007</div>


<pre>
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
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
