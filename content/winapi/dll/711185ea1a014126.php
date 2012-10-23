<h1>Определение функции в DLL</h1>
<div class="date">01.01.2007</div>


<p>Данная функция определяет присутствие нужной функции в библиотеке (dll) и, в случае нахождения искомой функции возвращает True, иначе False.</p>
<pre>
function FuncAvail (VLibraryname, VFunctionname: string; var VPointer: pointer): 
boolean; 
var 
  Vlib: tHandle; 
begin 
  Result := false; 
  VPointer := NIL; 
   if LoadLibrary(PChar(VLibraryname)) = 0 then 
      exit; 
   VPointer := GetModuleHandle(PChar(VLibraryname)); 
   if Vlib &lt;&gt; 0 then 
   begin 
    VPointer := GetProcAddress(Vlib, PChar(VFunctionname)); 
    if VPointer &lt;&gt; NIL then 
       Result := true; 
   end; 
end; 
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

