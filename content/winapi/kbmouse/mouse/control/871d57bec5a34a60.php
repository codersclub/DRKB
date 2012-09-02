<h1>Получить диапазон, прокручиваемый колесиком мышки</h1>
<div class="date">01.01.2007</div>


<pre>
//Not supported on Windows 95 
//result = -1: scroll whole page 
 
function GetNumScrollLines: Integer;
 begin
   SystemParametersInfo(SPI_GETWHEELSCROLLLINES, 0, @Result, 0);
 end;
 
 procedure TForm1.Button1Click(Sender: TObject);
 begin
   ShowMessage(IntToStr(GetNumScrollLines));
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
