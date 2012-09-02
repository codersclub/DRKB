<h1>Как узнать имя компьютера?</h1>
<div class="date">01.01.2007</div>


<pre>
Uses Libc;
 
Function GetPCName:string;
var Name:PChar;
    Len:Cardinal;
begin
  Len:=255;
  GetMem(Name, Len);
  gethostname(Name, Len);
  Result:=String(Name);
  FreeMem(Name);
end;
</pre>

<p class="author">Автор: Vit</p>

