<h1>Передача параметров ADO запросу</h1>
<div class="date">01.01.2007</div>


<pre class="delphi">
CONECT_STR = 'Provider=Microsoft.Jet.OLEDB.4.0;Password=" " ;User ID=Admin;' + {Data Source=D:\ExBd\ТЕРМО\Bd0.mdb;}
'Data Source=%s; Mode=Read|Write|Share Deny None;Extended Properties=" " ;' +
'Locale Identifier=1049;Persist Security Info=True;Jet OLEDB:System database=" " ;' +
'Jet OLEDB:Registry Path=" " ;Jet OLEDB:Database Password=" " ;Jet OLEDB:Engine Type=4;' +
'Jet OLEDB:Database Locking Mode=0;Jet OLEDB:Global Partial Bulk Ops=2;' +
'Jet OLEDB:Global Bulk Transactions=1;Jet OLEDB:New Database Password=" " ;' +
'Jet OLEDB:Create System Database=False;Jet OLEDB:Encrypt Database=False;' +
'Jet OLEDB:Compact Without Replica Repair=False;Jet OLEDB:SFP=False';
 
function TdmR3.GetCountForPeriod(LastDate: TDateTime; IsPlan: boolean): Integer;
var qu: TADOQuery;
  S: string;
begin
  qu := TADOQuery.Create(nil);
  try
    S := FormatDateTime('dd.mm.yy', LastDate);
    qu.ConnectionString := WideString(Format(CONECT_STR, [db_file]));
    qu.SQL.Text := 'select count(*) from DecadaVal as d where d.LastDate=:LastDate and IsPlan=:IsPlan';
    qu.Parameters[0].Value := LastDate;
    qu.Parameters[1].Value := IsPlan;
    qu.Open;
    Result := qu.Fields[0].AsInteger;
  finally
    qu.Free;
  end;
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

<p class="note">Примечание Vit</p>

<p>Я привёл этот код так как он был на сайте и его правильность целиком на совести автора. Однако приведенный код полон неточностей и могут быть проблемы при его выполнении. Давайте разберём что здесь не так и как сделать его работающим:</p>

<pre class="delphi">
function TdmR3.GetCountForPeriod(LastDate: TDateTime; IsPlan: boolean): Integer;
var qu: TADOQuery;
  S: string;
begin

  qu := TADOQuery.Create(nil);
  try
//    S := FormatDateTime('dd.mm.yy', LastDate); нам не нужна эта строка
    qu.ConnectionString := Format(CONECT_STR, [db_file]); //Delphi автоматически приводит тип String в WideString
    qu.SQL.Text := 'select count(*) from DecadaVal as d where d.LastDate=:LastDate and IsPlan=:IsPlan';
    //Дельфи вовсе не автоматом распознает параметры, мы должны заставить его правильно провести парсинг параметров, для чего и служит следующая строка:
    qu.Parameters.ParseSQL(qu.SQL.Text, true); //если кверя создана в дизайне и текст SQL присвоен в дизайне то эта строка не понадобится
// я предпочитаю обращаться к параметрам по имени, это избавит от многочисленных и сложных в отладке ошибок
    qu.Parameters.ParamByName('LastDate').Value := LastDate;
    qu.Parameters.ParamByName('IsPlan').Value := IsPlan;
    qu.Open;
    Result := qu.Fields[0].AsInteger;
  finally
    qu.Free;
  end;
end;
</pre>

