<h1>Как самому определить метод сортировки TStringList?</h1>
<div class="date">01.01.2007</div>


<pre>
{ 
  Suppose you have a TListBox containing some date values. 
  If you want to sort the dates by setting the "Sorted" 
  property to "True" you will see that the dates are not sorted correctly: 
 
  12.03.2003 
  13.03.2003 
  29.01.2003 
  30.03.2003 
 
  Now what you can do is to is create a TStringlist, Assign the listbox.Items 
  property to it, sort the stringlist using CustomSort, 
  then Assign it back to listbox.items. 
}
 
 
 function CompareDates(List: TStringList; Index1, Index2: Integer): Integer;
 var
   d1, d2: TDateTime;
 begin
   d1 := StrToDate(List[Index1]);
   d2 := StrToDate(List[Index2]);
   if d1 &lt; d2 then
     Result := -1
   else if d1 &gt; d2 then Result := 1
   else
     Result := 0;
 end;
 
 procedure TForm1.Button1Click(Sender: TObject);
 var
   sl: TStringList;
 begin
   sl := TStringList.Create;
   try
     // listbox1.Sorted := False ! 
    sl.Assign(listbox1.Items);
     sl.CustomSort(CompareDates);
     listbox1.Items.Assign(sl);
   finally
     sl.Free
   end;
 end;
 
 end.
 
 
 {********************************************************************}
 { To sort Integer values:}
 
 function CompareInt(List: TStringList; Index1, Index2: Integer): Integer;
 var
   d1, d2: Integer;
   r1, r2: Boolean;
 
   function IsInt(AString : string; var AInteger : Integer): Boolean;
   var
     Code: Integer;
   begin
     Val(AString, AInteger, Code);
     Result := (Code = 0);
   end;
 
 begin
   r1 :=  IsInt(List[Index1], d1);
   r2 :=  IsInt(List[Index2], d2);
   Result := ord(r1 or r2);
   if Result &lt;&gt; 0 then
   begin
     if d1 &lt; d2 then
       Result := -1
     else if d1 &gt; d2 then
       Result := 1
     else
      Result := 0;
   end else
    Result := lstrcmp(PChar(List[Index1]), PChar(List[Index2]));
 end;
 
 procedure TForm1.Button1Click(Sender: TObject);
 var
   sl: TStringList;
 begin
   sl := TStringList.Create;
   try
     // listbox1.Sorted := False; 
    sl.Assign(listbox1.Items);
     sl.CustomSort(CompareInt);
     listbox1.Items.Assign(sl);
   finally
     sl.Free;
   end;
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
