<h1>Использование DynArrayFromVariant</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);
 type
   T2DIntArray = array of array of Integer;
 var
   DynArray: T2DIntArray;
   V: Variant;
   i, k: Integer;
 begin
   V := VarArrayCreate([0, 1, 0, 1], varInteger);
   V[0, 0] := 00;
   V[0, 1] := 01;
   V[1, 0] := 10;
   V[1, 1] := 11;
   DynArrayFromVariant(Pointer(Dynarray), V, TypeInfo(T2DIntArray));
   for i := 0 to High(Dynarray) do
     for k := 0 to High(Dynarray[i]) do
       memo1.Lines.add(IntToStr(DynArray[i, k]));
 end;
 
 { 
  The problem with DynArrayFromVariant is that you can only use it on 
  variant arrays with 0-based indexes, trying to use it on an array with 1 
  as lower bound blows up. Since the documentation is silent on that i 
  would consider it a bug. 
}
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
&nbsp;</p>
