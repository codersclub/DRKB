<h1>Как вызвать функцию по имени?</h1>
<div class="date">01.01.2007</div>


<p>есть такой способ вызова функций по имени, если они совпадают по сигнатуре:<br>
<pre>
function TestFunc1(d: Double): Integer;
begin
  ....
end;
 
function TestFunc2(d: Double): Integer;
begin
  ....
end;
 
exports 
  TestFunc1,
  TestFunc2;
 
procedure TForm1.Button1Click(Sender: TObject);
var
  Func: function (d: Double): Integer;
begin
  @Func := GetProcAddress(hInstance, PChar(Edit1.Text));
  if @Func = nil then 
    raise Exception.CreateFmt('Функция с именем "%s" не существует', [Edit1.Text]);
  ShowMessage(IntToStr(Func(10.63)));
end;
</pre>
<p class="author">Автор: jack128 </p>
