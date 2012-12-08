---
Title: Linked List Memory Table
Date: 01.01.2007
---


Linked List Memory Table
========================

::: {.date}
01.01.2007
:::

    unit Unit1;
     
     interface
     
     uses
       Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
       StdCtrls;
     
     type
       TMyObjectPtr = ^TMyObject;
       TMyObject = record
         First_Name: String[20];
         Last_Name: String[20];
         Next: TMyObjectPtr;
       end;
     
     type
       TForm1 = class(TForm)
         bSortByLastName: TButton;
         bDisplay: TButton;
         bPopulate: TButton;
         ListBox1: TListBox;
         bClear: TButton;
         procedure bSortByLastNameClick(Sender: TObject);
         procedure bPopulateClick(Sender: TObject);
         procedure bDisplayClick(Sender: TObject);
         procedure bClearClick(Sender: TObject);
       private
         { Private declarations }
       public
         { Public declarations }
       end;
     
     var
       Form1: TForm1;
       pStartOfList: TMyObjectPtr = nil;
     
     {List manipulation routines}
     procedure SortMyObjectListByLastName(var aStartOfList: TMyObjectPtr);
     function CreateMyObject(aFirstName, aLastName: String): TMyObjectPtr;
     procedure AppendMyObject(var aCurrentItem, aNewItem: TMyObjectPtr);
     procedure ClearMyObjectList(var aMyObject: TMyObjectPtr);
     procedure RemoveMyObject(var aStartOfList, aRemoveMe: TMyObjectPtr);
     function AreInAlphaOrder(aString1, aString2: String): Boolean;
     
     
     implementation
     
     {$R *.DFM}
     
     
     procedure TForm1.bClearClick(Sender: TObject);
     begin
       ClearMyObjectList(pStartOfList);
     end;
     
     procedure TForm1.bPopulateClick(Sender: TObject);
     var
       pNew: TMyObjectPtr;
     begin
       {Initialize the list with some static data}
       pNew := CreateMyObject('Suzy','Martinez');
       AppendMyObject(pStartOfList, pNew);
       pNew := CreateMyObject('John','Sanchez');
       AppendMyObject(pStartOfList, pNew);
       pNew := CreateMyObject('Mike','Rodriguez');
       AppendMyObject(pStartOfList, pNew);
       pNew := CreateMyObject('Mary','Sosa');
       AppendMyObject(pStartOfList, pNew);
       pNew := CreateMyObject('Betty','Hayek');
       AppendMyObject(pStartOfList, pNew);
       pNew := CreateMyObject('Luke','Smith');
       AppendMyObject(pStartOfList, pNew);
       pNew := CreateMyObject('John','Sosa');
       AppendMyObject(pStartOfList, pNew);
     end;
     
     procedure TForm1.bSortByLastNameClick(Sender: TObject);
     begin
       SortMyObjectListByLastName(pStartOfList);
     end;
     
     procedure TForm1.bDisplayClick(Sender: TObject);
     var
       pTemp: TMyObjectPtr;
     begin
       {Display the list items}
       ListBox1.Items.Clear;
       pTemp := pStartOfList;
       while pTemp <> nil do
       begin
         ListBox1.Items.Add(pTemp^.Last_Name + ', ' + pTemp.First_Name);
         pTemp := pTemp^.Next;
       end;
     end;
     
     procedure ClearMyObjectList(var aMyObject: TMyObjectPtr);
     var
       TempMyObject: TMyObjectPtr;
     begin
       {Free the memory used by the list items}
       TempMyObject := aMyObject;
       while aMyObject <> nil do
       begin
         aMyObject := aMyObject^.Next;
         Dispose(TempMyObject);
         TempMyObject := aMyObject;
       end;
     end;
     
     function CreateMyObject(aFirstName, aLastName: String): TMyObjectPtr;
     begin
       {Instantiate a new list item}
       new(result);
       result^.First_Name := aFirstName;
       result^.Last_Name := aLastName;
       result^.Next := nil;
     end;
     
     procedure SortMyObjectListByLastName(var aStartOfList: TMyObjectPtr);
     var
       aSortedListStart, aSearch, aBest: TMyObjectPtr;
     begin
       {Sort the list by the Last_Name "field"}
       aSortedListStart := nil;
       while (aStartOfList <> nil) do
       begin
         aSearch := aStartOfList;
         aBest := aSearch;
         while aSearch^.Next <> nil do
         begin
           if not AreInAlphaOrder(aBest^.Last_Name, aSearch^.Last_Name) then
             aBest := aSearch;
           aSearch := aSearch^.Next;
         end;
         RemoveMyObject(aStartOfList, aBest);
         AppendMyObject(aSortedListStart, aBest);
       end;
       aStartOfList := aSortedListStart;
     end;
     
     procedure AppendMyObject(var aCurrentItem, aNewItem: TMyObjectPtr);
     begin
       {Recursive function that appends the new item to the end of the list}
       if aCurrentItem = nil then
         aCurrentItem := aNewItem
       else
         AppendMyObject(aCurrentItem^.Next, aNewItem);
     end;
     
     procedure RemoveMyObject(var aStartOfList, aRemoveMe: TMyObjectPtr);
     var
       pTemp: TMyObjectPtr;
     begin
       {Removes a specific item from the list and collapses the empty spot.}
       pTemp := aStartOfList;
       if pTemp = aRemoveMe then
         aStartOfList := aStartOfList^.Next
       else
       begin
         while (pTemp^.Next <> aRemoveMe) and (pTemp^.Next <> nil) do
           pTemp := pTemp^.Next;
         if pTemp = nil then Exit; //Shouldn't ever happen 
        if pTemp^.Next = nil then Exit; //Shouldn't ever happen 
        pTemp^.Next := aRemoveMe^.Next;
       end;
       aRemoveMe^.Next := nil;
     end;
     
     function AreInAlphaOrder(aString1, aString2: String): Boolean;
     var
       i: Integer;
     begin
       {Returns True if aString1 should come before aString2 in an alphabetic ascending sort}
       Result := True;
     
       while Length(aString2) < Length(aString1) do  aString2 := aString2 + '!';
       while Length(aString1) < Length(aString2) do  aString1 := aString1 + '!';
     
       for i := 1 to Length(aString1) do
       begin
         if aString1[i] > aString2[i] then Result := False;
         if aString1[i] <> aString2[i] then break;
       end;
     end;
     
     end.

Взято с сайта: <https://www.swissdelphicenter.ch>

 
