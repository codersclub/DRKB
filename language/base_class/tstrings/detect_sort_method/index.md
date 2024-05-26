---
Title: Как самому определить метод сортировки TStringList?
Date: 01.04.2004
Source: <https://www.swissdelphicenter.ch>
---


Как самому определить метод сортировки TStringList?
===================================================

Предположим, у вас есть TListBox, содержащий некоторые значения дат.
Если вы хотите отсортировать даты, установив параметр «Sorted»
для свойства «True», вы увидите, что даты отсортированы неправильно:

    12.03.2003
    13.03.2003
    29.01.2003
    30.03.2003

Теперь вы можете создать список TStringlist, назначить список.
присвоить ему свойство Items, отсортировать список строк с помощью CustomSort,
затем назначить его обратно в listbox.items.

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
      if d1 < d2 then
        Result := -1
      else if d1 > d2 then Result := 1
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
      if Result <> 0 then
      begin
        if d1 < d2 then
          Result := -1
        else if d1 > d2 then
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

