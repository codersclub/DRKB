<h1>функции для изменения и получения чуствительности мышки</h1>
<div class="date">01.01.2007</div>


<pre>
Function SetMouseSpeed ( NewSpeed : Integer ) : Boolean;

 
begin
 Result := SystemParametersInfo(SPI_SETMOUSESPEED, 1, Pointer(NewSpeed), SPIF_SENDCHANGE );
End;
 
Function GetMouseSpeed : Integer;
Var
 Int : Integer;
begin
 SystemParametersInfo(SPI_GETMOUSESPEED, 0, @Int, SPIF_SENDCHANGE );
 Result := Int;
End;
</pre>

<p class="author">Автор: Radmin</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
