<h1>Вызов процедуры, имя которой содержится в переменной</h1>
<div class="date">01.01.2007</div>


<p>Как я могу вызвать процедуру, чье имя хранится в таблице, списке, и т.п.? Другими словами, я хочу сохранить имя процедуры в переменной и для ее вызова обращаться к значению этой переменной. Какие предложения?</p>

<pre>
unit ProcDict;
 
interface
 
type MyProc = procedure(s: string);
 
procedure RegisterProc(procName: string; proc: MyProc);
procedure ExecuteProc(procName: string; arg: string);
 
implementation
 
uses Classes;
var ProcDict: TStringList;
 
procedure RegisterProc(procName: string; proc: MyProc);
begin
  ProcDict.AddObject(procName, TObject(@proc));
end;
 
procedure ExecuteProc(procName: string; arg: string);
var
  index: Integer;
begin
  index := ProcDict.IndexOf(ProcName);
  if index &gt;= 0 then
    MyProc(ProcDict.objects[index])(arg);
// Можно вставить обработку исключительной ситуации - сообщение об ошибке
end;
 
initialization
  ProcDict := TStringList.Create;
  ProcDict.Sorted := true;
finalization
  ProcDict.Free;
end.
</pre>


<p>вы могли бы создать StringList как показано ниже:</p>

<pre>
StringList.Create; StringList.AddObject('Proc1',@Proc1);
StringList.AddObject('Proc2',@Proc2); 
</pre>

<p>и затем реализовать это в вашей программе:</p>

<pre>
var
  myFunc: procedure;
begin
  if Stringlist.indexof(S) = -1 then
    MessageDlg('Не понял процедуру ' + S, mtError, [mbOk], 0)
  else
    begin
      @myFunc := Stringlist.Objects[Stringlist.indexof(S)];
      myFunc;
    end;
</pre>


<p>RAM</p>
<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>

