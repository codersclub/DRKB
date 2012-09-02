<h1>Как получить описание кода, полученного GetLastError?</h1>
<div class="date">01.01.2007</div>


<p>Функция RTL SysErrorMessage(GetLastError).</p>

<pre>
procedure TForm1.Button1Click(Sender: TObject);
begin
 {Cause a Windows system error message to be logged}
  ShowMessage(IntToStr(lStrLen(nil)));
  ShowMessage(SysErrorMessage(GetLastError));
end;
</pre>


