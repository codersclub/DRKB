<h1>Определить количество кнопок мышки</h1>
<div class="date">01.01.2007</div>


<pre>
// if the result is 0, no mouse is present 
 
function GetNumberOfMouseButtons: Integer;
 begin
   Result := GetSysTemMetrics(SM_CMOUSEBUTTONS);
 end;
 
 procedure TForm1.Button1Click(Sender: TObject);
 begin
   ShowMessage('Your mouse has ' + IntToStr(GetNumberOfMouseButtons) + ' buttons.');
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
