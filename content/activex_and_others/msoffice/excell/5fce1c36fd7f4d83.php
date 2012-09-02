<h1>Как снять пароль с Excel файла?</h1>
<div class="date">01.01.2007</div>


<pre>
{
Today I want to show how you may load some xls-file that is 
password-protected, and how to save xls into another file 
but without protection.
Just replace there file names and password...
}
 
var
xls, xlw: Variant;
begin
{load MS Excel}
xls := CreateOLEObject('Excel.Application');
 
{open your xls-file}
xlw := xls.WorkBooks.Open(FileName := 'd:\book1.xls', Password := 'qq', ReadOnly := True);
{save with other file name}
xlw.SaveAs(FileName := 'd:\book2.xls', Password := '');
 
{unload MS Excel}
xlw := UnAssigned;
xls := UnAssigned;
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
