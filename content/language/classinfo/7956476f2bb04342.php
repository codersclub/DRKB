<h1>Как выполнить метод по его имени?</h1>
<div class="date">01.01.2007</div>



<pre>
{ ... }
type
  PYourMethod = ^TYourMethod;
  TYourMethod = procedure(S: string) of Object;
 
 
procedure TMainForm.Button1Click(Sender: TObject);
begin
  ExecMethodByName('SomeMethod');
end;
 
 
procedure TMainForm.ExecMethodByName(AName: string);
var
  PAddr: PYourMethod;
  M: TMethod;
begin
  PAddr := MethodAddress(AName);
  if PAddr &lt;&gt; nil then
  begin
    M.Code := PAddr;
    M.Data := Self;
    TYourMethod(M)('hello');
  end;
end;
 
 
procedure TMainForm.SomeMethod(S: string);
begin
  ShowMessage(S);
end; 
</pre>

<p>Tip by Sasan Adami</p>
<p>Взято из <a href="https://www.lmc-mediaagentur.de/dpool" target="_blank">https://www.lmc-mediaagentur.de/dpool</a></p>
