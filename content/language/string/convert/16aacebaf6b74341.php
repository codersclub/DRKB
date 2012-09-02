<h1>Отобразить строку на определенную структуру</h1>
<div class="date">01.01.2007</div>


<pre>
type
  TEmployee = record 
    cNo: array [0..3] of Char; 
    cName: array [0..7] of Char; 
  end; 
  PEmployee = ^TEmployee; 
 
procedure ParseData; 
const 
  sData = '0001Mosquito'; 
var 
  sNo, sName: string; 
begin 
  with PEmployee(Pointer((@sData)^))^ do  
  begin 
    sNo   := cNo;      // sNo = '0001' 
    sName := cName;    // sName = 'Mosquito' 
  end 
end;
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>
